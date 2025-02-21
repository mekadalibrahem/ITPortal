<?php

namespace Tests\Unit\Livewire\Admin;

use App\Models\Requests;
use Livewire\Livewire;
use App\Livewire\Request\Edit;
use App\Models\Department;
use App\Models\RequestType;
use Tests\TestCase;

class EditRequestTest extends TestCase
{
    public $table_name = 'requests';
    /**
     * show if component render correct.
     */
    public function test_component_render(): void
    {
        $this->getUser('admin');
        Livewire::test(Edit::class)
            ->assertHasNoErrors();
    }

    public function test_valid_update(): void
    {
        $this->getUser('admin');
        $dep = Department::find(1);
        $type = RequestType::find(1);
        $this->assertNotNull($dep);
        $this->assertNotNull($type);

        $item  = Requests::create([
            'name' => 'test_123456789',
            'isActive' => 1,
            'to_department' => $dep->id,
            'type_id' => $type->id
        ]);
        // Ensure the record exists
        $this->assertNotNull($item);

        // new value
        $new_value = "new_test_value";
        // Initialize the Livewire component with the request ID
        $component = Livewire::test(Edit::class, ['id' => $item->id])
            ->assertHasNoErrors();

        // Set new values for the properties
        $component->set('name', $new_value); // Change the name
        $component->set('type', $type->id); // Keep the same type
        $component->set('department', $dep->id); // Keep the same department
        $component->set('active', false); // Change isActive to false

        // Call the edit method
        $component->call('edit');

        // Assert that the database has been updated
        $this->assertDatabaseHas($this->table_name, [
            'id' => $item->id,
            'name' => $new_value,
            'isActive' => 0,
            'to_department' => $dep->id,
            'type_id' => $type->id
        ]);
    }


    public function test_invalid_update(): void
    {
        $this->getUser('admin');
        $dep = Department::find(1);
        $type = RequestType::find(1);
        $this->assertNotNull($dep);
        $this->assertNotNull($type);

        $item  = Requests::create([
            'name' => 'test_123456789',
            'isActive' => 1,
            'to_department' => $dep->id,
            'type_id' => $type->id
        ]);
        // Ensure the record exists
        $this->assertNotNull($item);

        // new value
        $new_value = "new_";
        // Initialize the Livewire component with the request ID
        $component = Livewire::test(Edit::class, ['id' => $item->id])
            ->assertHasNoErrors();

        // Set new values for the properties
        $component->set('name','new_');
        $component->set('type', $type->id);
        $component->set('department', $dep->id);
        $component->set('active', '11111');

        // Call the edit method
        $component->call('edit');
        $component->assertHasErrors([
            'name' => 'min',
            'active' => 'boolean'
        ]);
        // Assert that the database has been updated
        $this->assertDatabaseHas($this->table_name, [
            'id' => $item->id,
            'name' => $item->name,
            'isActive' => $item->isActive,
            'to_department' => $dep->id,
            'type_id' => $type->id
        ]);
    }
}
