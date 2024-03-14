$(document).ready(function() {

    let container_table_vacation = $('#db-container-table-vacation');

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
                container_table_vacation.empty();
                container_table_vacation.append(response.html);
            },
        });
    })

});
