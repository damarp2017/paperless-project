<?php

namespace Tests\Feature;

use App\Category;
use App\Store;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use WithFaker;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testGetCategory()
    {
        $response = $this->get('/api/v1/category');

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => "all categories found",
                'data' => (array())
            ]);
    }

    public function testCreateStoreSuccess()
    {
        $user = factory(User::class)->create();
        Storage::fake('store');
        $file = UploadedFile::fake()->image('store.jpg')->size(100);
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $user->api_token,
        ])->json('POST', 'api/v1/own/store', [
            'name' => $this->faker->name,
            'description' => 'Deskripsi Sample',
            'email' => $this->faker->safeEmail,
            'phone' => '+628996308805',
            'address' => 'Kaligangsa',
            'store_logo' => $file
        ]);
        $response->assertStatus(201);
    }

    public function testCreateStoreWrongFormatEmail()
    {
        $user = factory(User::class)->create();
        Storage::fake('store');
        $file = UploadedFile::fake()->image('store.jpg');
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $user->api_token,
        ])->json('POST', 'api/v1/own/store', [
            'name' => $this->faker->name,
            'description' => 'Deskripsi Sample',
            'email' => 'Damar',
            'phone' => '+628996308805',
            'address' => 'Kaligangsa',
            'store_logo' => $file
        ]);
        $response->assertStatus(400);
    }

    public function testCreateStoreWithNoAuthorizedUser()
    {
        $user = factory(User::class)->create();
        Storage::fake('store');
        $file = UploadedFile::fake()->image('store.jpg');
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $user->api_token .'aa',
        ])->json('POST', 'api/v1/own/store', [
            'name' => $this->faker->name,
            'description' => $this->faker->words(3, true),
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'store_logo' => $file
        ]);
        $response->assertStatus(401);
    }

    public function testCreateProductSuccess()
    {
        $store = factory(Store::class)->create();
        $file = UploadedFile::fake()->image('product.jpg');
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $store->owner->api_token,
        ])->json('POST', "api/v1/own/store/$store->id/product", [
            'category_id' => factory(Category::class)->create()->id,
            'store_id' => $store->id,
            'name' => $this->faker->name,
            'description' => $this->faker->words(3, true),
            'price' => 100000,
            'image' => $file,
        ]);

        $response->assertStatus(201);
    }
//
//    public function testInviteOtherUser()
//    {
//        $store = factory(Store::class)->create();
//        $user = factory(User::class)->create();
//        $response = $this->withHeaders([
//            'Accept' => 'application/json',
//            'Content-Type' => 'application/json',
//            'Authorization' => 'Bearer ' . $store->owner->api_token,
//        ])->json('post', "api/v1/invitation/out", [
//            'role' => 1,
//            'requested_by_store' => $store->id,
//            'to' => $user->id,
//        ]);
//        $response->assertStatus(201);
//    }
}
