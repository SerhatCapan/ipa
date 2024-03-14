$(document).ready(function() {
    window.db_notification = function(response) {
        switch (response.success) {
            case true:
                UIkit.notification({
                    message: response.message,
                    status: 'success',
                    pos: 'top-right'
                });
                break;

            case false:
                UIkit.notification({
                    message: response.message,
                    status: 'danger',
                    pos: 'top-right'
                });
                break;
        }
    };
});
