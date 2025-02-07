<?php

namespace Tests\Unit\Livewire\Admin;

use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class FormCreateCollageInformationTest extends TestCase
{
    /**
    * show if component render correct.
    */
    public function test_component_render(): void
    {
        $user = User::where('email', 'admin@gmail.com')->first();
        if (!$user) {
            $this->fail("can't find user with email  admin@gmail.com");
        }
        $this->actingAs($user);
        Livewire::test(\App\Livewire\FormCreateCollageInformation::class)
            ->assertHasNoErrors();
    }

    /**
     * test if admin can send and save new value in database
     *
     * @return void
     */
    public function test_save_new_value(){
        $user = User::where('email', 'admin@gmail.com')->first();
        if (!$user) {
            $this->fail("can't find user with email  admin@gmail.com");
        }
        $this->actingAs($user);
        Livewire::test(\App\Livewire\FormCreateCollageInformation::class)
            ->set('name', 'Test Collage Name') // Set the 'name' field
            ->set('value', 'Test Collage Value') // Set the 'value' field
            ->call('create'); // Call the 'create' method

        // Step 4: Assert that the data was saved in the database
        $this->assertDatabaseHas('collage_informations', [
            'name' => 'Test Collage Name',
            'value' => 'Test Collage Value',
        ]);

        // Step 5: Optionally, assert that the form fields were reset
        $component = Livewire::test(\App\Livewire\FormCreateCollageInformation::class);
        $component->assertSet('name', ''); // Check if 'name' was reset
        $component->assertSet('value', ''); // Check if 'value' was reset
    }
}
