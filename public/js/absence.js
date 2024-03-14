$(document).ready(function() {
    let container_table_absence = $('#db-container-table-absence');

    $(document).on('click', '.db-icon-delete-vacation', function(event) {
        event.preventDefault();

        let id = $(this).data('id-vacation');

        $.ajax({
            url: "/user/vacation/delete",
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
