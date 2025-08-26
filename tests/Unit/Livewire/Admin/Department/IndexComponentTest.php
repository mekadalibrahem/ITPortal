<?php

namespace Tests\Unit\Livewire\Admin\RequestType;

use App\Livewire\Admin\Department\Index;
use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
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
            'stamp' => "test"
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
            'stamp' => "test"
        ]);
        $component = Livewire::test($this->component, ['id' => $dep->id])
            ->assertHasNoErrors();
        $newUser = User::factory()->create();
        $this->assertNotNull($newUser);
        $employee = Employee::create([
            'user_id' => $newUser->id,
        ]);
        $this->assertNotNull($employee);
        $employee2 = Employee::free()->first();
        $this->assertNotNull($employee2);
        $component->set('new_employee', $employee2->id);
        $component->call('insert');
        $component->assertHasNoErrors();
        $this->assertDataBaseHas('employees', [
            'user_id' => $employee2->user_id,
            'id' => $employee2->id,
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
            'stamp' => "test"
        ]);
        $component = Livewire::test($this->component, ['id' => $dep->id])
            ->assertHasNoErrors();
        $newUser = User::factory()->create();
        $this->assertNotNull($newUser);
        $employee = Employee::create([
            'user_id' => $newUser->id,
        ]);
        $this->assertNotNull($employee);
        $employee2 = Employee::free()->first();
        $this->assertNotNull($employee2);
        $dep->addEmployee($employee2);
        $this->assertDataBaseHas('employees', [
            'user_id' => $employee2->user_id,
            'id' => $employee2->id,
            'department_id' => $dep->id
        ]);
        $component->call('delete', $employee2->id);
        $component->assertHasNoErrors();
        $this->assertDatabaseMissing('employees', [
            'user_id' => $employee2->user_id,
            'id' => $employee2->id,
            'department_id' => $dep->id
        ]);
    }
}
