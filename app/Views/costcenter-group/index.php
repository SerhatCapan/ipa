<p class="uk-text-small uk-margin-remove">Kostenstellen-Gruppen</p>
<h1 class="uk-margin-remove-top">Kostenstellen-Gruppen</h1>
<div class="uk-margin-medium-top">
    <div id="db-container-messages-costcenter-group"></div>

    <form>
        <div class="uk-margin">
            <div class="uk-inline">
                <a id="db-button-create-costcenter-group" class="uk-form-icon uk-form-icon-flip" uk-icon="icon: plus"></a>
                <input id="db-input-create-costcenter-group" class="uk-input" type="text" placeholder="Kostenstelle-Gruppe erstellen" aria-label="Clickable icon">
            </div>
        </div>
    </form>

    <div id="db-container-table-costcenter-group">
        <?php
        echo $table;
        ?>
    </div>
</div>