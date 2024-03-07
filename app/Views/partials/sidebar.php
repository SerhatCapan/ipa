<?php
$sidebar = [
    [
        "label" => "Test",
        "page"  => "test",
    ],
    [
        "label" => 'Test 2',
        "page"  => "test2",
    ],
];
?>

<div class="db-sidebar uk-visible@xl">
    <ul class="uk-nav uk-nav-default tm-nav">
        <?php foreach ($sidebar as $menu) { ?>
            <li class=""><a href="<?= base_url() . $menu['page'] ?>"><?= $menu['label'] ?></a></li>
        <?php } ?>
    </ul>
</div>