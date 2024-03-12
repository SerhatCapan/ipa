<p class="uk-text-small uk-margin-remove">Einstellungen</p>
<h1 class="uk-margin-remove-top">Einstellungen</h1>
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

    <form class="uk-margin-top" action="/settings/update" method="post">
        <div class="uk-margin">
            <label class="uk-form-label" for="db-input-update-option-workhours-per-day">Arbeitsstunden pro Tag *</label>
            <div class="uk-form-controls">
                <input required class="uk-input" id="db-input-update-option-workhours-per-day" name="option-workhours-per-day" value="<?= esc($workhours_per_day) ?>" type="number">
            </div>
        </div>
        <div class="uk-margin">
            <input type="submit" class="uk-button-primary uk-button" value="Einstellungen speichern">
        </div>
    </form>
</div>