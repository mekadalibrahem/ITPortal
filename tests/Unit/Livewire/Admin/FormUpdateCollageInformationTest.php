<?php

namespace Tests\Unit\Livewire\Admin;

use App\Livewire\FormUpdateCollageInformation;
use App\Models\CollageInformations;
use Tests\TestCase;
use Livewire\Livewire;

class FormUpdateCollageInformationTest extends TestCase
{
    public $table_name = "collage_informations";
    /**
     * test if component show correct.
     */
    public function test_component_renderd(): void
    {
        $this->getUser('admin');
        $info  = CollageInformations::create(['name' => 'test' , 'value' => 'test']);
        // Ensure the record exists
        $this->assertNotNull($info);
        Livewire::test(FormUpdateCollageInformation::class, ['id' => $info->id])
        ->assertSet('new_name', $info->name)
        ->assertSet('new_value' , $info->value)
        ->assertHasNoErrors();
    }

    public function test_value_update(): void
    {
        $this->getUser('admin');
        $info  = CollageInformations::create(['name' => 'test' , 'value' => 'test']);
        // Ensure the record exists
        $this->assertNotNull($info);
        // new value
        $new_value = "new_test_value";
        Livewire::test(FormUpdateCollageInformation::class, ['id' => $info->id])
        ->set('new_name', $info->name)
        ->set('new_value' , $new_value)
        ->call('edit')
        ->assertHasNoErrors();
        $this->assertDatabaseHas($this->table_name , [
            'name' => $info->name ,
            'value' => $new_value
        ]);
    }

    public function test_value_update_by_empty_value(): void
    {
        $this->getUser('admin');
        $info  = CollageInformations::create(['name' => 'test' , 'value' => 'test']);
        // Ensure the record exists
        $this->assertNotNull($info);
        Livewire::test(FormUpdateCollageInformation::class, ['id' => $info->id])
        ->set('new_name', $info->name)
        ->set('new_value' , null)
        ->call('edit')
        ->assertHasErrors(['new_value' => 'required']);
        $this->assertDatabaseMissing($this->table_name , [
            'name' => $info->name ,
            'value' => ''
        ]);
    }

    public function test_name_update_by_empty_value(): void
    {
        $this->getUser('admin');
        $info  = CollageInformations::create(['name' => 'test' , 'value' => 'test']);
        // Ensure the record exists
        $this->assertNotNull($info);
        Livewire::test(FormUpdateCollageInformation::class, ['id' => $info->id])
        ->set('new_name', null)
        ->set('new_value' , $info->value)
        ->call('edit')
        ->assertHasErrors(['new_name' => 'required']);
        $this->assertDatabaseMissing($this->table_name , [
            'name' => '' ,
            'value' => $info->value
        ]);


    }

    public function test_name_update_by_used_value(): void
    {
        $this->getUser('admin');
        $info  = CollageInformations::create(['name' => 'test' , 'value' => 'test']);
        $info2  = CollageInformations::create(['name' => 'test2' , 'value' => 'test2']);
        // Ensure the record exists
        $this->assertNotNull($info);
        Livewire::test(FormUpdateCollageInformation::class, ['id' => $info->id])
        ->set('new_name', $info2->name)
        ->set('new_value' , $info->value)
        ->call('edit')
        ->assertHasErrors(['new_name' => 'unique']);
        $this->assertDatabaseMissing($this->table_name , [
            'name' => $info2->name,
            'value' => $info->value
        ]);
    }

    public function test_name_update_by_valid_value(): void
    {
        $this->getUser('admin');
        $info  = CollageInformations::create(['name' => 'test' , 'value' => 'test']);
        $new_name = "new_test_name";
        $info2 = CollageInformations::query()->where('name' , '=' , $new_name)->first();
        // Ensure the record exists
        $this->assertNotNull($info);
        $this->assertNull($info2);

        Livewire::test(FormUpdateCollageInformation::class, ['id' => $info->id])
        ->set('new_name', $new_name)
        ->set('new_value' , $info->value)
        ->call('edit')
        ->assertHasNoErrors();
        $this->assertDatabaseHas($this->table_name , [
            'name' => $new_name,
            'value' => $info->value
        ]);
    }
}

