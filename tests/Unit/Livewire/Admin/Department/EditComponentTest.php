<?php

namespace Tests\Unit\Livewire\Admin\RequestType;

use App\Livewire\Admin\Department\Edit;
use App\Models\Department;
use App\Models\Employee;
use App\Models\RequestType;
use Livewire\Livewire;
use Tests\TestCase;

class EditComponentTest extends TestCase
{

    public $component = Edit::class;
    public $table_name = 'departments';

    /**
     * A basic unit test example.
     */
    public function test_component_render(): void
    {
        $this->getUser('admin');
        Livewire::test($this->component)
            ->assertHasNoErrors();
    }

    public function test_valid_edit_name(): void
    {
        $this->getUser('admin');


        $dep = Department::create([
            'name' => "Test Add new Department name",
            'description' => "THIS Department for Testing only Don't Forget that",
            'dep_manager' => null,
        ]);

        $this->assertNotNull($dep);
        $component = Livewire::test($this->component, ['id' => $dep->id])
            ->assertHasNoErrors();
        $name = "Test Add new Department name new edit";

        $component->set('name', $name);
        $component->call('edit');
        $this->assertDatabaseHas($this->table_name, [
            "name" => $name,
            "description" => $dep->description,
            "manager_id" => null
        ]);
    }
    public function test_invalid_edit_name_min(): void
    {
        $this->getUser('admin');


        $dep = Department::create([
            'name' => "Test Add new Department name",
            'description' => "THIS Department for Testing only Don't Forget that",
            'dep_manager' => null,
        ]);

        $this->assertNotNull($dep);
        $component = Livewire::test($this->component, ['id' => $dep->id])
            ->assertHasNoErrors();
        $name = "Test";

        $component->set('name', $name);
        $component->call('edit');
        $this->assertDatabaseMissing($this->table_name, [
            "name" => $name,
            "description" => $dep->description,
            "manager_id" => null
        ]);
    }
    public function test_invalid_edit_name_unique(): void
    {
        $this->getUser('admin');

        $dep1 = Department::create([
            'name' => "Test Add new Department name1",
            'description' => "THIS Department for Testing only Don't Forget that1",
            'dep_manager' => null,
        ]);
        $dep = Department::create([
            'name' => "Test Add new Department name2",
            'description' => "THIS Department for Testing only Don't Forget that2",
            'dep_manager' => null,
        ]);

        $this->assertNotNull($dep);
        $component = Livewire::test($this->component, ['id' => $dep->id])
            ->assertHasNoErrors();
        $name = $dep1->name;

        $component->set('name', $name);
        $component->call('edit');
        $this->assertDatabaseMissing($this->table_name, [
            "name" => $name,
            "description" => $dep->description,
            "manager_id" => null
        ]);
    }

    public function test_valid_edit_description(): void
    {
        $this->getUser('admin');


        $dep = Department::create([
            'name' => "Test Add new Department name",
            'description' => "THIS Department for Testing only Don't Forget that",
            'dep_manager' => null,
        ]);

        $this->assertNotNull($dep);
        $component = Livewire::test($this->component, ['id' => $dep->id])
            ->assertHasNoErrors();
        $description = "Test Add new Department name new edit this is new Description";

        $component->set('description', $description);
        $component->call('edit');
        $this->assertDatabaseHas($this->table_name, [
            "name" => $dep->name,
            "description" => $description,
            "manager_id" => null
        ]);
    }
    public function test_invalid_edit_description_min(): void
    {
        $this->getUser('admin');


        $dep = Department::create([
            'name' => "Test Add new Department name",
            'description' => "THIS Department for Testing only Don't Forget that",
            'dep_manager' => null,
        ]);

        $this->assertNotNull($dep);
        $component = Livewire::test($this->component, ['id' => $dep->id])
            ->assertHasNoErrors();
        $description = "Test";

        $component->set('description', $description);
        $component->call('edit');
        $this->assertDatabaseMissing($this->table_name, [
            "name" => $dep->name,
            "description" => $description,
            "manager_id" => null
        ]);
    }

    public function test_valid_set_manager() : void {
        $this->getUser('admin');


        $dep = Department::create([
            'name' => "Test Add new Department name",
            'description' => "THIS Department for Testing only Don't Forget that",
            'dep_manager' => null,
        ]);

        $this->assertNotNull($dep);
        $manager = Employee::canManager($dep->id)->first();
        $this->assertNotNull($manager);
        $component = Livewire::test($this->component, ['id' => $dep->id])
            ->assertHasNoErrors();

        $manager_id = $manager->id ;
        $component->set('manager_id', $manager_id);
        $component->call('edit');
        $this->assertDatabaseHas($this->table_name, [
            "name" => $dep->name,
            "description" => $dep->description,
            "manager_id" => $manager_id
        ]);
    }

}
