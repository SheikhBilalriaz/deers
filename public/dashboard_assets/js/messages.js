var chats = [];
let chatPagination = 0;
let loadingChats = false;
let noMoreChats = false;

var messages = [];
let messagePagination = 0;
let loadingMessages = false;
let noMoreMessages = false;

var users = [];
var currentConversation = null;
var currentUser = null;

$(document).on('click', '.user-list li', async function () {
    $('.conversations').find('.active').removeClass('active');
    $('.chat-container').html(``);
    const userId = $(this).attr('id');
    currentUser = userId;
    if (userId) {
        await fetchChatByUserAjax(userId);
    }
});

$(document).on('click', '.conversations li', async function () {
    if ($(this).hasClass('active') || loadingMessages) {
        return;
    }
    $('.conversations').find('li.active').removeClass('active');
    $(this).addClass('active');
    $(this).find('.notif').remove();
    messagePagination = 0;
    noMoreMessages = false;
    const conversation_id = $(this).attr('id');
    currentConversation = conversation_id;
    const conversation = chats.find(chat => chat.id == conversation_id);
    updateReceiverInfo(conversation.participants_except_me);
    $('.chat-container').html(``);
    if (conversation_id && !noMoreMessages) {
        await fetchMessagesAjax(conversation_id);
    }
});

$(document).ready(async function () {
    await fetchUsersAjax();

    $('#addMemberModal').on('shown.bs.modal', async function () {
        $('#search_user').val(``);
        await fetchUsersAjax();
    });

    $('#search_user').on('input', filterUsers);

    if (!loadingChats && !noMoreChats) {
        await fetchChatsAjax();
        if ($('.conversations li').length > 0) {
            $('.conversations li').first().click();
        }
    }

    $('#chat_conversation_sidebar').on('scroll', async function () {
        if ((($(this).scrollTop() + $(this).innerHeight()) >= $(this)[0].scrollHeight) && !loadingChats && !noMoreChats) {
            await fetchChatsAjax();
        }
    });

    $('.chat-container').on('scroll', async function () {
        if ($(this).scrollTop() == 0 && !loadingMessages && !noMoreMessages) {
            const conversation_id = $('.conversations li.active').attr('id');
            await fetchMessagesAjax(conversation_id);
        }
    });

    setInterval(async function () {
        if (!loadingMessages) {
            await fetchRecentMessagesAjax(currentConversation);
        }
    }, 1000);

    $('#send-message').on('submit', async function (e) {
        e.preventDefault();

        $(this).find('.btn_send').prop('disabled', true);
        await sendMessageAjax($(this));
        $(this).find('.btn_send').prop('disabled', false);
    });

    $('#search_chat').on('input', filterChats);

    setInterval(async function () {
        await fetchRecentChatsAjax();
    }, 1000);
});

