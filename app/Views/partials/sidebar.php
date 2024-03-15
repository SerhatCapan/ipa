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
        "label" => 'Feiertage',
        "page"  => "/holiday",
        "icon"  => "list",
    ],
    [
        "label" => 'Einstellungen',
        "page"  => "/settings",
        "icon"  => "list",
    ],
    [
        "label" => 'Benutzer',
        "icon"  => "user",
        'nav-sub' => [
            [
                "label" => 'Allgemein',
                "page"  => "/user"
            ],
            [
                "label" => 'Ferien',
                "page"  => "/user/vacation",
            ],
            [
                "label" => 'Ferienguthaben',
                "page"  => "/user/vacation-credit",
            ],
            [
                "label" => 'Absenzen',
                "page"  => "/user/absence",
            ]
        ]
    ],
];
?>

<div class="db-sidebar uk-position-absolute">
    <p class="uk-h3"><a class="uk-link-reset" href="/dashboard">Arbeitsrapport</a></p>
    <ul class="uk-nav uk-nav-default tm-nav">
        <?php foreach ($sidebar as $menu) {
            $nav_sub = $menu['nav-sub'] ?? [];
            
            if (!empty($nav_sub)) { ?>
                <li class="uk-parent">
                    <a href="">
                        <span class="uk-margin-small-right" uk-icon="<?= $menu['icon'] ?? '' ?>"></span><?= $menu['label'] ?>
                    </a>
                    <ul class="uk-nav-sub">
                        <?php foreach ($nav_sub as $item) { ?>
                            <li><a href="<?= $item['page'] ?>"><?= $item['label'] ?></a></li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } else { ?>
                <li>
                    <a href="<?= $menu['page'] ?>">
                        <span class="uk-margin-small-right" uk-icon="<?= $menu['icon'] ?? '' ?>"></span><?= $menu['label'] ?>
                    </a>
                </li>
            <?php } ?>
        <?php } ?>
    </ul>
</div>