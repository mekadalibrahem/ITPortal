<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase ;
    /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected $seed = true;


    public function getUser($role = 'normal')
    {

        $user = null;
        switch ($role) {
            case ('normal'):
                $user = User::where('email', 'user01@gmail.com')->first();
                break;
            case ('admin'):
                $user = User::where('email', 'admin@gmail.com')->first();
                break;
            case ('employee'):
                $user = User::where('email', 'dean@gmail.com')->first();

                break;
            default:
                break;
        }
        if (!$user) {
            $this->fail('No existing user found with the specified ID.');
            return null;
        } else {
            $this->actingAs($user);
            return $user ;
        }
    }
     protected function setUp(): void
    {
        parent::setUp();

        
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            DB::reconnect();
        }
    }

    protected function tearDown(): void
    {
        
        DB::disconnect();
        parent::tearDown();
    }
}
