<?php

return json_encode([                                    // modules
    [
        'name' => '测试菜单',
        'icon' => 'dashboard',
        'route' => null,
        'items' => [
            [
                'name' => '商城管理',
                'route' => 'admin.home',
                'description' => '设置商城基本信息',
                'items' => [
                    [
                        'name' => '首页设置',
                        'route' => 'admin.index',
                        'description' => '设置商城首页信息',
                        'items' => null,
                    ],
                ]
            ],

        ],
    ],

]);
