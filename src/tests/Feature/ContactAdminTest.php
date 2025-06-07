<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Contact;
use App\Models\User;
use App\Models\Category;

class ContactAdminTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        Category::factory()->create(['id' => '1', 'content' => 'カテゴリA']);
        Category::factory()->create(['id' => '2', 'content' => 'カテゴリB']);
    }

    public function admin_shows_five_contact_that_regstered()
    {
        $user = User::factory()->create();

        Contact::factory()->count(5)->create([
            'category_id' => 1,
        ]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(200);

        $contacts = Contact::all();
        foreach ($contacts as $contact) {
            $response->assertSee($contact->full_name);
        }
    }

    public function filter_the_contact_by_gender()
    {
        $user = User::factory()->create();

        Contact::factory()->count(2)->create([
            'gender' => 1,
            'category_id' => 1,
        ]);
        Contact::factory()->count(1)->create([
            'gender' => 2,
            'category_id' => 1,
        ]);
        Contact::factory()->count(2)->create([
            'gender' => 3,
            'category_id' => 1,
        ]);

        $response = $this->actingAs($user)->post('/admin', [
            'gender' => 2
        ]);

        $response->assertStatus(200);
        $contacts = Contact::where('gender', 2)->get();
        foreach ($contacts as $contact) {
            $response->assertSee($contact->full_name);
        };
        $response->assertDontSee(Contact::where('gender', 1)->first()->full_name);
        $response->assertDontSee(Contact::where('gender', 3)->first()->full_name);
    }
}
