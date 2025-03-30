<?php

namespace App\Traits\DataTableComponent;

use Illuminate\Support\Facades\Schema;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Model;

trait ManagesColumns
{
    protected bool $columnUpdateAtStatus = true;
    protected bool $columnDeleteAtStatus = true;
    protected bool $columnActionsStatus = true;

    /**
     * Dynamically adjust column statuses based on the model's table schema.
     */
    public function initializeColumnStatuses()
    {

        $className = $this->getModel(); // Get the model instance

        if ($className) {
            // Ensure the class is a valid Eloquent model
            if (is_subclass_of($className, Model::class)) {
                // Create an instance of the model
                $modelInstance = new $className();
                if($modelInstance->timestamps){
                    $this->columnUpdateAtStatus = true;
                    $this->columnDeleteAtStatus = true;
                }else{
                    $this->columnUpdateAtStatus = false;
                    $this->columnDeleteAtStatus = false;
                }

            }
        }
    }
    public function appendColumns(): array
    {
        $this->initializeColumnStatuses();
        $array = [];

        if ($this->columnUpdateAtStatus) {
            $array[] = DateColumn::make(trans('string.update_at'), 'updated_at')->sortable();
        }

        if ($this->columnDeleteAtStatus) {
            $array[] = DateColumn::make(trans('string.create_at'), 'created_at')->sortable();
        }

        if ($this->columnActionsStatus) {
            $array[] = Column::make(trans('string.Options'))
                ->label(
                    fn($row) => view(
                        'livewire.actions',
                        [
                            'row' => $row,
                            'confirm_delete_message' => trans("messages.confirm delete request"),
                        ]
                    )
                )->html();
        }

        return $array;
    }
}
