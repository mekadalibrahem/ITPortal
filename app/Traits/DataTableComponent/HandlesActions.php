<?php


namespace App\Traits\DataTableComponent;

use Masmerise\Toaster\Toaster;

trait HandlesActions
{
    

    public function edit($id): void
    {

        Toaster::warning(trans("messages.Don't support this action yet"));
    }

    public function delete($id = 0): void
    {
        Toaster::warning(trans("messages.Don't support this action yet"));
    }
}
