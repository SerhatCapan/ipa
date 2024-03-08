$(document).ready(function () {
    let list_costcenters = $('#list_costcenters')
    let input_create_costcenter = $('#input_create_costcenter');
    let container_messages_costcenter = $('#container_messages_costcenter');

    $('#button_create_costcenter').on("click", function (event) {
        event.preventDefault();

        $.ajax({
            url: "/costcenter/create",
            method: "post",
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            data: {
                name: input_create_costcenter.val()
            },

            success: function (response) {
                list_costcenters.append('<tr><td><a href="' + response.costcenter['id'] + '">' + response.costcenter['name'] + '</a></td></tr>')
                container_messages_costcenter.append(
                    '<div class="uk-alert-success" uk-alert>' +
                        '<a href class="uk-alert-close" uk-close></a>' +
                        '<p>' + response.message + '</p>' +
                    '</div>'
                )
            },
        });
    })


    $('#icon_trash_costcenter').on('click', function (event) {
        event.preventDefault();

        let id = $(this).closest('tr').data('costcenter-id');

        $.ajax({
            url: "/costcenter/trash",
            method: "post",
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            data: {
                id: id
            },

            success: function (response) {
                list_costcenters.append('<li><a href="' + response.costcenter['id'] + '">' + response.costcenter['name'] + '</a></li>')
                console.log("Cost center created successfully:", response);
            },
        });
    })

});