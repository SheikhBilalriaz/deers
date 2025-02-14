let page = 0;
$(document).ready(function () {
    var conversationId = $('.conversations').find('.active').attr('id')?.replace('chat-', '');
    getMessageAjax(conversationId);
});

function getMessageAjax(conversationId) {
    let requestUrl = getMessagesRoute
        .replace(':conversation_id', conversationId)
        .replace(':page', page);

    $.ajax({
        url: requestUrl,
        method: "GET",
        success: function (response) {
            console.log(response);
        },
        error: function (error) {
            console.error("Error fetching messages:", error);
        },
    });
}