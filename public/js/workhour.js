$(document).ready(function () {
    let input_create_workday_date = $('#db-input-create-workday-date')
    let button_create_workday = $('#db-button-create-workday')
    let container_workdays = $('#db-container-workdays');

    button_create_workday.on('click', function () {
        $.ajax({
            url: "/workhour/create",
            method: "post",
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            data: {
                date: input_create_workday_date.val()
            },

            success: function (response) {
                container_workdays.prepend(response.html)

                UIkit.notification({
                    message: response.message,
                    status: 'success',
                    pos: 'top-right'
                });
            },
        });
    })

    function create_workday(date) {

    }

    $('.db-icon-delete-workhour').on('click', function (event) {
        event.preventDefault()

        let workhour_id = $(this).data('workhour-id');
        let workhour_date = $(this).data('workhour-date');

        $.ajax({
            url: "/workhour/delete",
            method: "post",
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            data: {
                id: workhour_id
            },

            success: function (response) {
                $('[data-workhour-id="' + workhour_id + '"]').parent().remove();
                $('#db-workhours-total-' + workhour_date).text(get_workday_total_hours(workhour_date));

                UIkit.notification({
                    message: response.message,
                    status: 'success',
                    pos: 'top-right'
                });
            },
        });
    })
    
    
    function get_workday_total_hours(workhour_date) {
        let total_hours = 0;

        $('.db-workday-hour[data-workhour-date="' + workhour_date + '"]').each(function() {
            let value = parseInt($(this).text());
            if (!isNaN(value)) {
                total_hours += value;
            }
        });

        return total_hours;
    }
});
