<?php

namespace Tests\Unit\Livewire\Admin\Auth\Roles;

use App\Livewire\Admin\Roles\AddRoleSection;
use Spatie\Permission\Models\Role;
use Livewire\Livewire;
use Tests\TestCase;

class CreateRoleTest extends TestCase
{


    public $component =AddRoleSection::class;
    public function test_render()
    {
        $this->getUser('admin');
        Livewire::test($this->component)
            ->assertHasNoErrors();
    }


    public function test_valid_create()
    {

        Livewire::test($this->component)
            ->set('name', 'Test Role')
            ->call('store')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('roles', [
            'name' => 'Test Role'
        ]);
    }

    public function test_invalid_create_status_invlaid_min(): void
    {
        $component = Livewire::test($this->component)
            ->assertHasNoErrors();
        $name = "Tet";
        $dep_manager = 0;
        $component->set('name', $name);
        $component->call('store');
        $component->assertHasErrors([
            'name' => 'min',
        ]);
    }
    public function test_invalid_create_status_invlaid_unique_name(): void
    {
        $component = Livewire::test($this->component)
            ->assertHasNoErrors();
        $role = Role::create([
            'name' => 'test-role'
        ]);
        $this->assertNotNull($role);
        $this->assertDatabaseHas('roles', [
            'name'=> $role->name
        ]);
            $component->set('name', $role->name);
        $component->call('store');
        $component->assertHasErrors([
            'name' => 'unique'

        ]);
    }
}
