<p class="uk-text-small uk-margin-remove">Kostenstellen-Gruppen</p>
<h1 class="uk-margin-remove-top">Kostenstellen-Gruppen</h1>
<div class="uk-margin-medium-top">
    <div id="container_messages_costcenter_group"></div>

    <form>
        <div class="uk-margin">
            <div class="uk-inline">
                <a id="button_create_costcenter_group" class="uk-form-icon uk-form-icon-flip" uk-icon="icon: plus"></a>
                <input id="input_create_costcenter_group" class="uk-input" type="text" placeholder="Kostenstelle-Gruppe erstellen" aria-label="Clickable icon">
            </div>
        </div>
    </form>

    <div id="container_table_costcenter_group">
        <?php
        echo $table;
        ?>
    </div>
</div>