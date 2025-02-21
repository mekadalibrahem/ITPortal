<?php

namespace App\Traits\DataTableComponent ;

use Rappasoft\LaravelLivewireTables\Views\Column;

trait ConfiguresTable {


    public function configuring(): void
    {
        $this->setEmptyMessage($this->emptyMessage);
        $this->setSearchStatus(false);
        $this->setDefaultSort('id', 'desc');
        $this->setPerPageAccepted([5, 10, 25]);
        $this->setPerPage(5);
        $this->setThAttributes(function (Column $column) {
            return [
                'default' => true,
                'default-styling' => true,
                'class' => 'text-start',
            ];
        });
    }
    public function setAddButton($addButtonRoute){
        $this->setConfigurableAreas([
            'toolbar-left-start' => [
                'components.widgets.btn-create-new',
                [
                    'href' => $addButtonRoute,
                    'text' => trans('string.Add'),
                ],
            ],
        ]);
    }
}


