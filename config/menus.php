<?php

return json_encode([                                    // modules
    [
        'name' => '基础设置',
        'icon' => 'gears',
        'route' => null,
        'items' => [
            [
                'name' => '系统设置',
                'route' => 'admin.base.sys_index',
                'description' => null,
                'items' => []
            ],
            [
                'name' => '在线客服设置',
                'route' => 'admin.base.kf_index',
                'description' => null,
                'items' => []
            ],
            [
                'name' => '支付设置',
                'route' => 'admin.base.pay_index',
                'description' => null,
                'items' => [
                    [
                        'name' => '微信授权设置',
                        'route' => 'admin.base.wechat_set',
                        'description' => '',
                        'items' => null,
                    ]
                ]
            ],
            [
                'name' => '快递公司管理',
                'route' => 'admin.base.shipping',
                'description' => null,
                'items' => null,
            ],
            [
                'name' => '自定义URL',
                'route' => 'admin.base.diy_url',
                'description' => null,
                'items' => null,
            ],
            [
                'name' => '系统URL查询',
                'route' => 'admin.base.sys_url',
                'description' => null,
                'items' => null,
            ],
        ],
    ],
    [
        'name' => '商城设置',
        'icon' => 'shopping-bag',
        'route' => null,
        'items' => [
            [
                'name' => '基本设置',
                'route' => 'admin.shop.base_index',
                'description' => null,
                'items' => null,
            ],
            [
                'name' => '首页设置',
                'route' => 'admin.shop.home_index',
                'description' => null,
                'items' => null,
            ],
            [
                'name' => '底部菜单设置',
                'route' => 'admin.shop.foot_menu_index',
                'description' => null,
                'items' => null,
            ],
            [
                'name' => '积分设置',
                'route' => 'admin.shop.integrate_index',
                'description' => null,
                'items' => null,
            ],
            [
                'name' => '开关设置',
                'route' => 'admin.shop.on_off_index',
                'description' => null,
                'items' => null,
            ],
        ],
    ],
    [
        'name' => '会员管理',
        'icon' => 'group',
        'route' => null,
        'items' => [
            [
                'name' => '会员列表',
                'route' => 'admin.member.user_list',
                'description' => null,
                'items' => null,
            ],
            [
                'name' => '消息管理',
                'route' => 'admin.member.message_index',
                'description' => null,
                'items' => null,
            ],
        ],
    ],
    [
        'name' => '产品管理',
        'icon' => 'diamond',
        'route' => null,
        'items' => [
            [
                'name' => '产品列表',
                'route' => 'admin.product.product_index',
                'description' => null,
                'items' => null,
            ],
            [
                'name' => '产品类别',
                'route' => 'admin.product.category_index',
                'description' => null,
                'items' => null,
            ],
            [
                'name' => '产品评论',
                'route' => 'admin.product.commit_index',
                'description' => null,
                'items' => null,
            ],
            [
                'name' => '产品订单列表',
                'route' => 'admin.product.order_index',
                'description' => null,
                'items' => null,
            ],
            [
                'name' => '产品退货单列表',
                'route' => 'admin.product.back_index',
                'description' => null,
                'items' => null,
            ],
        ],
    ],
    [
        'name' => '分销管理',
        'icon' => 'sitemap',
        'route' => null,
        'items' => [
            [
                'name' => '分销设置',
                'route' => 'admin.distribute.base_config_index',
                'description' => null,
                'items' => [
                    [
                        'name' => '基础设置',
                        'route' => 'admin.distribute.base_config_index',
                        'description' => null,
                        'items' => null,
                    ],
                    [
                        'name' => '分销首页设置',
                        'route' => 'admin.distribute.home_config_index',
                        'description' => null,
                        'items' => null,
                    ],
                    [
                        'name' => '提现设置',
                        'route' => 'admin.distribute.withdraw_config_index',
                        'description' => null,
                        'items' => null,
                    ],
                    [
                        'name' => '爵位设置',
                        'route' => 'admin.distribute.protitle_config_index',
                        'description' => null,
                        'items' => null,
                    ],
                    [
                        'name' => '区域代理设置',
                        'route' => 'admin.distribute.agent_config_index',
                        'description' => null,
                        'items' => null,
                    ],
                    [
                        'name' => '其他设置',
                        'route' => 'admin.distribute.other_config_index',
                        'description' => null,
                        'items' => null,
                    ],
                ],
            ],
            [
                'name' => '分销账号管理',
                'route' => 'admin.distribute.account_index',
                'description' => null,
                'items' => null,
            ],
            [
                'name' => '提现管理',
                'route' => 'admin.distribute.withdraw_method_index',
                'description' => null,
                'items' => null,
            ],
            [
                'name' => '提现记录',
                'route' => 'admin.distribute.withdraw_index',
                'description' => null,
                'items' => null,
            ],
            [
                'name' => '区域代理管理',
                'route' => 'admin.distribute.agent_index',
                'description' => null,
                'items' => [
                    [
                        'name' => '区域代理申请列表',
                        'route' => 'admin.distribute.agent_apply',
                        'description' => null,
                        'items' => null,
                    ],
                ],
            ],
            [
                'name' => '佣金记录',
                'route' => 'admin.distribute.account_record',
                'description' => null,
                'items' => [
                    [
                        'name' => '分销佣金记录',
                        'route' => 'admin.distribute.account_record',
                        'description' => null,
                        'items' => null,
                    ],
                    [
                        'name' => '重消奖记录',
                        'route' => 'admin.distribute.point_record',
                        'description' => null,
                        'items' => null,
                    ],
                    [
                        'name' => '团队奖记录',
                        'route' => 'admin.distribute.protitle_record',
                        'description' => null,
                        'items' => null,
                    ],
                    [
                        'name' => '区域代理奖记录',
                        'route' => 'admin.distribute.agent_record',
                        'description' => null,
                        'items' => null,
                    ],
                ],
            ],
        ],
    ],
    [
        'name' => '商家管理',
        'icon' => 'gift',
        'route' => null,
        'items' => [
            [
                'name' => '商家设置',
                'route' => 'admin.business.enter_describe',
                'description' => null,
                'items' => [
                    [
                        'name' => '首页设置',
                        'route' => 'admin.business.home_describe',
                        'description' => null,
                        'items' => null,
                    ],
                    [
                        'name' => '入驻描述设置',
                        'route' => 'admin.business.enter_describe',
                        'description' => null,
                        'items' => null,
                    ],
                    [
                        'name' => '注册描述设置',
                        'route' => 'admin.business.register_describe',
                        'description' => null,
                        'items' => null,
                    ],
                    [
                        'name' => '年费设置',
                        'route' => 'admin.business.fee_describe',
                        'description' => null,
                        'items' => null,
                    ],
                ],
            ],
            [
                'name' => '商家分组',
                'route' => 'admin.business.group_index',
                'description' => null,
                'items' => null,
            ],
            [
                'name' => '行业分类',
                'route' => 'admin.business.biz_category_index',
                'description' => null,
                'items' => null,
            ],
            [
                'name' => '联盟商家列表',
                'route' => 'admin.business.biz_union_index',
                'description' => null,
                'items' => null,
            ],
            [
                'name' => '普通商家列表',
                'route' => 'admin.business.biz_index',
                'description' => null,
                'items' => null,
            ],
            [
                'name' => '商家资质审核管理',
                'route' => 'admin.business.biz_apply_index',
                'description' => null,
                'items' => null,
            ],
            [
                'name' => '商家支付记录',
                'route' => 'admin.business.enter_pay',
                'description' => null,
                'items' => [
                    [
                        'name' => '入驻支付列表',
                        'route' => 'admin.business.enter_pay',
                        'description' => null,
                        'items' => null,
                    ],
                    [
                        'name' => '续费支付列表',
                        'route' => 'admin.business.charge_pay',
                        'description' => null,
                        'items' => null,
                    ],
                    [
                        'name' => '保证金退款列表',
                        'route' => 'admin.business.bail_back',
                        'description' => null,
                        'items' => null,
                    ],
                ],
            ],
        ],
    ],
    [
        'name' => '活动管理',
        'icon' => 'rocket',
        'route' => null,
        'items' => [
            [
                'name' => '活动列表',
                'route' => 'admin.active.index',
                'description' => null,
                'items' => null,
            ],
            [
                'name' => '创建活动',
                'route' => 'admin.active.create',
                'description' => null,
                'items' => null,
            ],
        ],
    ],
    [
        'name' => '我的微信',
        'icon' => 'weixin',
        'route' => null,
        'items' => [
            [
                'name' => '微信接口配置',
                'route' => 'admin.wechat.api_index',
                'description' => null,
                'items' => null,
            ],
            /*[
                'name' => '首次关注设置',
                'route' => 'admin.wechat.reply_index',
                'description' => null,
                'items' => null,
            ],*/
            [
                'name' => '自定义菜单设置',
                'route' => 'admin.wechat.menu_index',
                'description' => null,
                'items' => null,
            ],
            /*[
                'name' => '关键词回复设置',
                'route' => 'admin.wechat.keyword_index',
                'description' => null,
                'items' => null,
            ],*/
            /*[
                'name' => '图文消息管理',
                'route' => 'admin.wechat.material_index',
                'description' => null,
                'items' => null,
            ],*/
        ],
    ],
    [
        'name' => '财务统计',
        'icon' => 'bar-chart',
        'route' => null,
        'items' => [
            [
                'name' => '销售记录',
                'route' => 'admin.statistics.sale_record',
                'description' => null,
                'items' => null,
            ],
            /*[
                'name' => '自动结算配置',
                'route' => 'admin.statistics.balance_index',
                'description' => null,
                'items' => null,
            ],*/
            [
                'name' => '生成报告',
                'route' => 'admin.statistics.report_index',
                'description' => null,
                'items' => null,
            ],
            [
                'name' => '付款单',
                'route' => 'admin.statistics.bill_index',
                'description' => null,
                'items' => null,
            ],
        ],
    ],
    [
        'name' => '微官网',
        'icon' => 'edge',
        'route' => null,
        'items' => [
            [
                'name' => '风格设置',
                'route' => 'admin.web.skin_config',
                'description' => null,
                'items' => null,
            ],
            [
                'name' => '首页设置',
                'route' => 'admin.web.home_config',
                'description' => null,
                'items' => null,
            ],
            [
                'name' => '栏目管理',
                'route' => 'admin.web.column_index',
                'description' => null,
                'items' => null,
            ],
            [
                'name' => '内容管理',
                'route' => 'admin.web.article_index',
                'description' => null,
                'items' => null,
            ],
            [
                'name' => '一键导航',
                'route' => 'admin.web.lbs_index',
                'description' => null,
                'items' => null,
            ],
        ],
    ],

]);
