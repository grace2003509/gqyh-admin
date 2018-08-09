<?php

namespace App\Services\Validation;

use Illuminate\Http\Request;


class WorkerScheduleValidator extends Validator
{

    /**
     * 创建表单验证
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public static function validateCreateFromRequest(Request $request)
    {
        self::validate($request->input(), [
            'uid' => 'required|exists:workers,uid,status,!0',
            'date' => 'required|date',
            'status' => 'required|regex:/^[1,4]{1}$/',
        ]);

    }


    /**
     * 编辑表单验证
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public static function validateUpdateFromRequest(Request $request)
    {
        self::validate($request->input(), [
            'uid' => 'required|exists:workers,uid,status,!0',
            'date' => 'required|date',
            'status' => 'required|regex:/^[1,4]{1}$/',
        ]);

    }


    /**
     * 返回验证信息
     * @return array
     */
    public static function messages()
    {
        return [
            'status.regex' => '请勿传入非法状态',
            'uid.exists' => '没有查到符合条件的工人',
        ];

    }


    /**
     * 设置属性名称
     * @return array
     */
    public static function attributes()
    {
        return [
            'uid' => '工人编号',
            'status' => '接单状态',
            'date' => '排工日期',
        ];
    }

}