<p class="uk-text-small uk-margin-remove">Benutzer</p>
<h1 class="uk-margin-remove-top">Hallo <?= $current_user['name'] ?? '' ?>!</h1>
<div class="uk-margin-medium-top">
    <form action="/user/switch" method="post">
        <div uk-grid class="uk-grid-small uk-child-width-1-6">
            <div>
                <select name="user" class="uk-select" aria-label="Select">
                    <?php foreach ($users as $user) { ?>
                        <option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <input type="submit" id="db-button-switch-user" class="uk-button uk-button-primary" value="Benutzer wechseln">
            </div>
        </div>
    </form>
</div>