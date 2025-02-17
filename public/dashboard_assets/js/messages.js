let chatPage = 1;
let page = 0;
$(document).ready(function () {
    var conversationId = $('.conversations').find('.active').attr('id')?.replace('chat-', '');
    getMessageAjax(conversationId);

    $('#search_msg').on('keyup', searchUserAjax);
    
    $('.chat-container').on('scroll', function () {
        var container = $(this);
        if (container.scrollTop() === 0) {
            var conversationId = $('.conversations').find('.active').attr('id')?.replace('chat-', '');
            getMessageAjax(conversationId);
        }
    });
});

function getMessageAjax(conversationId) {
    let requestUrl = getMessagesRoute
        .replace(':conversation_id', conversationId)
        .replace(':page', page);

    $.ajax({
        url: requestUrl,
        method: "GET",
        beforeSend: function () {
            $('.loader').show();
        },
        success: function (response) {
            setTimeout(function () {
                var messages = response.messages;
                messages.forEach(function (message) {
                    let isMe = message.sender.id == userId ? 'msg_from' : 'msg_to';
                    let messageHtml = `
                    <div class="msg ${isMe}">
                        <div class="info">
                            <h4>
                                <img src="dashboard_assets/images/thumb.png" alt="">
                                <span class="ext">${message.sender.name}</span>
                                <span class="time">${timeAgo(message.created_at)}</span>
                            </h4>
                        </div>
                        <div class="txt">
                            ${message.message}
                        </div>
                    </div>
                `;
                    $('.chat-container').prepend(messageHtml);
                });
                $('.loader').hide();
                page++;
            }, 2000);
        },
        error: function (error) {
            console.error("Error fetching messages:", error);
        },
    });
}

function timeAgo(createdAt) {
    const now = new Date();
    const createdDate = new Date(createdAt);

    const diffInSeconds = Math.floor((now - createdDate) / 1000);
    const diffInMinutes = Math.floor(diffInSeconds / 60);
    const diffInHours = Math.floor(diffInMinutes / 60);
    const diffInDays = Math.floor(diffInHours / 24);

    if (diffInSeconds < 60) {
        return `${diffInSeconds} second${diffInSeconds === 1 ? '' : 's'} ago`;
    } else if (diffInMinutes < 60) {
        return `${diffInMinutes} minute${diffInMinutes === 1 ? '' : 's'} ago`;
    } else if (diffInHours < 24) {
        return `${diffInHours} hour${diffInHours === 1 ? '' : 's'} ago`;
    } else if (diffInDays < 30) {
        return `${diffInDays} day${diffInDays === 1 ? '' : 's'} ago`;
    } else {
        return createdDate.toLocaleDateString();
    }
}

function searchUserAjax() {
    const query = $(this).val().trim();

    if (query.length < 1) return;
}