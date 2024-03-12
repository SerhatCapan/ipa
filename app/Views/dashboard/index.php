<p class="uk-text-small uk-margin-remove">Dashboard</p>
<h1 class="uk-margin-remove-top">Arbeitszeiterfassung</h1>
<div class="uk-margin-medium-top">

    <?php if ($current_user === null) { ?>
        <div class="uk-alert-warning" uk-alert>
            <a href class="uk-alert-close" uk-close></a>
            <p>Kein Benutzer aktiv. <a href="<?= base_url() ?>user">Hier Benutzer auswählen</a></p>
        </div>
    <?php } else { ?>

    <div uk-grid class="uk-grid-small uk-child-width-1-6">
        <div>
            <input id="db-input-create-workday-date" class="uk-input" type="date" placeholder="Datum" aria-label="Datum" value="<?= date('Y-m-d'); ?>">
        </div>
        <div>
            <button class="uk-button uk-button-primary" id="db-button-create-workday">Tag erfassen</button>
        </div>
    </div>

    <div id="db-container-workdays" class="uk-child-width-1-4@l uk-child-width-1-3@m uk-child-width-1-2@s" uk-grid>
        <?php foreach ($workdays as $date => $workday) { ?>
            <div>
                <?php
                echo get_html_dashboard_card([
                    'workday' => $workday,
                    'date' => $date,
                    'costcenters' => $costcenters
                ]) ?>
            </div>
        <?php } ?>
    </div>

    <?php } ?>
</div>