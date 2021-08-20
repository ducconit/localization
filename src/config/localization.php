<?php

return [
    'support' => ['vi'],

    'route_gender' => true,

    'middleware' => [
        \DNT\Localization\Middlewares\Localization::class
    ],
    /**
     * name action attribute state locale
     */
    'name_action' => 'localization'
];