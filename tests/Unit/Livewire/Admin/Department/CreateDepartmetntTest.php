<?php

namespace Tests\Unit\Livewire\Admin\RequestType;

use App\Livewire\Admin\Department\Create ;
use App\Models\Department;
use App\Models\RequestType;
use Livewire\Livewire;
use Tests\TestCase;

class CreateDepartmetntTest extends TestCase
{

    public $component = Create::class;
    public $table_name= 'departments' ;

    /**
     * A basic unit test example.
     */
    public function test_component_render(): void
    {
        $this->getUser('admin');
        Livewire::test($this->component)
            ->assertHasNoErrors();
    }

    public function test_valid_create(): void
    {
        $this->getUser('admin');
        $component = Livewire::test($this->component)
            ->assertHasNoErrors();
            $name = "Test Add new Department name";
            $description = "THIS Department for Testing only Don't Forget that";
            $dep_manager = 0;
        $component->set('name', $name);
        $component->set('description', $description);
        $component->set('dep_manager', $dep_manager);

        $component->call('select_manager');
        $component->call('add');
        $this->assertDatabaseHas($this->table_name, [
            "name"=> $name,
            "description"=> $description,
            "manager_id"=> null
        ]);
    }

    public function test_invalid_create_status_invlaid_min(): void
    {
        $component = Livewire::test($this->component)
        ->assertHasNoErrors();
        $name = "Test";
        $description = "THIS";
        $dep_manager = 0;
    $component->set('name', $name);
    $component->set('description', $description);
    $component->set('dep_manager', $dep_manager);

    $component->call('select_manager');
    $component->call('add');
    $component->assertHasErrors([
        'name' => 'min',
        'description' => 'min',
    ]);

    }
    public function test_invalid_create_status_invlaid_unique_name(): void
    {
        $component = Livewire::test($this->component)
        ->assertHasNoErrors();
        $dep = Department::query()->first();
        $name = $dep->name;
        $description = "THIS Department for Testing only Don't Forget that";
        $dep_manager = 0;
    $component->set('name', $name);
    $component->set('description', $description);
    $component->set('dep_manager', $dep_manager);
    $component->call('select_manager');
    $component->call('add');
    $component->assertHasErrors([
        'name' => 'unique'

    ]);

    }
}
