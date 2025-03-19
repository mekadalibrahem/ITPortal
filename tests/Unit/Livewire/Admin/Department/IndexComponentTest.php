<?php

namespace Tests\Unit\Livewire\Admin\RequestType;

use App\Livewire\Admin\Department\Index;
use App\Models\Department;
use App\Models\Employee;
use Livewire\Livewire;
use Tests\TestCase;

class IndexComponentTest extends TestCase
{

    public $component = Index::class;
    public $table_name = 'departments';

    /**
     * A basic unit test example.
     */
    public function test_component_render(): void
    {
        $this->getUser('admin');
        $dep = Department::create([
            'name' => "Test Add new Department name",
            'description' => "THIS Department for Testing only Don't Forget that",
            'dep_manager' => null,
        ]);
        Livewire::test($this->component, ['id' => $dep->id])
            ->assertHasNoErrors();
    }

    public function test_add_employee(): void
    {
        $this->getUser('admin');
        $dep = Department::create([
            'name' => "Test Add new Department name",
            'description' => "THIS Department for Testing only Don't Forget that",
            'dep_manager' => null,
        ]);
        $component = Livewire::test($this->component, ['id' => $dep->id])
            ->assertHasNoErrors();

        $employee = Employee::free()->first();
        $this->assertNotNull($employee);
        $component->set('new_employee' , $employee->id);
        $component->call('insert');
        $component->assertHasNoErrors();
        $this->assertDataBaseHas('employees', [
            'user_id' => $employee->user_id ,
            'id' => $employee->id ,
            'department_id' => $dep->id
        ]);
    }

    public function test_remove_employee(): void
    {
        $this->getUser('admin');
        $dep = Department::create([
            'name' => "Test Add new Department name",
            'description' => "THIS Department for Testing only Don't Forget that",
            'dep_manager' => null,
        ]);
        $component = Livewire::test($this->component, ['id' => $dep->id])
            ->assertHasNoErrors();

        $employee = Employee::free()->first();
        $this->assertNotNull($employee);
        $dep->addEmployee($employee);
        $this->assertDataBaseHas('employees', [
            'user_id' => $employee->user_id ,
            'id' => $employee->id ,
            'department_id' => $dep->id
        ]);
        $component->call('delete' , $employee->id);
        $component->assertHasNoErrors();
        $this->assertDatabaseMissing('employees', [
            'user_id' => $employee->user_id ,
            'id' => $employee->id ,
            'department_id' => $dep->id
        ]);
    }
}
