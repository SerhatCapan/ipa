<p class="uk-text-small uk-margin-remove">Benutzer</p>
<h1 class="uk-margin-remove-top">Ferienguthaben</h1>
<div class="uk-margin-medium-top">
    <div id="db-container-messages-holiday"></div>
    <form action="/user/vacation-credit/create" method="post">
        <div class="uk-margin">
            <label class="uk-form-label" for="db-input-create-vacation-credit-date-from">Ferienguthaben vom *</label>
            <div class="uk-form-controls">
                <input required class="uk-input" id="db-input-create-vacation-credit-date-from" name="vacation-credit-date-from" type="date">
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="db-input-create-vacation-date-to">Ferienguthaben bis *</label>
            <div class="uk-form-controls">
                <input required class="uk-input" id="db-input-create-vacation-credit-date-to" name="vacation-credit-date-to" type="date">
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="db-input-create-vacation-credit-credit">Anzahl der freien Ferientage im angegeben Zeitraum</label>
            <div class="uk-form-controls">
                <input required class="uk-input" id="db-input-create-vacation-credit-credit" name="vacation-credit-credit" type="number">
            </div>
        </div>
        <div class="uk-margin">
            <input class="uk-button uk-button-primary" type="submit" value="Ferienguthaben setzen">
        </div>
    </form>
    <div id="container_table_vacation_credit">
        <?php
        echo $table ?? '';
        ?>
    </div>
</div>