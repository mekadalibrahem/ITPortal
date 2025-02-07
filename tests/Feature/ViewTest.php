<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ViewTest extends TestCase
{

    public  function getUser($role = 'normal')
    {

        $user = null;
        switch ($role) {
            case ('normal'):
                $user = User::where('email', 'rami02@gmail.com')->first();
                break;
            case ('admin'):
                $user = User::where('email', 'admin@gmail.com')->first();
                break;
            case ('employee'):
                $user = User::where('email', 'sami@gmail.com')->first();

                break;
            default:
                break;
        }
        if (!$user) {
            $this->fail('No existing user found with the specified ID.');
        }else{
            $this->actingAs($user);
        }
    }
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
        $this->getUser();


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

    public function test_show_employee_view_by_normal_user()
    {
        $this->getUser();

        $response = $this->get(route('dashboard.index'));
        $response->assertStatus(403);

        $response = $this->get(route("employee.requests"));
        $response->assertStatus(403);

        $response = $this->get(route("employee.edit.request", ['id' => 3]));
        $response->assertStatus(403);
    }

    public function test_show_employee_view_by_employee()
    {
        $this->getUser('employee');

        $response = $this->get(route('dashboard.index'));
        $response->assertStatus(302);
        $response->assertRedirect(route("employee.requests"));

        $response = $this->get(route("employee.requests"));
        $response->assertStatus(200);

        $response = $this->get(route("employee.edit.request", ['id' => 3]));
        $response->assertStatus(200);
    }

    public function test_show_employee_view_by_admin_user()
    {
       $this->getUser('admin');
        $response = $this->get(route('dashboard.index'));
        $response->assertStatus(302);
        $response->assertRedirect(route("admin.staticties"));

        $response = $this->get(route("employee.requests"));
        $response->assertStatus(403);

        $response = $this->get(route("employee.edit.request", ['id' => 3]));
        $response->assertStatus(403);
    }

    public function test_show_admin_view_by_normal_user()
    {
        $this->getUser();

        $response = $this->get(route('dashboard.index'));
        $response->assertStatus(403);

        $response = $this->get(route("admin.backups"));
        $response->assertStatus(403);

        $response = $this->get(route("admin.collage_information"));
        $response->assertStatus(403);

        // requests Views
        $response = $this->get(route("admin.requests.requset"));
        $response->assertStatus(403);
        $response = $this->get(route("admin.requests.type"));
        $response->assertStatus(403);

        // Authorization Views
        $response = $this->get(route("admin.auth.role"));
        $response->assertStatus(403);
        $response = $this->get(route("admin.auth.permission"));
        $response->assertStatus(403);
        $response = $this->get(route("admin.auth.user"));
        $response->assertStatus(403);
    }
    public function test_show_admin_view_by_employee_user()
    {
        $this->getUser('employee');

        $response = $this->get(route('dashboard.index'));
        $response->assertStatus(302);
        $response->assertRedirect(route("employee.requests"));

        $response = $this->get(route("admin.backups"));
        $response->assertStatus(403);

        $response = $this->get(route("admin.collage_information"));
        $response->assertStatus(403);

        // requests Views
        $response = $this->get(route("admin.requests.requset"));
        $response->assertStatus(403);
        $response = $this->get(route("admin.requests.type"));
        $response->assertStatus(403);

        // Authorization Views
        $response = $this->get(route("admin.auth.role"));
        $response->assertStatus(403);
        $response = $this->get(route("admin.auth.permission"));
        $response->assertStatus(403);
        $response = $this->get(route("admin.auth.user"));
        $response->assertStatus(403);
    }

    public function test_show_admin_view_by_admin_user()
    {
        $this->getUser('admin');

        $response = $this->get(route('dashboard.index'));
        $response->assertStatus(302);
        $response->assertRedirect(route("admin.staticties"));

        $response = $this->get(route("admin.backups"));
        $response->assertStatus(200);

        $response = $this->get(route("admin.collage_information"));
        $response->assertStatus(200);

        // requests Views
        $response = $this->get(route("admin.requests.requset"));
        $response->assertStatus(200);
        $response = $this->get(route("admin.requests.type"));
        $response->assertStatus(200);

        // Authorization Views
        $response = $this->get(route("admin.auth.role"));
        $response->assertStatus(200);
        $response = $this->get(route("admin.auth.permission"));
        $response->assertStatus(200);
        $response = $this->get(route("admin.auth.user"));
        $response->assertStatus(200);
    }
}
