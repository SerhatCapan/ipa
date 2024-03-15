<p class="uk-text-small uk-margin-remove">Benutzer</p>
<h1 class="uk-margin-remove-top">Absenzen</h1>
<div class="uk-margin-medium-top">
    <?php if ($current_user === null) {
        render_alert('warning', 'Kein Benutzer aktiv. <a href="' . base_url() . 'user">Benutzer auswählen</a>');
    } else { ?>

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

        <form method="post" action="/user/absence/create">
            <fieldset class="uk-fieldset">
                <legend class="uk-legend">Neue Absenz</legend>
                <div class="uk-margin">
                    <div>
                        <div class="uk-margin">
                            <label class="uk-form-label" for="db-input-create-vacation-absence-date">Tag</label>
                            <div class="uk-form-controls">
                                <input required class="uk-input" id="db-input-create-absence-date" value="<?= date('Y-m-d', strtotime('now')) ?>" name="absence-date" type="date">
                            </div>
                        </div>
                        <div class="uk-margin">
                            <label class="uk-form-label" for="db-input-create-vacation-absence-hours">Stunden *</label>
                            <div class="uk-form-controls">
                                <input required class="uk-input" id="db-input-create-absence-hours" max="24" name="absence-hours" type="number">
                            </div>
                        </div>
                        <div class="uk-margin">
                            <label class="uk-form-label" for="db-input-create-absence-reason">Grund *</label>
                            <div class="uk-form-controls">
                                <input required class="uk-input" id="db-input-create-absence-reason" name="absence-reason" type="text">
                            </div>
                        </div>
                        <div class="uk-margin">
                            <div class="uk-form-controls">
                                <input type="submit" class="db-button-create-absence-submit uk-button uk-button-primary" value="Absenz erfassen">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
        <div id="db-container-table-absence">
            <?php echo $table ?? ''; ?>
        </div>
    <?php } ?>
</div>