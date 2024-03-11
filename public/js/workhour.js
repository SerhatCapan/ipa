$(document).ready(function () {
    // Passing options (with default options)
    let input_create_workday_date = $('#db-input-create-workday-date')
    let button_create_workday = $('#db-button-create-workday')
    let container_workdays = $('#db-container-workdays');

    button_create_workday.on('click', function () {
        $.ajax({
            url: "/workday/create",
            method: "post",
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            data: {
                date: input_create_workday_date.val()
            },

            success: function (response) {
                console.log(response)

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

                container_workdays.prepend(response.html)
            },
        });
    })

    $(document).on('click', '.db-icon-delete-workhour', function(event) {
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

    $(document).on('change', '.db-select-workhour-costcenter', function(event) {
        let id_costcenter = $(this).val();
        let id = $(this).data('workhour-id')

        console.log(id + ' ' + id_costcenter)

        $.ajax({
            url: "/workhour/update",
            method: "post",
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            data: {
                id: id,
                id_costcenter: id_costcenter
            },

            success: function (response) {
                UIkit.notification({
                    message: response.message,
                    status: 'success',
                    pos: 'top-right'
                });
            },
        });
    });
    
    
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
