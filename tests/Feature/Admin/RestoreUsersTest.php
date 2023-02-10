<?php

namespace Tests\Feature\Admin;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RestoreUsersTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function it_restore_the_user()
    {
        $user = factory(User::class)->create([
            'email' => 'frangomez@gmail.com',
            'deleted_at' => now(),
        ]);

        $user->profile()->update([
            'deleted_at' => now(),
        ]);

        $user->restore($user->id);
        $user->profile()->restore($user->id);

        $this->assertDatabaseHas('users', [
            'email' => 'frangomez@gmail.com',
            'deleted_at' => null,

        ])->assertDatabaseHas('user_profiles', [
            'deleted_at' => null,
        ]);
    }
}