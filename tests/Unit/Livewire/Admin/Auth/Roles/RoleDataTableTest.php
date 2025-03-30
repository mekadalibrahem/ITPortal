<?php

namespace Tests\Unit\Livewire\Admin\Auth\Roles;

use App\Livewire\DataTables\RolesDataTable;
use Livewire\Livewire;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
class RoleDataTableTest extends TestCase
{

    public $component = RolesDataTable::class;
    public $table = 'roles';


    public function test_render(): void
    {
        // Get an authenticated user with the admin role
        $this->getUser('admin');

        // Assert the component renders without errors
        Livewire::test($this->component)
            ->assertHasNoErrors();
    }
    public function test_redirect_to_edit(): void
    {
        $this->getUser('admin');
        $role = Role::create([
            "name" => 'test-role' ,
            "guard_name" => 'web'
        ]);
        $this->assertNotNull($role);

        $component = Livewire::test($this->component)
            ->assertHasNoErrors();

        $component->call('edit', $role->id);
        $component->assertRedirectToRoute('admin.auth.role.edit', ['id' => $role->id]);
    }

    public function test_delete_role(): void
    {
        $this->getUser('admin');
        $role = Role::create([
            "name" => 'test-role' ,
            "guard_name" => 'web'
        ]);
        $this->assertNotNull($role);
        $this->assertDatabaseHas($this->table, [
            "name" => 'test-role' ,
            "guard_name" => 'web'
        ]);

        $component = Livewire::test($this->component)
            ->assertHasNoErrors();

        $component->call('delete', $role->id);
        $this->assertDatabaseMissing($this->table, [
            "name" => 'test-role' ,
            "guard_name" => 'web'
        ]);
    }

}
