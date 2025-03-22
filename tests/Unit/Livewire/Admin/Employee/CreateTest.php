<?php

namespace Tests\Unit\Livewire\Admin\Employee;

use App\Livewire\Admin\Employee\Create;
use App\Models\Employee;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CreateTest extends TestCase
{

    public $component = Create::class;
    public $table_name = 'employees';

    public function test_component_render(): void
    {
        $this->getUser('admin');
        Livewire::test($this->component)
            ->assertHasNoErrors();
    }

    public function test_valid_create(): void
    {
        $this->getUser('admin');

        // create new user for adding hime like employee
        $user2 = User::factory()->create();
        $this->assertNotNull($user2);
        $this->assertInstanceOf(User::class, $user2);

        // check user not register like employee
        $this->assertDatabaseMissing($this->table_name, [
            'user_id' => $user2->id
        ]);
        //check if role exist
        $employee_role = Role::query('name', '=', 'employee')->first();
        $this->assertNotNull($employee_role);


        // check if user don't have employee role
        $this->assertNotTrue($user2->hasRole('employee'));


        // add new employee
        $component = Livewire::test($this->component)
            ->assertHasNoErrors();
        $component->set('nid', $user2->national_id);
        $component->call('add');
        $component->assertHasNoErrors();

        $this->assertDatabaseHas($this->table_name, [
            'user_id' => $user2->id
        ]);
        // update user information
        $user3 = User::find($user2->id);
        // check if employee role added for this user
        $this->assertTrue($user3->hasRole('employee'));
    }

    public function test_invalid_create_wrong_user_nid(): void
    {
        $this->getUser('admin');

        $wrong_nid = 9999999999;
        // ensur nid not register for any user
        $this->assertDatabaseMissing('users', [
            'national_id' => $wrong_nid
        ]);
        $this->assertDatabaseMissing($this->table_name, [
            'user_id' => $wrong_nid
        ]);
        $component = Livewire::test($this->component)
            ->assertHasNoErrors();
        $component->set('nid', $wrong_nid);
        $component->call('add');
        $component->assertHasErrors([
            'nid' => 'exists'
        ]);
    }

    public function test_invalid_create_employee_exists(): void
    {
        $this->getUser('admin');
        $user = User::factory()->create();
        $this->assertNotNull($user);
        $this->assertInstanceOf(User::class, $user);

        $employee = Employee::create([
            'user_id' => $user->id
        ]);
        $this->assertDatabaseHas($this->table_name, [
            'user_id' => $user->id
        ]);
        $component = Livewire::test($this->component)
            ->assertHasNoErrors();
        $component->set('nid', $user->id);
        $component->call('add');
        $component->assertHasErrors([
            'nid'
        ]);
    }
}
