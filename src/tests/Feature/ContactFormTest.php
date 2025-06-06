<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\Channel;
use App\Models\Contact;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


class ContactFormTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function 問い合わせフォーム画面が表示される()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('お名前');
        $response->assertSee('性別');
        $response->assertSee('メールアドレス');
        $response->assertSee('電話番号');
        $response->assertSee('住所');
        $response->assertSee('建物名');
        $response->assertSee('お問い合わせの種類');
        $response->assertSee('お問い合わせ内容');
        $response->assertSee('どこで知りましたか？');
        $response->assertSee('商品画像の添付');

        $response->assertViewHas('categories', Category::all());
    }
    public function 問い合わせを送信すると確認画面が表示される()
    {
        Storage::fake('public');

        $image = UploadedFile::fake()->image('sample.jpg');

        $category = Category::factory()->create();
        $channel = Channel::factory()->create();

        $formData = [
            'last_name' => '深浦',
            'first_name' => '優美',
            'gender' => '2',
            'email' => 'yuumi@example.com',
            'tel1' => '080',
            'tel2' => '1234',
            'tel3' => '5678',
            'address' => '東京都千代田区1-1',
            'building' => 'カナンビル1F',
            'category_id' => $category->id,
            'detail' => 'test',
            'channel_id' => [$channel->id],
            'image' => $image,
        ];

        $response = $this->post('/confirm', $formData);

        $response->assertStatus(200);

        $response->assertSee('深浦　優美');
        $response->assertSee('女性');
        $response->assertSee('yuumi@example.com');
        $response->assertSee('08012345678');
        $response->assertSee('東京都千代田区1-1');
        $response->assertSee('カナンビル1F');
        $response->assertSee( $category->content);
        $response->assertSee('test');
        $response->assertSee($channel->content);

        Storage::disk('public')->assertExists('temp/' . $image->hashName());
    }

    public function 入力データを送信しバリデーションエラーが表示される()
    {
        $response = $this->from('/')->post('/confirm', [
            'last_name' => '',
            'first_name' => '',
            'gender' => '',
            'email' => 'invalid-email',
            'tel1' => '180',
            'tel2' => '',
            'tel3' => '',
            'address' => '',
            'building' => str_repeat('あ', 1000),
            'category_id' => '',
            'detail' => '',
            'channel_id' => '',
            'image' => UploadedFile::fake()->create('document.pdf', 100, 'application/pdf'),
        ]);

        $response->assertRedirect('/');

        $response->assertSessionHasErrors([
            'last_name',
            'first_name',
            'gender',
            'email',
            'tel',
            'address',
            'building',
            'category_id',
            'detail',
            'channel_id',
        ]);
    }
    public function 問い合わせフォームを送信するとデータが保存されてthanksページにリダイレクトされる()
    {
        $category = Category::factory()->create();
        $channel = Channel::factory()->create();

        Storage::fake('public');
        $image = UploadedFile::fake()->image('test.jpg');

        $formData = [
            'last_name' => '深浦',
            'first_name' => '優美',
            'gender' => '2',
            'email' => 'yuumi@example.com',
            'full_tel' => '08012345678',
            'address' => '東京都千代田区1-1',
            'building' => 'カナンビル1F',
            'category_id' => $category->id,
            'detail' => 'test',
            'channel_id' => [$channel->id],
            'image_path' => $image->store('temp', 'public'),
        ];

        Storage::disk('public')->assertExists($formData['image_path']);

        $response = $this->post('/thanks', $formData);

        $response->assertStatus(200);
        $response->assertViewIs('contacts.thanks');

        $this->assertDatabaseHas('contacts', [
            'first_name' => '優美',
            'last_name' => '深浦',
            'gender' => '2',
            'email' => 'yuumi@example.com',
            'tel' => '08012345678',
            'address' => '東京都千代田区1-1',
            'building' => 'カナンビル1F',
            'category_id' => $category->id,
            'detail' => 'test',
            'image_path' => 'contacts/' . basename($formData['image_path']),
        ]);

        $contact = Contact::where('email', 'yuumi@example.com')->first();
        $this->assertDatabaseHas('channel_contact', [
            'contact_id' => $contact->id,
            'channel_id' => $channel->id,
        ]);

        Storage::disk('public')->assertExists('contacts/' . basename($formData['image_path']));
    }
}

