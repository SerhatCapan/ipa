<p class="uk-text-small uk-margin-remove">Dashboard </p>
<h1 class="uk-margin-remove-top"><?= $date_from->toLocalizedString('dd. MMM yyyy') . ' - ' . $date_to->toLocalizedString('dd. MMM yyyy'); ?></h1>

<div class="uk-margin-medium-top">
    <?php if ($current_user === null) {
        render_alert('warning', 'Kein Benutzer aktiv. <a href="' . base_url() . 'user">Benutzer auswählen</a>');
    } else { ?>
        <div uk-grid class="uk-grid-small uk-child-width-1-6">
            <div>
                <input id="db-input-create-workday-date" class="uk-input" type="date" placeholder="Datum" aria-label="Datum" value="<?= esc($_GET['date_from'] ?? '')  ?>">
            </div>
            <div>
                <button class="uk-button uk-button-primary" id="db-button-create-workday">Tag erfassen</button>
            </div>
        </div>

        <div uk-grid class="uk-grid uk-child-width-auto">
            <div>
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
                        $data_date_from = current($week['weekdays'])['date'];
                        $data_date_to = end($week['weekdays'])['date'];
                        ?>
                        <tr data-date-from="<?= $data_date_from ?>" data-date-to="<?= $data_date_to ?>" class="db-calendar-week <?= $week['active_week'] === true ? 'db-week-selected' : '' ?>">
                            <?php foreach ($week['weekdays'] as $weekday) { ?>
                                <td class="db-day-<?= $weekday['type'] ?>" uk-tooltip="<?= $weekday['tooltip'] ?>"><?= date('j', strtotime($weekday['date'])) ?></td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <span class="uk-badge db-week-selected">Ausgewählte Woche</span> <span class="uk-badge db-day-workday">Arbeitstag</span> <span class="uk-badge db-day-vacation">Ferien</span> <span class="uk-badge db-day-absence">Absenz</span> <span class="uk-badge db-day-holiday">Feiertag</span>
            </div>
            <div>
                <h2>Überzeit</h2>
                <p>Differenz: <span><?= $overtime ?></span>h</p>
            </div>
            <div>
                <h2>Ferien</h2>
                <div class="uk-grid-small uk-grid-collapse" uk-grid>
                    <div class="uk-width-1-2">Restliche Ferientage im Lehrjahr: </div>
                    <div class="uk-width-1-2"><span><?= $vacation_remaining_credits ?></span> Tage</div>
                </div>
            </div>

            <div>
                <h2>Kostenstellen und Kostenstellen-Gruppen berechnen</h2>
                <div uk-grid>
                    <div class="uk-width-1-3">
                        <label class="uk-form-label" for="db-input-read-costcentergroup-date-from">Von *</label>
                        <div class="uk-form-controls">
                            <input required class="uk-input" name="costcentergroup-date-from" id="db-input-read-costcentergroup-date-from" type="date" value="<?= esc($_GET['date_from'] ?? date('Y-m-d', strtotime('now')))  ?>">
                        </div>
                    </div>
                    <div class="uk-width-1-3">
                        <label class="uk-form-label" for="db-input-read-costcentergroup-date-to">Bis *</label>
                        <div class="uk-form-controls">
                            <input required class="uk-input" name="costcentergroup-date-to" id="db-input-read-costcentergroup-date-to" type="date" value="<?= esc($_GET['date_to'] ?? '')  ?>">
                        </div>
                    </div>
                    <div class="uk-width-1-3">
                        <label class="uk-form-label" for="db-select-read-costcentergroup">Kostenstelle/Kostenstellen-Gruppe *</label>
                        <div class="uk-form-controls">
                            <select id="db-select-read-costcentergroup" name="costcentergroup" class="db-select-read-costcentergroup uk-select" aria-label="Select">
                                <option selected disabled value="">Auswählen</option>
                                <?php foreach ($costcenters as $item) { ?>
                                    <option data-type="costcenter" value="<?= $item['id'] ?>">(KS) <?= !empty($item['costcenter_group_name']) ? '[' . $item['costcenter_group_name']  . ']' : '' ?> <?= $item['name'] ?></option>
                                <?php }
                                foreach ($costcentergroups as $item) { ?>
                                    <option data-type="costcenter-group" value="<?= $item['id'] ?>">(KS-G) <?= $item['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="uk-width-1-1">
                        <p>Totale Stunden im Zeitraum: <span id="db-costcentergroup-total-hours-in-time-period">0</span>h</p>
                    </div>
                </div>
            </div>
        </div>
        <h2>Tage</h2>

        <?php
        if (empty($workdays)) {
        ?>
        <div class="uk-alert-primary" uk-alert>
            <a href class="uk-alert-close" uk-close></a>
            <p>Keine Arbeitsstage erfasst</p>
        </div>
        <?php } ?>

        <div id="db-container-workdays" class="uk-child-width-1-5@l uk-child-width-1-3@m uk-child-width-1-2@s" uk-grid>
            <?php if (!empty($workdays)) {
                foreach ($workdays as $date => $workday) { ?>
                    <div>
                        <?php
                        echo get_html_dashboard_card([
                            'workday' => $workday,
                            'date' => $date,
                            'costcenters' => $costcenters
                        ]) ?>
                    </div>
                <?php }
            } ?>
        </div>
    <?php } ?>
</div>