$(document).ready(function() {
    let input_create_workday_date = $('#db-input-create-workday-date')
    let button_create_workday = $('#db-button-create-workday')
    let container_workdays = $('#db-container-workdays');
    let input_costcentergroup_date_from = $('#db-input-read-costcentergroup-date-from');
    let input_costcentergroup_date_to = $('#db-input-read-costcentergroup-date-to');
    let select_read_costcentergroup = $('#db-select-read-costcentergroup');
    let costcentergroup_total_hours_in_time_period = $('#db-costcentergroup-total-hours-in-time-period')

    $(document).on('click', '.db-icon-add-costcenter', function(event) {
        event.preventDefault();

        let id = $(this).data('workhour-id');
        let date = $(this).data('workhour-date');
        let container_workday_rows = $('#db-container-workday-rows-' + date)

        $.ajax({
            url: "/workhour/create",
            method: "post",
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            data: {
                id: id,
                date: date
            },

            success: function (response) {
                container_workday_rows.append(response.html);
            },
        });
    })

    $(document).on('input', '.db-workday-hour', function() {
        let max_number = 24;
        let current_value = $(this).text();
        let total_hours = 0;
        let workhour_date = $(this).data('workhour-date');

        if ($.isNumeric(current_value)) {
            $(this).removeClass('uk-text-danger')

            // Iterate through all elements with the same data-workhour-date
            $('.db-workday-hour[data-workhour-date="' + workhour_date + '"]').each(function() {
                let value = parseInt($(this).text());
                if (!isNaN(value)) {
                    total_hours += value;
                }
            });

            // Check if the total hours exceed the maximum
            if (total_hours > max_number) {
                // Reduce the current value to stay within the limit
                $(this).text(parseInt(current_value) - (total_hours - max_number));
                total_hours = max_number; // Reset total hours to max_number
            }

            // Update the total hours element
            $('#db-workhours-total-' + workhour_date).text(total_hours);

            if (!isNaN($(this).text())) {
                $.ajax({
                    url: "/workhour/update",
                    method: "post",
                    headers: {'X-Requested-With': 'XMLHttpRequest'},
                    data: {
                        id: $(this).data('workhour-id'),
                        hours: $(this).text()
                    },

                    success: function (response) {
                        db_notification(response)
                    },
                });
            }
        } else {
            $(this).addClass('uk-text-danger');
        }
    });

    $(document).on('click', '.db-calendar-week', function() {
        let date_from = $(this).data('date-from');
        let date_to = $(this).data('date-to');
        let current_url = window.location.href;
        let base_url = current_url.split('/').slice(0, 3).join('/');

        window.location.href = base_url + '/dashboard?get_workdays=1&date_from=' + date_from + '&date_to=' + date_to;
    });

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
                db_notification(response)
            },
        });
    });


    button_create_workday.on('click', function () {
        $.ajax({
            url: "/workday/create",
            method: "post",
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            data: {
                date: input_create_workday_date.val()
            },

            success: function (response) {
                db_notification(response)
                container_workdays.prepend(response.html)
            },
        });
    })

    input_costcentergroup_date_from.on('input', function() {
        set_costcentergroup_total_workhours()
    });

    input_costcentergroup_date_to.on('input', function() {
        set_costcentergroup_total_workhours()
    });

    select_read_costcentergroup.on('change', function() {
        set_costcentergroup_total_workhours();
    });

    function set_costcentergroup_total_workhours() {
       let type = select_read_costcentergroup.find(":selected").data('type')

        if (typeof type === "undefined") {
            return;
        }

        console.log("/" + type + "/read")
        console.log(select_read_costcentergroup.val())
        console.log(input_costcentergroup_date_from.val())
        console.log(input_costcentergroup_date_to.val())

        $.ajax({
            url: "/" + type + "/read",
            method: "post",
            data: {
                'id': select_read_costcentergroup.val(),
                'date_from': input_costcentergroup_date_from.val(),
                'date_to': input_costcentergroup_date_to.val(),
            },

            headers: {'X-Requested-With': 'XMLHttpRequest'},
            success: function (response) {
                db_notification(response)
                costcentergroup_total_hours_in_time_period.text(response.total_work_hours)
            },

            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
            }
        });

    }

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