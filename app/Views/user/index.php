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
        ?>

        <div class="uk-alert-<?= $alert ?>" uk-alert>
            <a href class="uk-alert-close" uk-close></a>
            <p><?= $return['message'] ?></p>
        </div>
    <?php } ?>

    <form action="/user/switch" method="post">
        <div uk-grid class="uk-grid-small uk-child-width-1-6">
            <div>
                <select name="user" class="uk-select" aria-label="Select">
                    <?php foreach ($users as $user) { ?>
                        <option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <input type="submit" id="db-button-switch-user" class="uk-button uk-button-primary" value="<?= $switch_user_button_title ?>">
            </div>
        </div>
    </form>

    <form class="uk-margin-top" action="/user/update" method="post">
        <div class="uk-margin">
            <label class="uk-form-label" for="db-input-update-user-name">Name *</label>
            <div class="uk-form-controls">
                <input required class="uk-input" name="name" id="db-input-update-user-name" type="text" value="<?= esc($current_user['name']) ?>">
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="db-input-update-user-overtime">Überzeit Startdatum * <span uk-icon="info" uk-tooltip="Ab Wann die Überzeiten gezählt werden sollen."></span></label>
            <div class="uk-form-controls">
                <input required class="uk-input" name="date-from-overtime" id="db-input-update-user-overtime" type="date" value="<?= esc($current_user['date_from_overtime']) ?>">
            </div>
        </div>

        <input type="hidden" value="<?= $current_user['id'] ?>" name="id">

        <div class="uk-margin">
            <input type="submit" class="uk-button-primary uk-button" value="Einstellungen speichern">
        </div>
    </form>
</div>