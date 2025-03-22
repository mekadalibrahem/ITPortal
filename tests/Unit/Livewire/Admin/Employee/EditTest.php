<?php

namespace Tests\Unit\Livewire\Admin\Employee;

use App\Livewire\Admin\Employee\Edit;
use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class EditTest extends TestCase
{

    public $component = Edit::class;
    public $table_name = 'employees';
    // TODO write tests for this components
    public function test_component_render(): void
    {
        $this->getUser('admin');
        Livewire::test($this->component)
            ->assertHasNoErrors();
    }

    public function test_valid_edit_department(): void
    {
        $this->getUser('admin');

        // create new user for adding hime like employee
        $user = User::factory()->create();
        $this->assertNotNull($user);
        $this->assertInstanceOf(User::class, $user);
        // add for employee
        $emp = Employee::create([
            'user_id' => $user->id ,
            'department_id' => null
        ]);

        $this->assertDatabaseHas($this->table_name, [
            'user_id' => $user->id,
            'department_id' => null
        ]);
        $component = Livewire::test($this->component , ['id' => $emp->id])
        ->assertHasNoErrors();
        // get new dep
        $dep = Department::query()->first();
        $this->assertNotNull($dep);
        $component->set('department' , $dep->id);
        $component->call('edit');
        $this->assertDatabaseHas($this->table_name, [
            'user_id' => $user->id,
            'department_id' => $dep->id
        ]);
    }

}
