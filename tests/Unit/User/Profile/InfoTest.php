<?php

namespace Tests\Unit\User\Profile;

use Tests\TestCase;
use App\Livewire\Profile\Info;
use App\Models\User;
use Livewire\Livewire;

class InfoTest extends TestCase
{

    public $component = Info::class;

    public function test_render_compoent(): void
    {
        $this->getUser('normal');
        Livewire::test($this->component)
            ->assertHasNoErrors();
    }

    public function test_edit_valid(): void
    {
        $this->getUser('normal');
        $component = Livewire::test($this->component)
            ->assertHasNoErrors();
        $fname =  "test fname";
        $mname = "test mname";
        $lname = "test lname";
        $nid = "999998588556856";
        $username = "test user name";
        $email = "Test.user@gmail.com";
        $component->set('fname', $fname);
        $component->set('mname', $mname);
        $component->set('lname', $lname);
        $component->set('nid', $nid);
        $component->set('username', $username);
        $component->set('email', $email);
        $component->call('edit');
        $component->assertHasNoErrors();

        $this->assertDataBaseHas('users', [
            'fname' => $fname,
            'mname' => $mname,
            'lname' =>  $lname,
            'national_id' => $nid,
            "username" =>  $username,

            'email' => $email
        ]);
    }

    public function test_edit_invalid_email(): void
    {
        $this->getUser('normal');
        $component = Livewire::test($this->component)
            ->assertHasNoErrors();
        $email = "this invalid email";
        $component->set('email', $email);
        $component->call('edit');
        $component->assertHasErrors([
            'email' => 'email'
        ]);

        $this->assertDatabaseMissing('users', [
            'email' => $email
        ]);
    }

    public function test_edit_invalid_email_unique(): void
    {
        $this->getUser('normal');
        $component = Livewire::test($this->component)
            ->assertHasNoErrors();

        $anotherUser = User::factory()->create();
        $this->assertNotNull($anotherUser);
        $component->set('email', $anotherUser->email);
        $component->call('edit');
        $component->assertHasErrors([
            'email' => 'unique'
        ]);
    }

    public function test_edit_invalid_username_unique():void {
        $this->getUser('normal');
        $component = Livewire::test($this->component)
            ->assertHasNoErrors();

        $anotherUser = User::factory()->create();
        $this->assertNotNull($anotherUser);
        $component->set('username', $anotherUser->username);
        $component->call('edit');
        $component->assertHasErrors([
            'username' => 'unique'
        ]);
    }

    public function test_edit_invalid_national_id_unique():void {
        $this->getUser('normal');
        $component = Livewire::test($this->component)
            ->assertHasNoErrors();

        $anotherUser = User::factory()->create();
        $this->assertNotNull($anotherUser);
        $component->set('nid', $anotherUser->national_id);
        $component->call('edit');
        $component->assertHasErrors([
            'nid' => 'unique'
        ]);
    }
}
