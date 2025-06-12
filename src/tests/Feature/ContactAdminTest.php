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
    use RefreshDatabase;

    protected $categoryA;
    protected $categoryB;

    public function setUp(): void
    {
        parent::setUp();

        $this->categoryA = Category::factory()->create(['content' => 'カテゴリA']);
        $this->categoryB = Category::factory()->create(['content' => 'カテゴリB']);
    }

    public function test_admin_shows_five_contact_that_regstered()
    {
        $user = User::factory()->create();

        Contact::factory()->count(5)->create([
            'category_id' => $this->categoryA->id,
        ]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(200);

        $contacts = Contact::all();
        foreach ($contacts as $contact) {
            $response->assertSee($contact->full_name);
        }
    }

    public function test_filter_the_contact_by_gender()
    {
        $user = User::factory()->create();

        $maleContacts = Contact::factory()->count(2)->create([
            'gender' => 1,
            'category_id' => $this->categoryA->id,
        ]);
        $femaleContacts = Contact::factory()->count(1)->create([
            'gender' => 2,
            'category_id' => $this->categoryB->id,
        ]);
        $otherContacts = Contact::factory()->count(2)->create([
            'gender' => 3,
            'category_id' => $this->categoryB->id,
        ]);

        $response = $this->actingAs($user)->post('/admin', [
            'gender' => 2
        ]);

        $response->assertStatus(200);

        foreach ($femaleContacts as $contact) {
            $response->assertSeeText($contact->full_name);
        }

        foreach ($maleContacts as $contact) {
            $response->assertDontSeeText($contact->full_name);
        }
        foreach ($otherContacts as $contact) {
            $response->assertDontSeeText($contact->full_name);
        }
    }

    public function test_filter_the_contact_by_name_keyword()
    {
        $user = User::factory()->create();

        $matching = Contact::factory()->create([
            'last_name' => '佐藤',
            'first_name' => '太郎',
            'category_id' => $this->categoryA->id,
        ]);
        $nonMatching = Contact::factory()->create([
            'last_name' => '山田',
            'first_name' => '花子',
            'category_id' => $this->categoryA->id,
        ]);

        $response = $this->actingAs($user)->post('/admin', [
            'keyword' => '佐藤太郎'
        ]);

       
        $response->assertStatus(200);

        $response->assertSeeText($matching->full_name);
        $response->assertDontSeeText($nonMatching->full_name);
    }
    public function test_filter_the_contact_by_email_keyword()
    {
        $user = User::factory()->create();

        $matching = Contact::factory()->create([
            'email' => 'sato@example.com',
            'category_id' => $this->categoryA->id,
        ]);

        $nonMatching = Contact::factory()->create([
            'email' => 'yamada@example.com',
            'category_id' => $this->categoryA->id,
        ]);

        $response = $this->actingAs($user)->post('/admin', [
            'keyword' => 'sato',
        ]);

        $response->assertStatus(200);

        $response->assertSeeText($matching->email);
        $response->assertDontSeeText($nonMatching->email);
    }


    public function test_filter_the_contact_by_category()
    {
        $user = User::factory()->create();

        $matching = Contact::factory()->count(2)->create([
            'category_id' => $this->categoryA->id,
        ]);
        $nonMatching = Contact::factory()->count(3)->create([
            'category_id' => $this->categoryB->id,
        ]);

        $response = $this->actingAs($user)->post('/admin', [
            'category_id' => $this->categoryA->id,
        ]);

        $response->assertStatus(200);

        foreach ($matching as $contact) {
            $response->assertSeeText($contact->full_name);
        }
        foreach ($nonMatching as $contact) {
            $response->assertDontSeeText($contact->full_name);
        }
    }
    public function test_filter_the_contact_by_date()
    {
        $user = User::factory()->create();

        $todayContacts = Contact::factory()->count(3)->create([
            'created_at' => now(),
            'category_id' => $this->categoryA->id,
        ]);

        $yesterdayContacts = Contact::factory()->count(2)->create([
            'created_at' => now()->subDay(),
            'category_id' => $this->categoryB->id,
        ]);

        $response = $this->actingAs($user)->post('/admin', [
            'date' => now()->toDateString(),
        ]);

        $response->assertStatus(200);

        foreach ($todayContacts as $contact) {
            $response->assertSeeText($contact->full_name);
        }
        foreach ($yesterdayContacts as $contact) {
            $response->assertDontSeeText($contact->full_name);
        }
    }
}
