<p class="uk-text-small uk-margin-remove">Benutzer</p>
<h1 class="uk-margin-remove-top">Ferien</h1>
<div class="uk-margin-medium-top">
    <?php if ($current_user === null) {
        render_alert('warning', 'Kein Benutzer aktiv. <a href=' . base_url() . 'user">Benutzer auswählen</a>');
    } else { ?>
        <p>Restliche Ferienguthaben vom <?= $vacation_credit_date_from ?> - <?= $vacation_credit_date_to ?>: <?= $vacation_remaining_credits ?> Tage</p>
        <form method="post" action="/user/vacation/create">
            <div class="uk-margin">
                <div>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="db-input-create-vacation-date-from">Ferien vom *</label>
                        <div class="uk-form-controls">
                            <input required class="uk-input" id="db-input-create-vacation-date-from" name="vacation-date-from" min="<?= $vacation_credit_date_from ?>" max="<?= $vacation_credit_date_to ?>" type="date">
                        </div>
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="db-input-create-vacation-date-to">Ferien bis *</label>
                        <div class="uk-form-controls">
                            <input required class="uk-input" id="db-input-create-vacation-date-to" name="vacation-date-to" type="date" min="<?= $vacation_credit_date_from ?>" max="<?= $vacation_credit_date_to ?>" >
                        </div>
                    </div>
                    <div class="uk-margin">
                        <div class="uk-form-controls">
                            <input type="submit" class="uk-button uk-button-primary" value="Ferien setzen">
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div id="db-container-table-vacation">
            <?php echo $table ?? ''; ?>
        </div>
    <?php } ?>
</div>