function fetchChatsAjax() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: `/fetch-chats/${chatPagination}`,
            method: "GET",
            dataType: "json",
            beforeSend: () => {
                $('#chatListLoader').show();
                loadingChats = true;
            },
            success: (response) => {
                // Exit if the response is unsuccessful
                if (!response.success) {
                    resolve();
                    return;
                }

                if (!Array.isArray(chats)) {
                    chats = [];
                }

                const responseChats = response.chats;

                // Check if there are no more chats to fetch
                if (responseChats.length <= 0) {
                    noMoreChats = true;
                    resolve();
                    return;
                }

                responseChats.forEach((chat, index) => {
                    // Check if the chat already exists in the chats array
                    const searchInChats = chats.find(conver => conver.id == chat.id);

                    // If the chat is not found, add it to the chats array
                    if (!searchInChats) {
                        chats.push(chat);
                    }

                    // Extract participants except the logged-in user
                    const participants = chat.participants_except_me.map((participant) => {
                        return {
                            name: participant.user.name ?? 'Unknown',
                            email: participant.user.email ?? 'No email',
                            profile: participant.user.profile_image
                                ? `storage/profiles/${participant.user.profile_image}`
                                : 'storage/profiles/default_profile.png',
                        };
                    });

                    // Get participant details separately
                    const participantNames = participants.map(participant => participant.name);
                    const participantEmails = participants.map(participant => participant.email);
                    const participantImages = participants.map(participant => participant.profile);
                    const count = participants.length;

                    let profileImagesHTML = ``;
                    let profileNamesHTML = ``;
                    let profileEmailsHTML = ``;

                    // Render participant details based on count
                    if (count == 1) {
                        profileImagesHTML += `<img src="${participantImages[0]}" alt="">`;
                        profileNamesHTML += participantNames[0];
                        profileEmailsHTML += participantEmails[0];
                    } else if (count == 2) {
                        profileImagesHTML += `
                                <div class="stacked-images">
                                    <img src="${participantImages[0]}" class="profile-img">
                                    <img src="${participantImages[1]}" class="profile-img">
                                </div>
                            `;
                        profileNamesHTML += participantNames.join(' & ');
                        profileEmailsHTML += participantEmails.join(' & ');
                    } else if (count > 2) {
                        profileImagesHTML += `
                                <div class="stacked-images">
                                    ${participantImages.slice(0, 3).map(img => `<img src="${img}" class="profile-img">`).join('')}
                                </div>
                            `;
                        profileNamesHTML += `${participantNames[0]}, ${participantNames[1]} & more...`;
                        profileEmailsHTML += `${participantEmails[0]}, ${participantEmails[1]} & more...`;
                    } else {
                        profileNamesHTML = profileEmailsHTML = `No participants`;
                    }

                    // Display unread messages count if available
                    let unreadMessagesHTML = chat.unread_messages.length > 0
                        ? `<span class="notif">${chat.unread_messages.length}</span>`
                        : ``;

                    // Construct chat list item
                    let chatHTML = `
                            <li id="${chat.id}">
                                <a href="javascript:;">
                                    <div class="info">
                                        <div class="profile-stack">${profileImagesHTML}</div>
                                        <h4>${profileNamesHTML}</h4>
                                        <p>${profileEmailsHTML}</p>
                                    </div>
                                    <div class="time_ago">
                                        <span class="time">${timeAgo(chat.last_message?.created_at)}</span>
                                        ${unreadMessagesHTML}
                                    </div>
                                </a>
                            </li>
                        `;

                    // Append chat item to the conversation list
                    $('.conversations').append(chatHTML);
                });

                // Increase pagination counter for next batch
                chatPagination++;
                resolve();
            },
            error: (xhr) => {
                console.error("AJAX Error:", xhr.responseJSON?.message);
                reject(xhr);
            },
            complete: () => {
                $('#chatListLoader').hide();
                loadingChats = false;
            },
        });
    });
} //Done

function fetchUsersAjax() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '/fetch-users',
            method: "GET",
            dataType: "json",
            beforeSend: () => $('#userListLoader').show(),
            success: (response) => {
                if (!response.success) {
                    $('.user-list').html(`<li class="no-user-found">No User matched</li>`);
                    users = [];
                    resolve();
                    return;
                }

                let $usersHTML = response.users.map((user) => {
                    const searchInUsers = users.find(userToSearch => userToSearch.id == user.id);

                    if (!searchInUsers) {
                        users.push(user);
                    }

                    return `
                        <li class="user-item" id="${user.id}">
                            <a>
                                <div class="info">
                                    <img src="${user?.profile_image
                            ? `/storage/profiles/${user.profile_image}`
                            : `/storage/profiles/default_profile.png`}" alt="Profile">
                                    <h4>${user.name}</h4>
                                </div>
                            </a>
                        </li>
                    `;
                }).join('');

                $('.user-list').html($usersHTML);
                resolve();
            },
            error: (xhr) => {
                console.error("AJAX Error:", xhr.responseJSON?.message);
                reject(xhr);
            },
            complete: () => {
                $('#userListLoader').hide();
            },
        });
    });
} //Done

