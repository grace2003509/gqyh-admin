<?php

return json_encode([                                    // modules
    [
        'name' => '基础设置',
        'icon' => 'gears',
        'route' => null,
        'items' => [
            [
                'name' => '系统设置',
                'route' => 'admin.base.index',
                'description' => '基本第三方接口设置',
                'items' => [
                    [
                        'name' => '保存设置',
                        'route' => 'admin.base.edit',
                        'description' => '',
                        'items' => null,
                    ],
                ]
            ],

        ],
    ],
    [
        'name' => '财务统计',
        'icon' => 'bar-chart',
        'route' => null,
        'items' => [
            [
                'name' => '生成报告',
                'route' => 'admin.statistics.index',
                'description' => '生成订单统计报表',
                'items' => [
                    [
                        'name' => '下载报表',
                        'route' => 'admin.statistics.download',
                        'description' => '下载统计报表',
                        'items' => null,
                    ],
                ]
            ],

        ],
    ],

]);
