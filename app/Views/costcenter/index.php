<p class="uk-text-small uk-margin-remove">Kostenstellen</p>
<h1 class="uk-margin-remove-top">Kostenstellen</h1>
<div class="uk-margin-medium-top">
    <div id="container_messages_costcenter"></div>

    <form>
        <div class="uk-margin">
            <div class="uk-inline">
                <a id="button_create_costcenter" class="uk-form-icon uk-form-icon-flip" uk-icon="icon: plus"></a>
                <input id="input_create_costcenter" class="uk-input" type="text" placeholder="Kostenstelle erstellen" aria-label="Clickable icon">
            </div>
        </div>
    </form>

    <?php
    echo $table;
    ?>

    <table class="uk-table uk-table-striped uk-margin-large-top">
        <thead>
            <tr>
                <th class="uk-width-auto@s">Name</th>
                <th class="uk-width-auto@s">Kostenstellen-Gruppe</th>
                <th class="uk-width-auto@s">Anzahl Stunden</th>
                <th class="uk-width-auto@s"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($costcenters as $costcenter) { ?>
            <tr data-costcenter-id="<?= $costcenter['id'] ?>">
                <td>
                    <a uk-tooltip="Kostenstelle bearbeiten" href="costcenter/edit<?= $costcenter['id'] ?>"><?= esc($costcenter['name']) ?></a>
                </td>
                <td></td>
                <td>
                    <span>20</span>
                </td>
                <td>
                    <a id="icon_edit_costcenter" uk-tooltip="Kostenstelle bearbeiten" href="costcenter/edit/<?= $costcenter['id'] ?>" class="uk-icon-link uk-margin-small-right" uk-icon="pencil"></a>
                    <a id="icon_trash_costcenter" uk-tooltip="Kostenstelle löschen" href="costcenter/trash/<?= $costcenter['id'] ?>" class="uk-icon-link uk-margin-small-right" uk-icon="trash"></a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>





