<?php

namespace App\Services\Validation;

use App\Services\BaseDictionaryService;
use Illuminate\Http\Request;


class WorkerValidator extends Validator
{

    public static function validateCreateFromRequest(Request $request)
    {
        $education_levels   = BaseDictionaryService::getEducationLevels(true);
        $worker_types       = BaseDictionaryService::getWorkerTypes(true);
        $worker_roles       = BaseDictionaryService::getWorkerRoles(true);

        self::validate($request->input('base'), [
            'name'          => 'required',
            'tel'           => 'required|tel|unique:workers,tel',
            'id_number'     => 'required|id|unique:workers,id_number',
            'birthday'      => 'date',
            'worker_role'   => 'required|in:'.$worker_roles,
            'worker_type'   => 'required_if:worker_role,1|subset:'.$worker_types,
            'education'     => 'in:'.$education_levels,
        ]);

        self::validate($request->input('contacts'), [
            '*.relation'    => 'required',
            '*.name'        => 'required',
            '*.tel'         => 'required|tel',
        ]);

        self::validate($request->input('careers'), [
            '*.period'      => 'required|daterange',
            '*.worker_type' => 'required|in:'.$worker_types,
        ]);
    }

    public static function validateUpdateFromRequest(Request $request, $worker)
    {
        $education_levels = BaseDictionaryService::getEducationLevels(true);
        $worker_types = BaseDictionaryService::getWorkerTypes(true);
        $worker_roles = BaseDictionaryService::getWorkerRoles(true);

        self::validate($request->input('base'), [
            'tel'           => 'tel|unique:workers,tel,'.$worker->id,
            'id_number'     => 'id|unique:workers,id_number,'.$worker->id,
            'worker_role'   => 'in:'.$worker_roles,
            'worker_type'   => 'required_if:worker_role,1|subset:'.$worker_types,
            'education'     => 'in:'.$education_levels,
        ]);

        self::validate($request->input('contacts'), [
            // '*.relation'    => 'required',
            '*.tel'         => 'tel',
        ]);

        self::validate($request->input('careers'), [
            '*.period'      => 'daterange',
            '*.worker_type' => 'in:'.$worker_types,
        ]);
    }

    public static function attributes()
    {
        return [
            'name'          => '姓名',
            'tel'           => '电话号码',
            'id_number'     => '身份证号',
            'birthday'      => '出生日期',
            'worker_role'   => '工人类型',
            'worker_type'   => '工人工种',
            'education'     => '文化程度',

            '*.name'        => '姓名',
            '*.tel'         => '电话号码',
            '*.relation'    => '关系',
            '*.worker_type' => '工人工种',
            '*.period'      => '工作起止日期',
        ];
    }

}