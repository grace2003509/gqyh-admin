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


if ( ! function_exists('round_pad_zero'))
{
    /**
     * 浮点数四舍五入补零函数
     *
     * @param float $num
     *        	待处理的浮点数
     * @param int $precision
     *        	小数点后需要保留的位数
     * @return float $result 处理后的浮点数
     */
    function round_pad_zero($num, $precision) {
        if ($precision < 1) {
            return round($num, $precision);
        }

        $r_num = round($num, $precision);
        $num_arr = explode('.', "$r_num");
        if (count($num_arr) == 1) {
            return "$r_num" . '.' . str_repeat('0', $precision);
        }
        $point_str = "$num_arr[1]";
        if (strlen($point_str) < $precision) {
            $point_str = str_pad($point_str, $precision, '0');
        }
        return $num_arr[0] . '.' . $point_str;
    }
}


if(!function_exists('sdate')){
    /*
     *return short format date,not incluing hour,minutes,seconds
     *
     */
    function sdate($time = '')
    {
        if (strlen($time) == 0) {
            $time = time();
        }
        if (is_string($time)) {
            $time = intval($time);
        }
        return date('Y/m/d', $time);
    }
}

if(!function_exists('ldate')){
    /*
     *return short format date,not incluing hour,minutes,seconds
     *
     */
    function ldate($time = '')
    {
        if (strlen($time) == 0) {
            $time = time();
        }
        if (is_string($time)) {
            $time = intval($time);
        }
        return date('Y/m/d H:i:s', $time);
    }
}


if ( ! function_exists('days_in_month'))
{
    /**
     * Number of days in a month
     *
     * Takes a month/year as input and returns the number of days
     * for the given month/year. Takes leap years into consideration.
     *
     * @param	int	a numeric month
     * @param	int	a numeric year
     * @return	int
     */
    function days_in_month($month = 0, $year = '')
    {
        if ($month < 1 OR $month > 12)
        {
            return 0;
        }
        elseif ( ! is_numeric($year) OR strlen($year) !== 4)
        {
            $year = date('Y');
        }

        if (defined('CAL_GREGORIAN'))
        {
            return cal_days_in_month(CAL_GREGORIAN, $month, $year);
        }

        if ($year >= 1970)
        {
            return (int) date('t', mktime(12, 0, 0, $month, 1, $year));
        }

        if ($month == 2)
        {
            if ($year % 400 === 0 OR ($year % 4 === 0 && $year % 100 !== 0))
            {
                return 29;
            }
        }

        $days_in_month	= array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        return $days_in_month[$month - 1];
    }
}