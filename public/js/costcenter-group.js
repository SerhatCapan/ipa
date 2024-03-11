$(document).ready(function () {
    let input_create_costcenter_group = $('#db-input-create-costcenter-group');
    let container_messages_costcenter_group = $('#db-container-messages-costcenter-group');
    let button_create_costcenter_group = $('#db-button-create-costcenter-group');
    let container_table_costcenter_group = $('#db-container-table-costcenter-group')

    /**
     * Fires after clicking on the plus
     */
    button_create_costcenter_group.on("click", function (event) {
        event.preventDefault();
        update_table_costcenter_group();
    })

    /**
     * Fires when "enter" is pressed on the keyboard on the input
     */
    input_create_costcenter_group.on('keydown', function(event) {
        if (event.which === 13) {
            event.preventDefault();
            update_table_costcenter_group();
        }
    });


    /**
     * Updates the table and echos an alert.
     */
    function update_table_costcenter_group() {
        $.ajax({
            url: "/costcenter-group/create",
            method: "post",
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            data: {
                name: input_create_costcenter_group.val()
            },

            success: function (response) {
                container_table_costcenter_group.empty()
                container_table_costcenter_group.append(response.table)

                let alert_type;

                switch (response.success) {
                    case true:
                        alert_type = 'success';
                        break;
                    case false:
                        alert_type = 'danger'
                        break;
                }

                container_messages_costcenter_group.append(
                    '<div class="uk-alert-' + alert_type + '" uk-alert>' +
                    '<a href class="uk-alert-close" uk-close></a>' +
                    '<p>' + response.message + '</p>' +
                    '</div>'
                )
            },
        });
    }
});