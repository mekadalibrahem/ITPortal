<?php 


namespace App\Classes\RequestManagment; 


class RequestManagmentFactory {
    private static $instances = [
        'template' => null 
    ];
    public static  $TYPE_TEMPLATE = "template";

    private function __construct()
    {
        
    }

    public static function getInstance(string $key = "template"){
        $in = null ;
        switch($key){
            case self::$TYPE_TEMPLATE : 
                if(self::$instances[self::$TYPE_TEMPLATE] == null){
                    self::$instances[self::$TYPE_TEMPLATE] = new RequestManagmentTemplate();
                }
                $in  = self::$instances[self::$TYPE_TEMPLATE];
        }

        return $in ;
    }
}





