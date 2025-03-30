<?php


namespace Tests\Unit\Livewire\Admin\Auth\Roles;

use App\Livewire\Admin\Roles\RoleCard;
use App\Models\Department;
use App\Models\Employee;
use App\Models\RequestType;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class EditRoleTest extends TestCase
{

    public $component = RoleCard::class;
    public $table_name = 'roles';

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


        $dep = Role::create([
            'name' => "Test role",
        ]);

        $this->assertNotNull($dep);
        $component = Livewire::test($this->component, ['id' => $dep->id])
            ->assertHasNoErrors();
        $name = "Test-edit-role";

        $component->set('name', $name);
        $component->call('update');
        $this->assertDatabaseHas($this->table_name, [
            "name" => $name,
        ]);
    }
    public function test_invalid_edit_name_min(): void
    {
        $this->getUser('admin');


        $role = Role::create([
            'name' => "test role",
        ]);

        $this->assertNotNull($role);
        $component = Livewire::test($this->component, ['id' => $role->id])
            ->assertHasNoErrors();
        $name = "Tes";

        $component->set('name', $name);
        $component->call('update');
        $this->assertDatabaseMissing($this->table_name, [
            "name" => $name,
        ]);
    }
    public function test_invalid_edit_name_unique(): void
    {
        $this->getUser('admin');


        $role = Role::create([
            'name' => "test role",
        ]);

        $this->assertNotNull($role);
        $component = Livewire::test($this->component, ['id' => $role->id])
            ->assertHasNoErrors();
        $name = $role->name;

        $component->set('name', $name);
        $component->call('update');
        $component->assertHasErrors([
            'name' => 'unique'
        ]);
    }

    public function test_add_permission(): void
    {
        $this->getUser('admin');


        $role = Role::create([
            'name' => "test role",
        ]);
        $this->assertNotNull($role);

        $permission = Permission::create([
            'name' => 'test permission'
        ]);
        $this->assertNotNull($permission);
        $component = Livewire::test($this->component, ['id' => $role->id])
        ->assertHasNoErrors();

        $component->set('add_permission' , $permission->id);
        $component->call('new_permission');
        $component->assertHasNoErrors();
        $this->assertDatabaseHas('role_has_permissions',[
            'role_id' => $role->id ,
            'permission_id' => $permission->id
        ]);

    }

    public function test_remove_permission() : void {
        $this->getUser('admin');


        $role = Role::create([
            'name' => "test role",
        ]);
        $this->assertNotNull($role);

        $permission = Permission::create([
            'name' => 'test permission'
        ]);
        $this->assertNotNull($permission);
        $role->givePermissionTo($permission);
        $this->assertDatabaseHas('role_has_permissions',[
            'role_id' => $role->id ,
            'permission_id' => $permission->id
        ]);
        $component = Livewire::test($this->component, ['id' => $role->id])
        ->assertHasNoErrors();

        $component->call('remove_permission' , $permission->name);
        $component->assertHasNoErrors();
        $this->assertDatabaseMissing('role_has_permissions',[
            'role_id' => $role->id ,
            'permission_id' => $permission->id
        ]);
    }
}