function fetchMessagesAjax(conversation_id) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: `/fetch-messages/${conversation_id}/${messagePagination}`,
            method: "GET",
            dataType: "json",
            beforeSend: () => {
                $('#messageListLoader').show();
                loadingMessages = true;
            },
            success: (response) => {
                if (!response.success) {
                    resolve();
                    return;
                }
                const responseMessages = response.messages;
                if (responseMessages.length <= 0) {
                    noMoreMessages = true;
                    resolve();
                    return;
                }

                responseMessages.forEach((message, index) => {
                    let isYou = users.find(user => user.id == message.sender.id) ? 'msg_to' : 'msg_from';
                    let profileImage = message.sender.profile_image
                        ? `/storage/profiles/${message.sender.profile_image}`
                        : `/storage/profiles/default_profile.png`;

                    let fileAttachments = '';
                    if (message.files && message.files.length > 0) {
                        fileAttachments = message.files
                            .map((file) => {
                                let fileUrl = `/storage/${file.file_path}`;
                                let fileType = file.file_type.startsWith('image')
                                    ? `<img src="${fileUrl}" alt="${file.file_name}" class="message-image" style="max-width: 200px; border-radius: 5px;">`
                                    : `<a href="${fileUrl}" target="_blank">${file.file_name}</a>`;

                                return `<div class="file-preview">${fileType}</div>`;
                            })
                            .join('');
                    }

                    let innerMessageHtml = message.message ?
                        `<div class='txt'>${fileAttachments ?? ''}${message.message}</div>` :
                        `<div>${fileAttachments ?? ''}</div>`;

                    let messageHtml = `
                            <div id="${message.id}" class="msg ${isYou}">
                                <div class="info">
                                    <h4>
                                        <img src="${profileImage}" alt="">
                                        <span class="ext">${message.sender.name}</span>
                                        <span class="time">${timeAgo(message.created_at)}</span>
                                    </h4>
                                </div>
                                ${innerMessageHtml}
                            </div>
                        `;

                    $('.chat-container').prepend(messageHtml);
                });
                messagePagination++;
                resolve();
            },
            error: (xhr) => {
                console.error("AJAX Error:", xhr.responseJSON?.message);
                reject(xhr);
            },
            complete: () => {
                $('#messageListLoader').hide();
                loadingMessages = false;
            },
        });
    });
} //Done

async function filterUsers() {
    $('#userListLoader').show();

    if (!users || users.length === 0) {
        await fetchUsersAjax();
        $('#search_user').val('');
        return;
    }

    const value = $('#search_user').val().trim().toLowerCase();

    let $usersHTML = users.map((user) => {
        if (!user.name.toLowerCase().includes(value)) {
            return '';
        }

        return `
            <li class="user-item" id="${user.id}">
                <a>
                    <div class="info">
                        <img src="${user?.profile_image
                ? `/storage/profiles/${user.profile_image}`
                : `/storage/profiles/default_profile.png`}" alt="Profile">
                        <h4>${user.name}</h4>
                    </div>
                </a>
            </li>
        `;
    }).join('');

    $('#userListLoader').hide();

    if ($usersHTML == '') {
        $('.user-list').html(`<li class="no-user-found">No User matched</li>`);
        return;
    }

    $('.user-list').html($usersHTML);
} //Done

async function fetchChatByUserAjax(userId) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: `/fetch-user-chat/${userId}`,
            method: "GET",
            dataType: "json",
            beforeSend: () => {
                $('#messageLoader').show();
                loadingMessages = true;
            },
            success: async (response) => {
                $("#addMemberModal .close").click();

                if (!response.success) {
                    resolve();
                    return;
                }
                const currentUser = users.find(user => user.id == userId);

                $('#receiver_name').html(currentUser?.name || 'Unknown');
                $('#receiver_email').html(currentUser?.email || 'No email');
                let profileImage = currentUser?.profile_image
                    ? `/storage/profiles/${currentUser.profile_image}`
                    : `/storage/profiles/default_profile.png`;
                $('#profile_images').html(`<img src="${profileImage}" alt="Profile">`);

                const responseChats = response.chat;
                if (!responseChats) {
                    currentConversation = null;
                    resolve();
                    return;
                }

                try {
                    $(`.conversations li#${responseChats.id}`).addClass('active');
                    $(`.conversations li#${responseChats.id}`).find('.notif').remove();
                    currentConversation = responseChats.id;
                    await fetchMessagesAjax(responseChats.id);
                    resolve(responseChats);
                } catch (error) {
                    console.error("Error fetching messages:", error);
                    reject(error);
                }
            },
            error: (xhr) => {
                console.error("AJAX Error:", xhr.responseJSON?.message);
                reject(xhr);
            },
            complete: () => {
                loadingMessages = false;
                $('#messageLoader').hide();
            },
        });
    });
} //Done

