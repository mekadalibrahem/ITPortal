<?php

namespace App\Enums;



enum DataTypeEnum: string
{
    case STRING = "string";
    case IMAGE = "image";
    case NID  = "national id";
    case NUMBER = "number";

    public static function get_role($key)
    {
        switch ($key) {
            case DataTypeEnum::IMAGE->value:
                return 'required|image|max:4096';
                break;
            case DataTypeEnum::STRING->value:
                return 'required';
                break;
            case DataTypeEnum::NID->value:
                return 'required';
                break;

            case DataTypeEnum::NUMBER->value:
                return 'required';
                break;

            default:
                throw new \Exception("INVALID DATA TYPE", 1);

                break;
        }
    }
}
