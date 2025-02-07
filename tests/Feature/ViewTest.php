<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ViewTest extends TestCase
{
     /**
     *  Test routes that require authentication for authenticated users
     *
     * @return void
     */
    public function test_example(): void
    {
        $response = $this->get('/');


        $response->assertStatus(200);
    }

    /**
     *   Test routes that require authentication for unauthenticated users
     *
     * @return void
     */
    public function test_user_auth()
    {
        $user = User::where('email', 'rami02@gmail.com')->first();
        if (!$user) {
            $this->fail('No existing user found with the specified ID.');
        }
        // Authenticate the user before making requests
        $this->actingAs($user);

        // Test a route that requires authentication

        $response = $this->get(route('user.notification.create'));
        $response->assertStatus(200);


        $response = $this->get(route('user.requests.create'));
        $response->assertStatus(200);
        $response = $this->get(route('user.requests.add'));
        $response->assertStatus(200);
        $response = $this->get(route('user.requests.index', ['id' => 3]));
        $response->assertStatus(200);
    }

    public function test_user_unauth()
    {

        // Test redirection for unauthenticated users
        $response = $this->get(route('user.notification.create'));
        $response->assertStatus(302); // Expecting a redirect
        $response->assertRedirect(route('login')); // Ensure it redirects to the login page

        $response = $this->get(route('user.requests.create'));
        $response->assertStatus(302); // Expecting a redirect
        $response->assertRedirect(route('login')); // Ensure it redirects to the login page

        $response = $this->get(route('user.requests.add'));
        $response->assertStatus(302); // Expecting a redirect
        $response->assertRedirect(route('login')); // Ensure it redirects to the login page

        $response = $this->get(route('user.requests.index', ['id' => 3]));
        $response->assertStatus(302); // Expecting a redirect
        $response->assertRedirect(route('login')); // Ensure it redirects to the login page
    }

    public function test_show_employee_view_by_normal_user(){
        $user = User::where('email', 'rami02@gmail.com')->first();
        if (!$user) {
            $this->fail('No existing user found with the specified ID.');
        }
        $this->actingAs($user);
        $response = $this->get(route('dashboard.index'));
        $response->assertStatus(403);

        $response = $this->get(route("employee.requests"));
        $response->assertStatus(403);

        $response = $this->get(route("employee.edit.request" , ['id' => 3]));
        $response->assertStatus(403);
    }

    public function test_show_employee_view_by_employee(){
        $user = User::where('email', 'sami@gmail.com')->first();
        if (!$user) {
            $this->fail('No existing user found with the specified ID.');
        }
        $this->actingAs($user);
        $response = $this->get(route('dashboard.index'));
        $response->assertStatus(302);
        $response->assertRedirect(route("employee.requests"));

        $response = $this->get(route("employee.requests"));
        $response->assertStatus(200);

        $response = $this->get(route("employee.edit.request" , ['id' => 3]));
        $response->assertStatus(200);
    }

    public function test_show_employee_view_by_admin_user(){
        $user = User::where('email', 'admin@gmail.com')->first();
        if (!$user) {
            $this->fail('No existing user found with the specified ID.');
        }
        $this->actingAs($user);
        $response = $this->get(route('dashboard.index'));
        $response->assertStatus(200);

        $response = $this->get(route("employee.requests"));
        $response->assertStatus(403);

        $response = $this->get(route("employee.edit.request" , ['id' => 3]));
        $response->assertStatus(403);
    }
}
