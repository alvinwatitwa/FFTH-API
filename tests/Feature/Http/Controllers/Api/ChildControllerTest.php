<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Household;
use Tests\TestCase;
use App\User;
use App\Child;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ChildControllerTest extends TestCase
{
    /**
     * @test
     */
    public function can_get_all_children()
    {
        //Given a user is authorized
        Passport::actingAs(
            factory(User::class)->create()
        );

        //When
        $response = $this->json('GET', '/api/v1/children');

        //Then
        $response->assertStatus(200)->assertJson([
            'success' => true,
        ]);
    }

    /**
     * @test
     */
    public function can_register_a_child()
    {
        //Given a user is authorized
        Passport::actingAs(
            factory(User::class)->create()
        );

        $household =  factory(Household::class)->create();

        //When
        Storage::fake('images');

        $file = UploadedFile::fake()->image('photo.jpg');

        $response = $this->post( '/api/v1/children', [
            'first_name' => 'Dancan',
            'last_name' => 'Kimani',
            'Country' => 'Kenya',
            'gender' => 'Boy',
            'date_of_birth' => '2000-06-06',
            'photo' => $file,
            'hobbies' => 'I love solving problems',
            'history' => 'This is my short history',
            'support_amount' => 50.00,
            'frequency' => 'Monthly',
            ''
        ]);

        //Then

        Storage::disk('images')->assertExists($file->hashName());

        $this->assertDatabaseHas('children', [
            'first_name' => 'Dancan'
        ]);

        $response->assertStatus(200)->assertJson([
            'success' => true,
        ]);
    }

    /**
     * @test
     */
    public function can_show_a_child(){

        //Given a user is authorized
        Passport::actingAs(
            factory(User::class)->create()
        );

        //When
        $child = factory(Child::class)->create();

        $response = $this->json('GET', '/api/v1/children/'. $child->id);

        //Then
        $response->assertStatus(200)->assertJson([
            'success' => true,
        ]);

    }

    /**
     * @test
     */
    public function can_delete_a_child(){

        //Given a user is authorized
        Passport::actingAs(
            factory(User::class)->create()
        );

        //When
        $child = factory(Child::class)->create();

        $response = $this->json('DELETE', '/api/v1/children/'. $child->id);

        //Then
        $response->assertStatus(200)->assertJson([
            'success' => true,
        ]);

    }
}
