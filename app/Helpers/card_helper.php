<?php

use CodeIgniter\I18n\Time;

/**
 * @throws Exception
 */
function render_dashboard_card($data) {
    $date = Time::parse($data['date'], 'Europe/Zurich');
    ?>
    <div class="uk-card uk-card-default">
        <div class="uk-card-header">
            <div class="uk-grid-small uk-flex-middle" uk-grid="masonry: true">
                <div class="uk-width-expand">
                    <!--<div class="uk-card-badge uk-label">- 10h</div>-->
                    <h3 class="uk-card-title uk-margin-remove-bottom">Arbeitstag</h3>
                    <p class="uk-text-meta uk-margin-remove-top"><time datetime="<?= $date->toLocalizedString('YYYY-MM-DD H:i:s') ?>"><?= $date->toLocalizedString('dd. MMM yyyy') ?></time></p>
                </div>
            </div>
        </div>
        <div class="uk-card-body">
            <div uk-grid class="uk-grid-collapse uk-child-width-1-2">
                <?php foreach ($data['workday']['workhours'] as $workhour) { ?>
                    <div>
                        <?= $workhour['name'] ?>
                    </div>
                    <div>
                        <span data-workhour-id="<?= $workhour['id'] ?>" data-workhour-date="<?= $data['date'] ?>" class="db-workday-hour" contenteditable><?= $workhour['hours'] ?></span>
                    </div>
                    <div>

                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="uk-card-footer">
            <div uk-grid class="uk-grid-collapse uk-child-width-1-2">
                <div class="uk-text-bold">
                    Total
                </div>
                <div class="uk-text-bold" id="workday_total_hours">
                   <span id="workhours_total_<?= $data['date'] ?>"><?= $data['workday']['workhours_total'] ?></span>h
                </div>
            </div>
        </div>
    </div>
<?php }