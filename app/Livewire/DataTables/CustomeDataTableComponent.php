<?php

namespace App\Livewire\DataTables;

use App\Traits\DataTableComponent\ConfiguresTable;
use App\Traits\DataTableComponent\HandlesActions;
use App\Traits\DataTableComponent\ManagesColumns;
use Rappasoft\LaravelLivewireTables\DataTableComponent;


abstract class CustomeDataTableComponent extends DataTableComponent
{
    use ConfiguresTable, ManagesColumns, HandlesActions;

    // Additional custom logic can go here
    
}