function updateReceiverInfo(participants) {
    let users = participants.map(({ user }) => ({
        name: user?.name || 'Unknown',
        email: user?.email || 'No email',
        profile: user?.profile_image
            ? `/storage/profiles/${user.profile_image}`
            : `/storage/profiles/default_profile.png`
    }));

    $('#profile_images').html(generateImageHtml(users));

    let names = users.map(u => u.name);
    let emails = users.map(u => u.email);

    $('#receiver_name').html(names.length > 2 ? `${names[0]}, ${names[1]} & more...` : names.join(' & ') || 'No participants');
    $('#receiver_email').html(emails.length > 2 ? `${emails[0]}, ${emails[1]} & more...` : emails.join(' & ') || 'No participants');
} //Done

function timeAgo(createdAt) {
    const seconds = Math.floor((new Date() - new Date(createdAt)) / 1000);
    const intervals = [
        { label: "year", seconds: 31536000 },
        { label: "month", seconds: 2592000 },
        { label: "day", seconds: 86400 },
        { label: "hour", seconds: 3600 },
        { label: "minute", seconds: 60 },
        { label: "second", seconds: 1 }
    ];

    for (let { label, seconds: unit } of intervals) {
        let value = Math.floor(seconds / unit);
        if (value >= 1) return `${value} ${label}${value > 1 ? 's' : ''} ago`;
    }
    return "just now";
} //Done

function generateImageHtml(users) {
    if (users.length == 1) {
        return `<img src="${users[0].profile}" alt="">`;
    }

    let images = users.slice(0, 3).map(user => `<img src="${user.profile}" class="profile-img">`).join('');

    return `<div class="stacked-images">${images}</div>`;
} //Done

function fetchRecentMessagesAjax(conversation_id) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: `/fetch-recent-messages/${conversation_id}`,
            method: "GET",
            success: (response) => {
                if (!response.success) {
                    resolve();
                    return;
                }
                const responseMessages = response.messages;
                if (responseMessages.length <= 0) {
                    resolve();
                    return;
                }

                responseMessages.forEach((message, index) => {
                    let isYou = users.find(user => user.id == message.sender.id) ? 'msg_to' : 'msg_from';
                    let profileImage = message.sender.profile_image
                        ? `/storage/profiles/${message.sender.profile_image}`
                        : `/storage/profiles/default_profile.png`;

                    let fileAttachments = '';
                    if (message.files && message.files.length > 0) {
                        fileAttachments = message.files
                            .map((file) => {
                                let fileUrl = `/storage/${file.file_path}`;
                                let fileType = file.file_type.startsWith('image')
                                    ? `<img src="${fileUrl}" alt="${file.file_name}" class="message-image" style="max-width: 200px; border-radius: 5px;">`
                                    : `<a href="${fileUrl}" target="_blank">${file.file_name}</a>`;

                                return `<div class="file-preview">${fileType}</div>`;
                            })
                            .join('');
                    }

                    let innerMessageHtml = message.message ?
                        `<div class='txt'>${fileAttachments ?? ''}${message.message}</div>` :
                        `<div>${fileAttachments ?? ''}</div>`;

                    let messageHtml = `
                            <div id="${message.id}" class="msg ${isYou}">
                                <div class="info">
                                    <h4>
                                        <img src="${profileImage}" alt="">
                                        <span class="ext">${message.sender.name}</span>
                                        <span class="time">${timeAgo(message.created_at)}</span>
                                    </h4>
                                </div>
                                ${innerMessageHtml}
                            </div>
                        `;

                    $('.chat-container').append(messageHtml);
                });
                const chatHTML = $(`.conversations li#${conversation_id}`);
                $(`.conversations li#${conversation_id}`).remove();
                $('.conversations').prepend(chatHTML);
                resolve();
            },
            error: (xhr) => {
                console.error("AJAX Error:", xhr.responseJSON?.message);
                reject(xhr);
            },
            complete: () => {
                loadingMessages = false;
            },
        });
    });
} //Done

