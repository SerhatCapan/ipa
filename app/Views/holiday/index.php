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
    <form>
        <div class="uk-margin">
            <div class="uk-inline">
                <a id="db-button-create-holiday" class="uk-form-icon uk-form-icon-flip" uk-icon="icon: plus"></a>
                <input id="db-input-create-holiday" class="uk-input" type="text" placeholder="Feiertage erstellen" aria-label="Clickable icon">
            </div>
        </div>
    </form>

    <div id="container_table_holiday">
        <?php
        echo $table;
        ?>
    </div>
</div>