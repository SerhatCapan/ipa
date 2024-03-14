$(document).ready(function () {
    let input_create_costcenter_group = $('#db-input-create-costcenter-group');
    let button_create_costcenter_group = $('#db-button-create-costcenter-group');
    let container_table_costcenter_group = $('#db-container-table-costcenter-group')

    /**
     * Fires after clicking on the plus
     */
    button_create_costcenter_group.on("click", function (event) {
        event.preventDefault();
        create_table_costcenter_group();
    })

    /**
     * Fires when "enter" is pressed on the keyboard on the input
     */
    input_create_costcenter_group.on('keydown', function(event) {
        if (event.which === 13) {
            event.preventDefault();
            create_table_costcenter_group();
        }
    });

    $(document).on('click', '.db-icon-delete-costcenter-group', function(event) {
        event.preventDefault();

        let id = $(this).data('id-costcenter-group');

        $.ajax({
            url: "/costcenter-group/delete",
            method: "post",
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            data: {
                id: id
            },

            success: function (response) {
                db_notification(response)
                container_table_costcenter_group.empty()
                container_table_costcenter_group.append(response.html)
            },
        });
    })

    /**
     * Updates the table and echos an alert.
     */
    function create_table_costcenter_group() {
        $.ajax({
            url: "/costcenter-group/create",
            method: "post",
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            data: {
                name: input_create_costcenter_group.val()
            },

            success: function (response) {
                db_notification(response)
                container_table_costcenter_group.empty()
                container_table_costcenter_group.append(response.html)
            },
        });
    }
});