<?php

namespace App\Services;

use InvalidArgumentException, UnexpectedValueException;

class BaseDictionaryService
{
    private static $stores;

    /**
     * 获取总店 id
     * @return string
     */
    public static function getHeadStoreCode()
    {
        return 'S000000';
    }

    /**
     * 获取分店列表
     * @param bool $only_keys
     * @return array
     */
    public static function getStoreList($only_keys = false)
    {
        if (!isset(self::$stores)) {
            self::$stores = config('stores', []);
        }

        if ($only_keys) {
            return implode(',', array_keys(self::$stores)) . ',' . self::getHeadStoreCode();
        }

        return self::$stores;
    }

    /**
     * 更新分店列表
     */
    public static function updateStoreList()
    {
        $result = BaseApiClientService::post('App/WorkerRelation/get_shop');
        $stores = [];
        foreach ($result as $shop) {
            $stores[$shop->store_code] = $shop->title;
        }

        $config = '<?php return ' . var_export($stores, true) . ';' . PHP_EOL;
        file_put_contents(config_path('stores.php'), $config);
    }

    /**
     * 获取分店名称
     * @param $store_code
     * @param null $default
     * @return string|null
     */
    public static function getStoreName($store_code, $default = null)
    {
        if ($store_code == self::getHeadStoreCode()) {
            return '总店';
        }

        $stores = self::getStoreList();
        if (isset($stores[$store_code])) {
            return $stores[$store_code];
        }
        return $default === null ? $store_code : $default;
    }

    /**
     * 获取工人工种
     * @param bool $only_keys
     * @return array
     */
    public static function getWorkerTypes($only_keys = false)
    {
        $list = config("constants.worker_types", []);

        if ($only_keys) {
            return implode(',', array_keys($list));
        }
        return $list;
    }

    /**
     * 获取工人类型
     * @param bool $only_keys
     * @return array
     */
    public static function getWorkerRoles($only_keys = false)
    {
        $list = config("constants.worker_roles", [
            1 => '施工工人',
            2 => '施工员',
        ]);

        if ($only_keys) {
            return implode(',', array_keys($list));
        }
        return $list;
    }

    /**
     * 获取文化程度
     * @param bool $only_keys
     * @return array
     */
    public static function getEducationLevels($only_keys = false)
    {
        $list = config('constants.education_levels', []);

        if ($only_keys) {
            return implode(',', array_keys($list));
        }
        return $list;
    }

    /**
     * 与工人的关系
     * @param bool $only_keys
     * @return array
     */
    public static function getSocialRelations($only_keys = false)
    {
        $list = config('constants.social_relations', []);

        if ($only_keys) {
            return implode(',', $list);
        }
        return $list;
    }

    /**
     * 工人来源
     * @return array
     */
    public static function getWorkerSources()
    {
        return [
            1 => '系统录入',
            2 => '批量导入',
            3 => 'APP注册',
        ];
    }

    /**
     * 工人排期状态
     * @return array
     */
    public static function getScheduleStatus()
    {
        return [
            1 => '已接单',
            4 => '不接单',
        ];
    }


    /**
     * 奖惩单状态
     * @return array
     */
    public static function getBonusStatus()
    {
        return [
            2 => '待审批',
            3 => '已核实',
            4 => '已取消',
            5 => '已执行',
        ];
    }

}


