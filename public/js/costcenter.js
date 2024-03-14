$(document).ready(function () {
    let container_table_costcenter =  $('#db-container-table-costcenter');
    let input_create_costcenter = $('#db-input-create-costcenter');
    let button_create_costcenter = $('#db-button-create-costcenter');

    /**
     * Fires after clicking on the plus
     */
    button_create_costcenter.on("click", function (event) {
        event.preventDefault();
        create_costcenter();
    })

    /**
     * Fires when "enter" is pressed on the keyboard on the input
     */
    input_create_costcenter.keypress(function(event) {
        if (event.which === 13) {
            event.preventDefault();
            create_costcenter()
        }
    });

    function create_costcenter(){
        $.ajax({
            url: "/costcenter/create",
            method: "post",
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            data: {
                name: input_create_costcenter.val()
            },

            success: function (response) {
                db_notification(response)
                container_table_costcenter.empty();
                container_table_costcenter.append(response.html)
            },
        });
    }

    $(document).on('click', '.db-icon-delete-costcenter', function(event) {
        event.preventDefault();

        let id = $(this).data('id-costcenter');

        $.ajax({
            url: "/costcenter/delete",
            method: "post",
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            data: {
                id: id
            },

            success: function (response) {
                db_notification(response)
                container_table_costcenter.empty()
                container_table_costcenter.append(response.html)
            },
        });
    })

    $(document).on('change', '.db-select-update-costcenter', function(event) {
        event.preventDefault();

        let id = $(this).data('id-costcenter');
        let name = $('.db-input-update-costcenter-name[data-id-costcenter="' + id + '"]').text();

        console.log(id)
        console.log($(this).val())
        console.log(name)

        $.ajax({
            url: "/costcenter/update",
            method: "post",
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            data: {
                id: id,
                id_costcenter_group: $(this).val(),
                name: name
            },

            success: function (response) {
                db_notification(response)
            },
        });
    })


});