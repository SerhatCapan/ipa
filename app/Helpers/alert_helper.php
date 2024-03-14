<?php
function render_alert($type, $message) { ?>
    <div class="uk-alert-<?= $type ?> uk-alert" uk-alert="">
        <a href="" class="uk-alert-close uk-icon uk-close" uk-close=""><svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg"><line fill="none" stroke="#000" stroke-width="1.1" x1="1" y1="1" x2="13" y2="13"></line><line fill="none" stroke="#000" stroke-width="1.1" x1="13" y1="1" x2="1" y2="13"></line></svg></a>
        <p><?= $message ?></p>
    </div>
<?php }