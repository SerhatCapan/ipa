$(document).ready(function() {
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
                        console.log(response)
                    },
                });
            }
        } else {
            $(this).addClass('uk-text-danger');
        }
    });


});
