<?php

namespace App\Classes\Services\RequestLogNoteBuilder;

class RequestLogNoteEditedBuilder
{


    public static function build($userEmail, $dataChanged): string
    {
        $note = "Data updated : \n";

        foreach ($dataChanged as $item) {
            if (!isset($item['isImage']) || !$item['isImage']) {
                $note .= "[ " . $item['key'] . " ] from [" . $item['old'] . '] to [' . $item['new'] . "] \n";
            } else {
                $note .= "[ " . $item['key'] . " ] image updated \n";
            }
        }

        $note .= "\nby : " . $userEmail . " (" . now()->format('Y-m-d H:i:s') . ")\n";
        $note .= "---------------------------\n";

        return $note;
    }
}
