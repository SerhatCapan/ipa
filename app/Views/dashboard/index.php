<p class="uk-text-small uk-margin-remove">Dashboard</p>
<h1 class="uk-margin-remove-top">Arbeitszeiterfassung</h1>
<div class="uk-margin-medium-top">
    <button class="uk-button uk-button-primary">Neuen Tag erfassen</button>
    <div class="uk-child-width-1-4@l uk-child-width-1-3@m uk-child-width-1-2@s" uk-grid>
        <?php foreach ($workdays as $date => $workday) { ?>
            <div>
                <?php render_dashboard_card(['workday' => $workday, 'date' => $date]) ?>
            </div>
        <?php } ?>
    </div>
</div>