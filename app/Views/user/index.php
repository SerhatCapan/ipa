<p class="uk-text-small uk-margin-remove">Benutzer</p>
<h1 class="uk-margin-remove-top"><?= $title ?></h1>
<div class="uk-margin-medium-top">
    <?php
    $session = session();
    $return = $session->getFlashdata('return');

    if ($return !== null) {
        switch ($return['success']) {
            case true:
                $alert = 'success';
                break;
            case false:
                $alert = 'warning';
                break;
        }

        render_alert($alert, $return['message']);
     } ?>

    <form action="/user/create" method="post">
        <fieldset class="uk-fieldset">
            <legend class="uk-legend">Benutzer erstellen</legend>
            <div class="uk-margin">
                <label class="uk-form-label" for="db-input-create-user-name">Name *</label>
                <div class="uk-form-controls">
                    <input required class="uk-input" name="name" id="db-input-create-user-name" type="text">
                </div>
            </div>

            <div class="uk-margin">
                <input type="submit" class="uk-button-primary uk-button" value="Benutzer erstellen">
            </div>
        </fieldset>
    </form>

    <form class="uk-margin-large-top" action="/user/switch" method="post">
        <fieldset class="uk-fieldset">
            <legend class="uk-legend">Benutzer wechseln</legend>
            <div uk-grid class="uk-margin uk-grid-small uk-child-width-1-6">
                <div>
                    <select name="user" class="uk-select" aria-label="Select">
                        <?php foreach ($users as $user) { ?>
                            <option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div>
                    <input type="submit" class="uk-button uk-button-primary" value="<?= $switch_user_button_title ?>">
                </div>
            </div>
        </fieldset>
    </form>

    <form class="uk-margin-large-top" action="/user/delete" method="post">
        <fieldset class="uk-fieldset">
            <legend class="uk-legend">Benutzer löschen <span uk-tooltip="ACHTUNG - Wird ein Benutzer gelöscht, so werden auch alle seine Arbeitsstunden gelöscht." uk-icon="warning"></span></legend>
            <div uk-grid class="uk-margin uk-grid-small uk-child-width-1-6">
                <div>
                    <select name="user" class="uk-select" aria-label="Select">
                        <?php foreach ($users as $user) { ?>
                            <option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div>
                    <input type="submit" class="uk-button uk-button-primary" value="Benutzer löschen">
                </div>
            </div>
        </fieldset>
    </form>

    <?php if (!empty($current_user)) { ?>
    <form class="uk-margin-large-top" action="/user/update" method="post">
        <fieldset class="uk-fieldset">
            <legend class="uk-legend">Benutzer aktualisieren</legend>

            <div class="uk-margin">
                <label class="uk-form-label" for="db-input-update-user-name">Name *</label>
                <div class="uk-form-controls">
                    <input required class="uk-input" name="name" id="db-input-update-user-name" type="text" value="<?= esc($current_user['name']) ?>">
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="db-input-update-user-overtime">Überzeit Startdatum * <span uk-icon="info" uk-tooltip="Ab Wann die Überzeiten gezählt werden sollen."></span></label>
                <div class="uk-form-controls">
                    <input required class="uk-input" name="date-from-overtime" type="date" value="<?= esc($current_user['date_from_overtime']) ?>">
                </div>
            </div>

            <input type="hidden" value="<?= $current_user['id'] ?>" name="id">

            <div class="uk-margin">
                <input type="submit" class="uk-button-primary uk-button" value="Einstellungen speichern">
            </div>
        </fieldset>
    </form>

    <?php } ?>
</div>