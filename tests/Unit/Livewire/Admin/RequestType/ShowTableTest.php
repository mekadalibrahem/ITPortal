<?php

namespace Tests\Unit\Livewire\Admin\RequestType;

use App\Livewire\DataTables\RequestTypeTable;
use App\Models\RequestType;
use Livewire\Livewire;
use Tests\TestCase;

class ShowTableTest extends TestCase
{
    public $component = RequestTypeTable::class;
    public $table_name= 'request_types' ;

    public function test_component_render(): void
    {
        $this->getUser('admin');

        Livewire::test($this->component )
            ->assertHasNoErrors();
    }


    public function test_redirect_to_edit() : void {
        $this->getUser('admin');
        $reqestType = RequestType::create(['type' => 'test_type']);
        $this->assertNotNull($reqestType);

        $component = Livewire::test($this->component )
            ->assertHasNoErrors();

        $component->call('edit' , $reqestType->id);
        $component->assertRedirectToRoute('admin.requests.type.edit' ,['id' => $reqestType->id]);
    }

    public function test_delete_type() : void {
        $this->getUser('admin');
        $reqestType = RequestType::create(['type' => 'test_type']);
        $this->assertNotNull($reqestType);
        $this->assertDatabaseHas($this->table_name, [
            'type' => $reqestType->type
        ]);

        $component = Livewire::test($this->component )
            ->assertHasNoErrors();

        $component->call('delete' , $reqestType->id);
        $this->assertDatabaseMissing($this->table_name, [
            'type' => $reqestType->type
        ]);
    }
}
