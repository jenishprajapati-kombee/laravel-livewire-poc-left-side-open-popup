<?php

return [

    'KT_THEME_BOOTSTRAP' => [
        'default' => \App\Core\Bootstrap\BootstrapDefault::class,
        'auth' => \App\Core\Bootstrap\BootstrapAuth::class,
        'system' => \App\Core\Bootstrap\BootstrapSystem::class,
    ],

    'KT_THEME' => 'metronic',

    // Theme layout templates directory

    'KT_THEME_LAYOUT_DIR' => 'components.layout',


    // Theme Mode
    // Value: light | dark | system

    'KT_THEME_MODE_DEFAULT' => 'light',
    'KT_THEME_MODE_SWITCH_ENABLED' => true,


    // Theme Direction
    // Value: ltr | rtl

    'KT_THEME_DIRECTION' => 'ltr',


    // Keenicons
    // Value: duotone | outline | bold

    'KT_THEME_ICONS' => 'duotone',


    // Theme Assets

    'KT_THEME_ASSETS' => [
        'favicon' => 'assets/media/logos/easternicon.webp',
        'fonts' => [
           'https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap',
        ],
        'global' => [
            'css' => [
                'assets/plugins/global/plugins.bundle.css',
                'assets/css/style.bundle.css',
            ],
            'js' => [
                'assets/plugins/global/plugins.bundle.js',
                'assets/js/scripts.bundle.js',
                'assets/js/widgets.bundle.js',
            ],
        ],
    ],


    // Theme Vendors

    'KT_THEME_VENDORS' => [
        'formrepeater' => [
            'js' => [
                'assets/plugins/custom/formrepeater/formrepeater.bundle.js',
            ],
        ],
        'google-jsapi' => [
            'js' => [
                '//www.google.com/jsapi',
            ],
        ],
        'typedjs' => [
            'js' => [
                'assets/plugins/custom/typedjs/typedjs.bundle.js',
            ],
        ],
        'cookiealert' => [
            'css' => [
                'assets/plugins/custom/cookiealert/cookiealert.bundle.css',
            ],
            'js' => [
                'assets/plugins/custom/cookiealert/cookiealert.bundle.js',
            ],
        ],
        'cropper' => [
            'css' => [
                'assets/plugins/custom/cropper/cropper.bundle.css',
            ],
            'js' => [
                'assets/plugins/custom/cropper/cropper.bundle.js',
            ],
        ],
    ],

];
