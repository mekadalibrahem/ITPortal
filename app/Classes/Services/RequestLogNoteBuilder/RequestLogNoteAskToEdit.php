<?php

namespace App\Classes\Services\RequestLogNoteBuilder;

class RequestLogNoteAskToEdit
{


    public static function build($userEmail, $message): string
    {
        $note = $message . "\n";
        $note .= "by : " . $userEmail . " (" . now()->format('Y-m-d H:i:s') . ")\n";
        $note .= "----------------------\n";

        return $note;
    }
}
