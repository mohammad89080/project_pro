// public/js/attendance.js

function startWork(userId) {
    $.ajax({
        type: 'POST',
        url: '/start-work',
        data: { user_id: userId },
        success: function(response) {
            alert(response.message);
        },
        error: function(error) {
            console.error('Error starting work:', error);
        }
    });
}

function endWork(userId) {
    $.ajax({
        type: 'POST',
        url: '/end-work',
        data: { user_id: userId },
        success: function(response) {
            alert(response.message);
        },
        error: function(error) {
            console.error('Error ending work:', error);
        }
    });
}