function sendMessageAjax(form) {
    var formData = new FormData(form[0]);

    return new Promise((resolve, reject) => {
        $.ajax({
            url: `/send-message/${currentConversation ?? 0}/${currentUser ?? 0}`,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: () => {
                loadingMessages = true;
            },
            success: (response) => {
                if (!response.success) {
                    resolve();
                    return;
                }
                $('#typing').val(``);
                let { message, chat } = response;

                let isYou = message.sender_id == currentUser ? 'msg_to' : 'msg_from';
                let profileImage = message.sender.profile_image
                    ? `/storage/profiles/${message.sender.profile_image}`
                    : `/storage/profiles/default_profile.png`;

                let fileAttachments = '';
                if (message.files && message.files.length > 0) {
                    fileAttachments = message.files
                        .map((file) => {
                            let fileUrl = `/storage/${file.file_path}`;
                            let fileType = file.file_type.startsWith('image')
                                ? `<img src="${fileUrl}" alt="${file.file_name}" class="message-image" style="max-width: 200px; border-radius: 5px;">`
                                : `<a href="${fileUrl}" target="_blank">${file.file_name}</a>`;

                            return `<div class="file-preview">${fileType}</div>`;
                        })
                        .join('');
                }

                let innerMessageHtml = message.message ?
                    `<div class='txt'>${fileAttachments ?? ''}${message.message}</div>` :
                    `<div>${fileAttachments ?? ''}</div>`;

                let messageHtml = `
                            <div id="${message.id}" class="msg ${isYou}">
                                <div class="info">
                                    <h4>
                                        <img src="${profileImage}" alt="">
                                        <span class="ext">${message.sender.name}</span>
                                        <span class="time">${timeAgo(message.created_at)}</span>
                                    </h4>
                                </div>
                                ${innerMessageHtml}
                            </div>
                        `;

                $('.chat-container').append(messageHtml);
                $('.chat-container').scrollTop($('.chat-container').prop("scrollHeight"));
                const chatHTML = $(`.conversations li#${chat.id}`);
                if (chatHTML.length > 0) {
                    $(`.conversations li#${chat.id}`).remove();
                    $('.conversations').prepend(chatHTML);
                } else {
                    // Check if the chat already exists in the chats array
                    const searchInChats = chats.find(conver => conver.id == chat.id);

                    // If the chat is not found, add it to the chats array
                    if (!searchInChats) {
                        chats.push(chat);
                    }

                    // Extract participants except the logged-in user
                    const participants = chat.participants_except_me.map((participant) => {
                        return {
                            name: participant.user.name ?? 'Unknown',
                            email: participant.user.email ?? 'No email',
                            profile: participant.user.profile_image
                                ? `storage/profiles/${participant.user.profile_image}`
                                : 'storage/profiles/default_profile.png',
                        };
                    });

                    // Get participant details separately
                    const participantNames = participants.map(participant => participant.name);
                    const participantEmails = participants.map(participant => participant.email);
                    const participantImages = participants.map(participant => participant.profile);
                    const count = participants.length;

                    let profileImagesHTML = ``;
                    let profileNamesHTML = ``;
                    let profileEmailsHTML = ``;

                    // Render participant details based on count
                    if (count == 1) {
                        profileImagesHTML += `<img src="${participantImages[0]}" alt="">`;
                        profileNamesHTML += participantNames[0];
                        profileEmailsHTML += participantEmails[0];
                    } else if (count == 2) {
                        profileImagesHTML += `
                                <div class="stacked-images">
                                    <img src="${participantImages[0]}" class="profile-img">
                                    <img src="${participantImages[1]}" class="profile-img">
                                </div>
                            `;
                        profileNamesHTML += participantNames.join(' & ');
                        profileEmailsHTML += participantEmails.join(' & ');
                    } else if (count > 2) {
                        profileImagesHTML += `
                                <div class="stacked-images">
                                    ${participantImages.slice(0, 3).map(img => `<img src="${img}" class="profile-img">`).join('')}
                                </div>
                            `;
                        profileNamesHTML += `${participantNames[0]}, ${participantNames[1]} & more...`;
                        profileEmailsHTML += `${participantEmails[0]}, ${participantEmails[1]} & more...`;
                    } else {
                        profileNamesHTML = profileEmailsHTML = `No participants`;
                    }

                    // Display unread messages count if available
                    let unreadMessagesHTML = chat.unread_messages.length > 0
                        ? `<span class="notif">${chat.unread_messages.length}</span>`
                        : ``;

                    // Construct chat list item
                    let chatHTML = `
                            <li id="${chat.id}">
                                <a href="javascript:;">
                                    <div class="info">
                                        <div class="profile-stack">${profileImagesHTML}</div>
                                        <h4>${profileNamesHTML}</h4>
                                        <p>${profileEmailsHTML}</p>
                                    </div>
                                    <div class="time_ago">
                                        <span class="time">${timeAgo(chat.last_message?.created_at)}</span>
                                        ${unreadMessagesHTML}
                                    </div>
                                </a>
                            </li>
                        `;

                    // Append chat item to the conversation list
                    $('.conversations').prepend(chatHTML);
                    $(`.conversations li#${chat.id}`).addClass('active');
                }
                resolve();
            },
            error: (xhr) => {
                if (xhr.status == 400) {
                    alert(xhr.responseJSON?.message || "Something went wrong!");
                }
                console.error("AJAX Error:", xhr.responseJSON?.message);
                reject();
            },
            complete: () => {
                loadingMessages = false;
            },
        });
    });
} //Done

