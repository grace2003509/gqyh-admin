<?php

namespace App\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //不得大于
        Validator::extend('nothan', function ($attribute, $value, $parameters, $validator) {
            //需验证的值$value
            $other = Input::get($parameters[0]);//获取需对比的参数值
            if($value > $other){
                return false;
            }else{
                return true;
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
