$(document).ready(function() {
    let container_table_absence = $('#db-container-table-absence');

    $(document).on('click', '.db-icon-delete-absence', function(event) {
        event.preventDefault();

        let id = $(this).data('id-absence');

        $.ajax({
            url: "/user/absence/delete",
            method: "post",
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            data: {
                id: id,
            },

            success: function (response) {
                db_notification(response)
                container_table_absence.empty();
                container_table_absence.append(response.html);
            },
        });
    })
});