async function filterChats() {
    $('#chatListLoader').show();
    $('.conversations').empty();

    if (!chats || chats.length === 0) {
        await fetchChatsAjax();
        $('#search_chat').val('');
        $('#chatListLoader').hide();
        return;
    }

    const value = $('#search_chat').val().trim().toLowerCase();

    const filteredChats = chats.filter(chat =>
        chat.participants_except_me.some(participant =>
            participant.user.name.toLowerCase().includes(value)
        )
    );

    filteredChats.forEach(chat => {
        // Extract participant details
        const participants = chat.participants_except_me.map(participant => ({
            name: participant.user.name ?? 'Unknown',
            email: participant.user.email ?? 'No email',
            profile: participant.user.profile_image
                ? `storage/profiles/${participant.user.profile_image}`
                : 'storage/profiles/default_profile.png',
        }));

        const participantNames = participants.map(p => p.name);
        const participantEmails = participants.map(p => p.email);
        const participantImages = participants.map(p => p.profile);
        const count = participants.length;

        let profileImagesHTML = '';
        let profileNamesHTML = '';
        let profileEmailsHTML = '';

        if (count === 1) {
            profileImagesHTML = `<img src="${participantImages[0]}" alt="">`;
            profileNamesHTML = participantNames[0];
            profileEmailsHTML = participantEmails[0];
        } else if (count === 2) {
            profileImagesHTML = `
                <div class="stacked-images">
                    <img src="${participantImages[0]}" class="profile-img">
                    <img src="${participantImages[1]}" class="profile-img">
                </div>`;
            profileNamesHTML = participantNames.join(' & ');
            profileEmailsHTML = participantEmails.join(' & ');
        } else if (count > 2) {
            profileImagesHTML = `
                <div class="stacked-images">
                    ${participantImages.slice(0, 3).map(img => `<img src="${img}" class="profile-img">`).join('')}
                </div>`;
            profileNamesHTML = `${participantNames[0]}, ${participantNames[1]} & more...`;
            profileEmailsHTML = `${participantEmails[0]}, ${participantEmails[1]} & more...`;
        } else {
            profileNamesHTML = profileEmailsHTML = `No participants`;
        }

        const unreadMessagesHTML = chat.unread_messages.length > 0
            ? `<span class="notif">${chat.unread_messages.length}</span>`
            : '';

        const chatHTML = `
            <li id="${chat.id}" class=${currentConversation == chat.id ? 'active' : ''}>
                <a href="javascript:;">
                    <div class="info">
                        <div class="profile-stack">${profileImagesHTML}</div>
                        <h4>${profileNamesHTML}</h4>
                        <p>${profileEmailsHTML}</p>
                    </div>
                    <div class="time_ago">
                        <span class="time">${timeAgo(chat.last_message?.created_at)}</span>
                        ${unreadMessagesHTML}
                    </div>
                </a>
            </li>`;

        $('.conversations').append(chatHTML);
    });

    $('#chatListLoader').hide();
} //Done

