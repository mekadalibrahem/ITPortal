<?php

namespace Tests\Feature\Livewire\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Livewire\User\Request\Edit;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Livewire;

class RequestTest extends TestCase
{
    /**
     * Test if the Livewire component fetches data based on the ID.
     */
    public function test_livewire_component_fetches_data()
    {
        $this->getUser();

        $request = \App\Models\RequestList::where('id', '=', 3)->first();
        Log::info("TEST LIVWIRE REQUESTLISTTEST@test_livewire_component_fetches_data : requets ". $request->id
    );
        if($request->id  > 0 ){
             // Render the Livewire component with the ID
        Livewire::test(Edit::class, ['id' => $request->id])
        ->assertHasNoErrors();


        }else{
            $this->fail(  'request not found and id < 0');
        }

    }

    /**
     * Test if the Livewire component handles invalid IDs gracefully.
     */
    public function test_livewire_component_handles_invalid_id()
    {
        $this->getUser();
        // Render the Livewire component with an invalid ID
        Livewire::test(Edit::class, ['id' => 999])
            ->assertSet("req" , null);

    }
}
