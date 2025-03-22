<?php

namespace Tests\Unit\Livewire\Admin\RequestType;

use App\Livewire\DataTables\EmployeesTable;
use App\Models\Employee;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class EmployeeTableTest extends TestCase
{
    public $component = EmployeesTable::class;
    public $table_name= 'employees' ;

    public function test_component_render(): void
    {
        $this->getUser('admin');

        Livewire::test($this->component)
            ->assertHasNoErrors();
    }


    public function test_redirect_to_edit() : void {
        $this->getUser('admin');
        $emp = Employee::query()->first();
        $this->assertNotNull($emp);

        $component = Livewire::test($this->component )
            ->assertHasNoErrors();

        $component->call('edit' , $emp->id);
        $component->assertRedirectToRoute('admin.employee.edit' ,['id' => $emp->id]);
    }

    public function test_delete() : void {
        $this->getUser('admin');
        $user = User::create([
            'fname' => "test " ,
            'mname' => "test " ,
            'lname' =>  "test " ,
            'username' => "test fname",
            'email' => "test@gmail.com",
            'password' =>"klsdoasdiokljklasdjioolasldiojolkasiojwioomasioj89123jkn982189o",
            'national_id' =>  "040256985565885568515615",
        ]);
        $this->assertNotNull($user);
        $emp = Employee::create([
            'user_id' => $user->id
        ]);
        $this->assertNotNull($emp);
        $this->assertDatabaseHas($this->table_name, [
            'user_id' => $user->id
        ]);

        $component = Livewire::test($this->component )
            ->assertHasNoErrors();

        $component->call('delete' , $emp->id);
        $this->assertDatabaseMissing($this->table_name, [
            'user_id' => $user->id
        ]);
    }
}
