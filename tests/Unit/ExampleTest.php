<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
//    public function testGetCategory()
//    {
//        $response = $this->get('/api/v1/category');
//
//        $response
//            ->assertStatus(200)
//            ->assertJson([
//                'status' => true,
//                'message' => "all categories found",
//                'data' => (array())
//            ]);
//    }
//
//    public function testCreateStoreSuccess()
//    {
//        $user = factory(User::class)->create();
//        Storage::fake('store');
//        $file = UploadedFile::fake()->image('store.jpg');
//        $response = $this->withHeaders([
//            'Accept' => 'application/json',
//            'Content-Type' => 'application/json',
//            'Authorization' => 'Bearer ' . $user->api_token,
//        ])->json('POST', 'api/v1/own/store', [
//            'name' => $this->faker->name,
//            'description' => $this->faker->words(3, true),
//            'email' => $this->faker->email,
//            'phone' => $this->faker->phoneNumber,
//            'address' => $this->faker->address,
//            'store_logo' => $file
//        ]);
//        $response->assertStatus(201);
//    }
//
//    public function testCreateStoreWrongFormatEmail()
//    {
//        $user = factory(User::class)->create();
//        Storage::fake('store');
//        $file = UploadedFile::fake()->image('store.jpg');
//        $response = $this->withHeaders([
//            'Accept' => 'application/json',
//            'Content-Type' => 'application/json',
//            'Authorization' => 'Bearer ' . $user->api_token,
//        ])->json('POST', 'api/v1/own/store', [
//            'name' => $this->faker->name,
//            'description' => $this->faker->words(3, true),
//            'email' => $this->faker->name,
//            'phone' => $this->faker->phoneNumber,
//            'address' => $this->faker->address,
//            'store_logo' => $file
//        ]);
//        $response->assertStatus(400);
//    }
//
//    public function testCreateStoreWithNoAuthorizedUser()
//    {
//        $user = factory(User::class)->create();
//        Storage::fake('store');
//        $file = UploadedFile::fake()->image('store.jpg');
//        $response = $this->withHeaders([
//            'Accept' => 'application/json',
//            'Content-Type' => 'application/json',
////            'Authorization' => 'Bearer ' . $user->api_token,
//        ])->json('POST', 'api/v1/own/store', [
//            'name' => $this->faker->name,
//            'description' => $this->faker->words(3, true),
//            'email' => $this->faker->email,
//            'phone' => $this->faker->phoneNumber,
//            'address' => $this->faker->address,
//            'store_logo' => $file
//        ]);
//        $response->assertStatus(401);
//    }
//
//    public function testCreateProductSuccess()
//    {
//        $store = factory(Store::class)->create();
//        $file = UploadedFile::fake()->image('product.jpg');
//        $response = $this->withHeaders([
//            'Accept' => 'application/json',
//            'Content-Type' => 'application/json',
//            'Authorization' => 'Bearer ' . $store->owner->api_token,
//        ])->json('POST', "api/v1/own/store/$store->id/product", [
//            'category_id' => factory(Category::class)->create()->id,
//            'name' => $this->faker->name,
//            'description' => $this->faker->words(10, true),
//            'price' => 100000,
//            'image' => $file,
//        ]);
//
//        $response->assertStatus(201);
//    }
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
