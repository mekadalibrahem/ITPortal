<?php

namespace App\Classes\Services\MessagesBuilder;

class RequestMessageBuilder
{


    public static function build($message, $request_id,)
    {
        $url =  self::generateRequestUrl($request_id);
        return <<<EOT
            $message <br/>
            You can show request from here :<br/>
            <a   style='color: blue; text-decoration: underline;' href='$url'  target='_blank'> request page</a> 
EOT;
    }

    private static function generateRequestUrl($request_id)
    {
        return route('user.requests.index', ['id' => $request_id]);
    }
}