function fetchRecentChatsAjax() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: `/fetch-recent-chats`,
            method: "GET",
            success: (response) => {
                // Exit if the response is unsuccessful
                if (!response.success) {
                    resolve();
                    return;
                }

                const responseChats = response.chats;

                if (responseChats.length <= 0) {
                    resolve();
                    return;
                }

                responseChats.forEach((chat, index) => {
                    // Check if the chat already exists in the chats array
                    const searchInChats = chats.find(conver => conver.id == chat.id);

                    // If the chat is not found, add it to the chats array
                    if (!searchInChats) {
                        chats.push(chat);
                    }

                    // Extract participants except the logged-in user
                    const participants = chat.participants_except_me.map((participant) => {
                        return {
                            name: participant.user.name ?? 'Unknown',
                            email: participant.user.email ?? 'No email',
                            profile: participant.user.profile_image
                                ? `storage/profiles/${participant.user.profile_image}`
                                : 'storage/profiles/default_profile.png',
                        };
                    });

                    // Get participant details separately
                    const participantNames = participants.map(participant => participant.name);
                    const participantEmails = participants.map(participant => participant.email);
                    const participantImages = participants.map(participant => participant.profile);
                    const count = participants.length;

                    let profileImagesHTML = ``;
                    let profileNamesHTML = ``;
                    let profileEmailsHTML = ``;

                    // Render participant details based on count
                    if (count == 1) {
                        profileImagesHTML += `<img src="${participantImages[0]}" alt="">`;
                        profileNamesHTML += participantNames[0];
                        profileEmailsHTML += participantEmails[0];
                    } else if (count == 2) {
                        profileImagesHTML += `
                                <div class="stacked-images">
                                    <img src="${participantImages[0]}" class="profile-img">
                                    <img src="${participantImages[1]}" class="profile-img">
                                </div>
                            `;
                        profileNamesHTML += participantNames.join(' & ');
                        profileEmailsHTML += participantEmails.join(' & ');
                    } else if (count > 2) {
                        profileImagesHTML += `
                                <div class="stacked-images">
                                    ${participantImages.slice(0, 3).map(img => `<img src="${img}" class="profile-img">`).join('')}
                                </div>
                            `;
                        profileNamesHTML += `${participantNames[0]}, ${participantNames[1]} & more...`;
                        profileEmailsHTML += `${participantEmails[0]}, ${participantEmails[1]} & more...`;
                    } else {
                        profileNamesHTML = profileEmailsHTML = `No participants`;
                    }

                    // Display unread messages count if available
                    let unreadMessagesHTML = chat.unread_messages.length > 0
                        ? `<span class="notif">${chat.unread_messages.length}</span>`
                        : ``;

                    // Construct chat list item
                    let chatHTML = `
                            <li id="${chat.id}">
                                <a href="javascript:;">
                                    <div class="info">
                                        <div class="profile-stack">${profileImagesHTML}</div>
                                        <h4>${profileNamesHTML}</h4>
                                        <p>${profileEmailsHTML}</p>
                                    </div>
                                    <div class="time_ago">
                                        <span class="time">${timeAgo(chat.last_message?.created_at)}</span>
                                        ${unreadMessagesHTML}
                                    </div>
                                </a>
                            </li>
                        `;

                    $(`.conversations li#${chat.id}`).remove();

                    $('.conversations').prepend(chatHTML);
                });

                resolve();
            },
            error: (xhr) => {
                console.error("AJAX Error:", xhr.responseJSON?.message);
                reject();
            },
        });
    });
} //Done