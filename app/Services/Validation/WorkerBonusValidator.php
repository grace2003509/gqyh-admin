<?php

namespace App\Services\Validation;

use Illuminate\Http\Request;


class WorkerBonusValidator extends Validator
{

    /**
     * 创建表单验证
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public static function validateCreateFromRequest(Request $request)
    {
        self::validate($request->input(), [
            'worker_id' => 'required|exists:workers,id,status,!0,worker_role,!2',
            'type' => 'required',
            'total_fee' => 'required|numeric|max:9999999.999',
            'construction_code' => 'required|max:20|regex:/^[A-Za-z]{2,3}[0-9]{1,}$/',
            'construction_node' => 'sometimes|max:50',
            'finished_at' => 'sometimes|date',
            'reason' => 'sometimes|max:20',
            'remarks' => 'sometimes|max:50',
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
            'worker_id' => 'required|exists:workers,id,status,!0,worker_role,!2',
            'type' => 'required',
            'total_fee' => 'required|numeric|max:9999999.999',
            'construction_code' => 'required|max:20|regex:/^[A-Za-z]{2,3}[0-9]{1,}$/',
            'construction_node' => 'sometimes|max:50',
            'finished_at' => 'sometimes|date',
            'reason' => 'sometimes|max:20',
            'remarks' => 'sometimes|max:50',
        ]);

    }



    /**
     * App创建奖惩单表单验证
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public static function validateApiCreateFromRequest(Request $request)
    {
        self::validate($request->input(), [
            'uid' => 'required|exists:workers,uid,status,!0,worker_role,!2',
            'type' => 'required|boolean',
            'total_fee' => 'required|numeric|max:9999999.999',
            'crew_uid' => 'required|exists:workers,uid,status,!0,worker_role,2',
            'construction_code' => 'required|max:20|regex:/^[A-Za-z]{2,3}[0-9]{1,}$/',
            'construction_node' => 'sometimes|max:50',
            'finished_at' => 'sometimes|date',
            'reason' => 'sometimes|max:20',
            'remarks' => 'sometimes|max:50',
        ]);
    }


    /**
     * 查询表单验证
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public static function validateGetFromRequest(Request $request)
    {
        self::validate($request->input(), [
            'worker_code' => 'required|exists:workers,worker_code,status,!0,worker_role,!2',
        ]);

    }


    /**
     * 奖惩单施工员API列表验证
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public static function validateApiGetRequest(Request $request)
    {
        self::validate($request->input(), [
            'crew_uid' => 'required|exists:workers,uid,status,!0,worker_role,2',
            'type' => 'sometimes|regex:/^[1,2]{1}$/',
            'bonus_status' => 'sometimes|regex:/^[1,2,3,4,5]{1}$/'
        ]);

    }


    /**
     * 奖惩单工人API列表验证
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public static function validateApiWorkerGetRequest(Request $request)
    {
        self::validate($request->input(), [
            'uid' => 'required|exists:workers,uid,status,!0,worker_role,1',
            'type' => 'sometimes|regex:/^[1,2]{1}$/',
            'bonus_status' => 'sometimes|regex:/^[2,3,4,5]{1}$/'
        ]);

    }


    /**
     * 接口反馈奖惩单状态验证
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public static function validateApiBackFromRequest(Request $request)
    {
        self::validate($request->input(), [
            'bonus_code' => 'required|exists:worker_bonuses,bonus_code,status,2',
            'remarks' => 'sometimes|max:50',
        ]);

    }


    /**
     * 返回验证信息
     * @return array
     */
    public static function messages()
    {
        return [
            'construction_code.regex' => '关联作业单号格式不正确',
            'bonus_code.exists' => '奖惩单不符合要求',
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
            'worker_id' => '工人ID',
            'type' => '奖惩类型',
            'total_fee' => '奖惩金额',
            'construction_code' => '关联作业单号',
            'construction_node' => '项目节点',
            'reason' => '奖惩原因',
            'remarks' => '备注',
            'bonus_code' => '奖惩单',
            'finished_at' => '结束时间',
            'crew_uid' => '施工员',
            'code' => '工人',
            'bonus_status' => '奖惩单状态',
            'worker_code' => '工人工号'
        ];
    }

}