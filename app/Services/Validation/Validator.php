<?php
namespace App\Services\Validation;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


abstract class Validator
{
    /*
    abstract public static function validateCreateFromRequest(Request $request);

    abstract public static function validateUpdateFromRequest(Request $request, $object);*/


    public static function attributes()
    {
        return [ ];
    }

    public static function messages()
    {
        return [ ];
    }

    protected static function validate($data, $rules)
    {
        if (is_null($data)) return;
        $validator = validator($data, $rules, static::messages(), static::attributes());
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

}