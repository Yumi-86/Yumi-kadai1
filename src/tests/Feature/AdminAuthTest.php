<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;



class AdminAuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function test_admin_login()
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($user);
    }

    public function test_access_to_admin_after_login()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/admin');
        $response->assertStatus(200);
    }

    public function test_admin_logout()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_register_profile()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post('/profile', [
            'gender' => '1',
            'birthday' => '1999-01-01',
            'tel' => '08012345678',
            'address' => '神奈川県',
            'image' => UploadedFile::fake()->create('avatar.jpg', 100, 'image/jpeg'),
        ]);

        $response->assertRedirect('/admin');

        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
            'gender' => '1',
            'tel' => '08012345678',
            'address' => '神奈川県',
        ]);

        Storage::disk('public')->assertExists($user->profile->image_path);
    }
}
