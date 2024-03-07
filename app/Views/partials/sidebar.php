<?php
$sidebar = [
    [
        "label" => "Dashboard",
        "page"  => "/dashboard",
        "icon"  => "home",
    ],
    [
        "label" => 'Kostenstellen',
        "page"  => "/costcenter",
        "icon"  => "table",
    ],
    [
        "label" => 'Kostenstellen-Gruppen',
        "page"  => "/costcenter-group",
        "icon"  => "list",
    ],
    [
        "label" => 'Benutzer',
        "page"  => "/user",
        "icon"  => "user",
    ],
];
?>

<div class="db-sidebar uk-position-absolute">
    <p class="uk-h3"><a class="uk-link-reset" href="/dashboard">Arbeitsrapport</a></p>
    <ul class="uk-nav uk-nav-default tm-nav">
        <?php foreach ($sidebar as $menu) { ?>
            <li class="">
                <a href="<?= $menu['page'] ?>">
                    <span class="uk-margin-small-right" uk-icon="<?= $menu['icon'] ?? '' ?>"></span><?= $menu['label'] ?>
                </a>
            </li>
        <?php } ?>
    </ul>
</div>