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

    <h2>Woche</h2>
    <table class="db-calendar">
        <thead>
        <tr>
            <?php foreach ($calendar['heading'] as $weekdays) { ?>
                <th><?= $weekdays ?></th>
            <?php } ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($calendar['weeks'] as $week) {
            $date_from = current($week['weekdays']);
            $date_to = end($week['weekdays']);
            ?>
            <tr data-date-from="<?= $date_from ?>" data-date-to="<?= $date_to ?>" uk-tooltip="<?= $week['active_week'] === true ? 'Aktuelle Woche' : 'Woche auswählen' ?>" class="db-calendar-week <?= $week['active_week'] === true ? 'db-calendar-week-selected' : '' ?>">
                <?php foreach ($week['weekdays'] as $weekday) { ?>
                    <td><?= date('j', strtotime($weekday)) ?></td>
                <?php } ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <!--<span class="uk-badge">Aktuelle Woche</span>
    <span class="uk-badge">Ferien</span>
    <span class="uk-badge">Absenz</span>-->

    <h2>Tage</h2>

    <?php
    if (empty($workdays)) { ?>
        <div class="uk-alert-primary" uk-alert>
            <a href class="uk-alert-close" uk-close></a>
            <p>Keine Arbeitsstage erfasst</p>
        </div>
    <?php } else { ?>
        <div id="db-container-workdays" class="uk-child-width-1-5@l uk-child-width-1-3@m uk-child-width-1-2@s" uk-grid>
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
    <?php }
    } ?>
</div>