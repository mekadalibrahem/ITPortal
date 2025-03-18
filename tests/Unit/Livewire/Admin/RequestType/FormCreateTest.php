<?php

namespace Tests\Unit\Livewire\Admin\RequestType;

use App\Livewire\FormCreateRequestType;
use App\Models\RequestType;
use Livewire\Livewire;
use Tests\TestCase;

class FormCreateTest extends TestCase
{

    public $component = FormCreateRequestType::class;
    public $table_name= 'request_types' ;

    /**
     * A basic unit test example.
     */
    public function test_component_render(): void
    {
        $this->getUser('admin');
        Livewire::test($this->component)
            ->assertHasNoErrors();
    }

    public function test_valid_create(): void
    {
        $this->getUser('admin');
        $component = Livewire::test($this->component)
            ->assertHasNoErrors();
        $component->set('type', 'test_new_type');
        $component->call('create');
        $this->assertDatabaseHas($this->table_name, [
            'type' => 'test_new_type'
        ]);
    }

    public function test_invalid_create(): void
    {
        $this->getUser('admin');
        $component = Livewire::test($this->component)
            ->assertHasNoErrors();

        $type = RequestType::query()->first();
        $component->set('type', $type->type);
        $component->call('create');
        $component->assertHasErrors([
            'type' => 'unique'
        ]);

    }
}
