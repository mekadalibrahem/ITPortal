<?php

namespace Tests\Feature;

use App\Models\CollageInformations;
use App\Models\Requests;
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
    public function test_unauth_user()
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
    /**
     * Test routes and view what open for normal user and what can't open it
     *
     * @return void
     */
    public function test_show_normal_user()
    {
        $this->getUser();
        // authed normal user views (can show it)
        $response = $this->get(route('user.notification.create'));
        $response->assertStatus(200);
        $response = $this->get(route('user.requests.create'));
        $response->assertStatus(200);
        $response = $this->get(route('user.requests.add'));
        $response->assertStatus(200);
        $response = $this->get(route('user.requests.index', ['id' => 3]));
        $response->assertStatus(200);

        // employee views can't show it
        $response = $this->get(route('dashboard.index'));
        $response->assertStatus(403);

        $response = $this->get(route("employee.requests"));
        $response->assertStatus(403);

        $response = $this->get(route("employee.edit.request", ['id' => 3]));
        $response->assertStatus(403);

        // admin views can't show it

        $response = $this->get(route('dashboard.index'));
        $response->assertStatus(403);

        $response = $this->get(route("admin.backups"));
        $response->assertStatus(403);

        // admin collage views
        $response = $this->get(route("admin.collage.index"));
        $response->assertStatus(403);
        $response = $this->get(route("admin.collage.create"));
        $response->assertStatus(403);
        $info = CollageInformations::query()->first();
        $response = $this->get(route("admin.collage.edit",['id' => $info->id ]));
        $response->assertStatus(403);

        //admin requests Views
        $response = $this->get(route("admin.requests.request.index"));
        $response->assertStatus(403);
        $response = $this->get(route("admin.requests.request.create"));
        $response->assertStatus(403);
        $request= Requests::query()->first();
        $response = $this->get(route("admin.requests.request.edit" , ['id' => $request->id]));
        $response->assertStatus(403);

        $response = $this->get(route("admin.requests.type"));
        $response->assertStatus(403);

        //admin employee Views
        $response = $this->get(route("admin.employee.department"));
        $response->assertStatus(403);
        $response = $this->get(route("admin.employee.employee"));
        $response->assertStatus(403);

        //admin Authorization Views
        $response = $this->get(route("admin.auth.role"));
        $response->assertStatus(403);
        $response = $this->get(route("admin.auth.permission"));
        $response->assertStatus(403);
        $response = $this->get(route("admin.auth.user"));
        $response->assertStatus(403);
    }

    /**
     * Test routes and view what open for employee user and what can't open it
     *
     * @return void
     */
    public function test_show_employee()
    {
        $this->getUser('employee');
        // normal user views can show it
        $response = $this->get(route('user.notification.create'));
        $response->assertStatus(200);
        $response = $this->get(route('user.requests.create'));
        $response->assertStatus(200);
        $response = $this->get(route('user.requests.add'));
        $response->assertStatus(200);
        // $response = $this->get(route('user.requests.index', ['id' => 3]));
        // $response->assertStatus(404); // return 404 because request id is wrong

        // employee views  can show it

        $response = $this->get(route('dashboard.index'));
        $response->assertStatus(302);
        $response->assertRedirect(route("employee.requests"));

        $response = $this->get(route("employee.requests"));
        $response->assertStatus(200);

        $response = $this->get(route("employee.edit.request", ['id' => 3]));
        $response->assertStatus(200);

        // admin views can't show it

        $response = $this->get(route("admin.backups"));
        $response->assertStatus(403);

       // admin collage views
        $response = $this->get(route("admin.collage.index"));
        $response->assertStatus(403);
        $response = $this->get(route("admin.collage.create"));
        $response->assertStatus(403);
        $info = CollageInformations::query()->first();
        $response = $this->get(route("admin.collage.edit",['id' => $info->id ]));
        $response->assertStatus(403);

        //admin requests Views
        $response = $this->get(route("admin.requests.request.index"));
        $response->assertStatus(403);
        $response = $this->get(route("admin.requests.request.create"));
        $response->assertStatus(403);
        $request= Requests::query()->first();
        $response = $this->get(route("admin.requests.request.edit" , ['id' => $request->id]));
        $response->assertStatus(403);
        $response = $this->get(route("admin.requests.type"));
        $response->assertStatus(403);

        //admin employee Views
        $response = $this->get(route("admin.employee.department"));
        $response->assertStatus(403);
        $response = $this->get(route("admin.employee.employee"));
        $response->assertStatus(403);

        //admin Authorization Views
        $response = $this->get(route("admin.auth.role"));
        $response->assertStatus(403);
        $response = $this->get(route("admin.auth.permission"));
        $response->assertStatus(403);
        $response = $this->get(route("admin.auth.user"));
        $response->assertStatus(403);
    }

    /**
     * Test routes and view what open for admin user and what can't open it
     *
     * @return void
     */
    public function test_show_admin()
    {
        $this->getUser('admin');
        // normal user views can show it
        $response = $this->get(route('user.notification.create'));
        $response->assertStatus(200);
        $response = $this->get(route('user.requests.create'));
        $response->assertStatus(200);
        $response = $this->get(route('user.requests.add'));
        $response->assertStatus(200);
        // $response = $this->get(route('user.requests.index', ['id' => 3]));
        // $response->assertStatus(404); // return 404 because request id is wrong

        // employee views can't show it

        $response = $this->get(route("employee.requests"));
        $response->assertStatus(403);

        $response = $this->get(route("employee.edit.request", ['id' => 3]));
        $response->assertStatus(403);

        // admin views can show it
        $response = $this->get(route('dashboard.index'));
        $response->assertStatus(302);
        $response->assertRedirect(route("admin.staticties"));

        $response = $this->get(route("admin.backups"));
        $response->assertStatus(200);

        // admin collage views
        $response = $this->get(route("admin.collage.index"));
        $response->assertStatus(200);
        $response = $this->get(route("admin.collage.create"));
        $response->assertStatus(200);
        $info = CollageInformations::query()->first();
        $response = $this->get(route("admin.collage.edit",['id' => $info->id ]));
        $response->assertStatus(200);

        // requests Views
        $response = $this->get(route("admin.requests.request.index"));
        $response->assertStatus(200);
        $response = $this->get(route("admin.requests.request.create"));
        $response->assertStatus(200);
        $request= Requests::query()->first();
        $response = $this->get(route("admin.requests.request.edit" , ['id' => $request->id]));
        $response->assertStatus(200);
        $response = $this->get(route("admin.requests.type"));
        $response->assertStatus(200);

        // employee Views
        $response = $this->get(route("admin.employee.department"));
        $response->assertStatus(200);
        $response = $this->get(route("admin.employee.employee"));
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
