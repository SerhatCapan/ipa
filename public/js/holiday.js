$(document).ready(function() {
    let container_table_holiday = $('#db-container-table-holiday');

    $(document).on('click', '.db-icon-delete-holiday', function(event) {
        event.preventDefault();
        let id = $(this).data('id-holiday');

        $.ajax({
            url: "/holiday/delete",
            method: "post",
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            data: {
                id: id,
            },

            success: function (response) {
                db_notification(response)
                container_table_holiday.empty();
                container_table_holiday.append(response.html);
            },
        });
    })
});
