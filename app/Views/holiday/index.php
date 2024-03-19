<p class="uk-text-small uk-margin-remove">Feiertage</p>
<h1 class="uk-margin-remove-top">Feiertage</h1>
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
    <form method="post" action="holiday/create">
        <fieldset class="uk-fieldset">
            <legend class="uk-legend">Feiertag erfassen</legend>
            <div class="uk-margin">
                <div>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="db-input-create-vacation-holiday-date">Tag</label>
                        <div class="uk-form-controls">
                            <input required class="uk-input" id="db-input-create-holiday-date" value="<?= date('Y-m-d', strtotime('now')) ?>" name="holiday-date" type="date">
                        </div>
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="db-input-create-vacation-holiday-hours">Stunden *</label>
                        <div class="uk-form-controls">
                            <input required class="uk-input" id="db-input-create-holiday-hours" max="24" name="holiday-hours" type="number">
                        </div>
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="db-input-create-holiday-name">Name *</label>
                        <div class="uk-form-controls">
                            <input required class="uk-input" id="db-input-create-holiday-name" name="holiday-name" type="text">
                        </div>
                    </div>
                    <div class="uk-margin">
                        <div class="uk-form-controls">
                            <input type="submit" class="db-button-create-holiday-submit uk-button uk-button-primary" value="Feiertag erfassen">
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>

    <div id="container_table_holiday">
        <?php
        echo $table;
        ?>
    </div>
</div>