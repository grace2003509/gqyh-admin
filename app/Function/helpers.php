<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/8/8
 * Time: 16:39
 */

use Carbon\Carbon;


if (! function_exists('warning')) {
    function warning($message, $context = []) {
        return app('log')->warning($message, $context);
    }
}

function date_between($range, $delimiter=' - ') {
    $range = explode($delimiter, $range, 2);
    if (count($range) == 2) {
        $begin_time = strtotime($range[0]); $end_time = strtotime($range[1]);
        if ($begin_time === false || $end_time === false || $end_time < $begin_time) {
            return null;
        }
        return [
            Carbon::createFromTimestamp($begin_time)->startOfDay(),
            Carbon::createFromTimestamp($end_time)->endOfDay(),
        ];
    }
    return null;
}

function current_store() {
    static $store;
    if (! isset($store)) {
        $store = auth()->user()->store_code;
    }
    return $store;
}

function route_matches($menu) {
    $list = [ $menu ];
    while ($page = array_pop($list)) {
        if ($page->route && Route::is($page->route)) {
            return true;
        } else if ($page->items) {
            $list = array_merge($page->items, $list);
        }
    }
    return false;
}

function perm_matches($menu,$level = 2)
{
    if (Auth::user()->hasRole('administrator')) {
        return true;
    }
    if($level <= 0 ){
        return false;
    }
    if ($menu->route && Entrust::can($menu->route)) {
        return true;
    }
    if ($menu->items) {
        foreach ($menu->items as $page) {
            if (perm_matches($page,$level-1)) {
                return true;
            }
        }
    }
    return false;
}

function perm_match($menu)
{
    if (Auth::user()->hasRole('administrator')) {
        return true;
    }
    if ($menu->route && Entrust::can($menu->route)) {
        return true;
    }
    return false;
}