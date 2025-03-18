<?php

namespace Tests\Unit\Livewire\Admin\RequestType;

use App\Livewire\FormUpdateRequestType;
use App\Models\RequestType;
use Livewire\Livewire;
use Tests\TestCase;

class FormUpdateTest extends TestCase
{
    public $component = FormUpdateRequestType::class;
    public $table_name= 'request_types' ;

    /**
     * A basic unit test example.
     */
    public function test_component_render(): void
    {
        $this->getUser('admin');
        $reqestType = RequestType::create(['type' => 'test_type']);
        $this->assertNotNull($reqestType);
        Livewire::test($this->component , ['id' => $reqestType->id])
            ->assertHasNoErrors();
    }

    public function test_valid_edit(): void
    {
        $this->getUser('admin');
        $reqestType = RequestType::create(['type' => 'test_type']);
        $this->assertNotNull($reqestType);
        $component = Livewire::test($this->component , ['id' => $reqestType->id])
            ->assertHasNoErrors();
        $component->set('type', 'test_new_type');
        $component->call('edit');
        $this->assertDatabaseHas($this->table_name, [
            'type' => 'test_new_type'
        ]);
    }

    public function test_invalid_edit(): void
    {
        $this->getUser('admin');
        $reqestType = RequestType::create(['type' => 'test_type']);
        $this->assertNotNull($reqestType);
        $component = Livewire::test($this->component , ['id' => $reqestType->id])
            ->assertHasNoErrors();

        $type = RequestType::query()->first();
        $component->set('type', $type->type);
        $component->call('edit');
        $component->assertHasErrors([
            'type' => 'unique'
        ]);

    }

}
