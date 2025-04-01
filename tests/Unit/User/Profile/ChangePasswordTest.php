<?php

namespace Tests\Unit\User\Profile;

use App\Livewire\Profile\ChangePassword;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{
    public $component = ChangePassword::class;


    public function test_render_compoent(): void
    {
        $this->getUser('normal');
        Livewire::test($this->component)
            ->assertHasNoErrors();
    }

    public function test_edit_valid(): void
    {
        $user = $this->getUser('normal');
        $component = Livewire::test($this->component)
            ->assertHasNoErrors();
        $new_password = "new_password";
        $new_password_hash = Hash::make($new_password);
        $component->set('password', 'password'); // 'password' is default
        $component->set('new_password', $new_password);
        $component->set('confirm_password', $new_password);
        $component->call('edit');
        $component->assertHasNoErrors();
    }

    public function test_edit_invlaid_wrong_old_password(): void
    {
        $user = $this->getUser('normal');
        $component = Livewire::test($this->component)
            ->assertHasNoErrors();
        $new_password = "new_password";
        $new_password_hash = Hash::make($new_password);
        $component->set('password', 'password23123123'); // 'password' is default
        $component->set('new_password', $new_password);
        $component->set('confirm_password', $new_password);
        $component->call('edit');
        $component->assertHasErrors([
            'password'
        ]);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'password' => $new_password_hash
        ]);
    }

    public function test_edit_invlaid_min_less_then_8(): void
    {
        $user = $this->getUser('normal');
        $component = Livewire::test($this->component)
            ->assertHasNoErrors();
        $new_password = "12345";
        $new_password_hash = Hash::make($new_password);
        $component->set('password', 'password'); // 'password' is default
        $component->set('new_password', $new_password);
        $component->set('confirm_password', $new_password);
        $component->call('edit');
        $component->assertHasErrors([
            'new_password' => 'min'
        ]);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'password' => $new_password_hash
        ]);
    }

    public function test_edit_invlaid_same_new_and_confirm_password(): void
    {
        $user = $this->getUser('normal');
        $component = Livewire::test($this->component)
            ->assertHasNoErrors();
        $new_password = "new_password";
        $new_password_hash = Hash::make($new_password);
        $component->set('password', 'password23123123'); // 'password' is default
        $component->set('new_password', $new_password);
        $component->set('confirm_password', $new_password . "222");
        $component->call('edit');
        $component->assertHasErrors([
            'new_password' => 'same',
            'new_password' => 'same'
        ]);
    }
}
