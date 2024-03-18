<?php

use CodeIgniter\I18n\Time;

/**
 * @throws Exception
 */
function get_html_dashboard_card($data) {
    $date = Time::parse($data['date'], 'Europe/Zurich');

    ob_start();
    ?>
    <div class="uk-card uk-card-default uk-visible-toggle" data-workday-id>
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
            <div uk-grid class="uk-grid-small" id="db-container-workday-rows-<?= $data['date'] ?>">
                <?php
                foreach ($data['workday']['workhours'] as $workhour) {
                    echo get_html_dashboard_card_row([
                        'workhour' => $workhour,
                        'costcenters' => $data['costcenters'],
                        'date' => $data['date'],
                    ]);
                } ?>
            </div>
        </div>
        <div class="uk-card-footer">
            <div uk-grid class="uk-grid-small">
                <div class="uk-text-bold  uk-width-3-5">
                    Total
                </div>
                <div class="uk-text-bold uk-width-1-5">
                   <span id="db-workhours-total-<?= $data['date'] ?>"><?= $data['workday']['workhours_total'] ?></span>h
                </div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

function get_html_dashboard_card_row($data) {

    $costcenter_is_deleted = false;

    foreach ($data['costcenters'] as $costcenter) {
        if ($data['workhour']['id_costcenter'] === $costcenter['id'] && $costcenter['delete'] == 1) {
            $costcenter_is_deleted = true;
            $deleted_costcenter = $costcenter;
        }
    }

    ob_start(); ?>
    <div class="uk-width-3-5">
        <?php if (!$costcenter_is_deleted) { ?>
            <select data-workhour-id="<?= $data['workhour']['id'] ?>" data-workhour-date="<?= $data['date'] ?>"  class="db-select-workhour-costcenter uk-select" aria-label="Select">
                <option value="">Auswählen</option>
                <?php foreach ($data['costcenters'] as $costcenter) {
                    if ($costcenter['delete'] != 1) { ?>
                        <option <?= $data['workhour']['id_costcenter'] === $costcenter['id'] ? 'selected' : '' ?> value="<?= $costcenter['id'] ?>"><?= !empty($costcenter['costcenter_group_name']) ? '[' . $costcenter['costcenter_group_name']  . '] ' : '' ?> <?= esc($costcenter['name']) ?></option>
                    <?php } ?>
                <?php } ?>
            </select>
        <?php } else { ?>
            <p data-workhour-id="<?= $data['workhour']['id'] ?>" data-workhour-date="<?= $data['date'] ?>" class="db-select-workhour-costcenter"><?= !empty($deleted_costcenter['costcenter_group_name']) ? '[' . $deleted_costcenter['costcenter_group_name']  . ']' : '' ?> <?= esc($deleted_costcenter['name']) ?></p>
        <?php } ?>
    </div>
    <div class="uk-width-1-5">
        <span data-workhour-id="<?= $data['workhour']['id'] ?>" data-workhour-date="<?= $data['date'] ?>" class="db-workday-hour" contenteditable><?= $data['workhour']['hours'] ?></span>h
    </div>
    <div class="uk-width-1-5 uk-invisible-hover">
        <a data-workhour-id="<?= $data['workhour']['id'] ?>" data-workhour-date="<?= $data['date'] ?>" uk-tooltip="Arbeitsstunden löschen" class="db-icon-delete-workhour uk-icon-link uk-margin-small-right" uk-icon="trash"></a>
        <a data-workhour-id="<?= $data['workhour']['id'] ?>" data-workhour-date="<?= $data['date'] ?>" uk-tooltip="Kostenstelle hinzufügen" class="db-icon-add-costcenter uk-icon-link uk-margin-small-right" uk-icon="plus"></a>
    </div>
    <?php
    return ob_get_clean();
}