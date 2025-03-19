<?php

namespace Tests\Unit\Livewire\Admin\Department;

use App\Livewire\DataTables\DepartmentTable;
use App\Models\Department;
use App\Models\Employee;
use Livewire\Livewire;
use Tests\TestCase;

class ViewTableTest extends TestCase
{
    public $component = DepartmentTable::class;
    public $table_name = 'departments';

    public function test_component_render(): void
    {
        $this->getUser('admin');

        Livewire::test($this->component)
            ->assertHasNoErrors();
    }


    public function test_redirect_to_edit(): void
    {
        $this->getUser('admin');
        $department = Department::create([
            "name" => 'test-department' ,
            "description" => "department description this for just testing",
            "manager_id" => Employee::query()->first()->id
        ]);
        $this->assertNotNull($department);

        $component = Livewire::test($this->component)
            ->assertHasNoErrors();

        $component->call('edit', $department->id);
        $component->assertRedirectToRoute('admin.department.edit', ['id' => $department->id]);
    }

    public function test_delete_type(): void
    {
        $this->getUser('admin');
        $employee = Employee::query()->first();
        $department = Department::create([
            "name" => 'test-department' ,
            "description" => "department description this for just testing",
            "manager_id" => $employee->id
        ]);
        $this->assertNotNull($department);
        $this->assertDatabaseHas($this->table_name, [
            "name" => 'test-department' ,
            "description" => "department description this for just testing",
            "manager_id" => $employee->id
        ]);

        $component = Livewire::test($this->component)
            ->assertHasNoErrors();

        $component->call('delete', $department->id);
        $this->assertDatabaseMissing($this->table_name, [
            "name" => 'test-department' ,
            "description" => "department description this for just testing",
            "manager_id" => $employee->id
        ]);
    }
}
