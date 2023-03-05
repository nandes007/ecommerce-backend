<?php

namespace Tests\Feature\Controllers;

use App\Models\Province;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class ProvinceControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testGetProvinceNotEmptyEndpoint()
    {
        Province::factory()->create([
            'name' => 'ACEH'
        ]);

        $response = $this->getJson('/api/admin/provinces');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
                "code" => 200,
                "message" => "success",
                "data" => [
                    "data" => [
                    [
                        "id" => 1,
                        "name" => "ACEH"
                    ]
                ]
            ]
        ]);
        $response->assertJsonStructure([
            "code",
            "message",
            "data" => [
                "data",
                "first_page_url",
                "from",
                "last_page",
                "last_page_url",
                "links",
                "next_page_url",
                "path",
                "per_page",
                "prev_page_url",
                "to",
                "total"
            ],
        ]);
    }

    public function testGetProvinceEmptyEndpoint()
    {
        $response = $this->getJson('/api/admin/provinces');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            "code" => 200,
            "message" => "success",
            "data" => [
                "data" => []
            ]
        ]);
        $response->assertJsonStructure([
            "code",
            "message",
            "data" => [
                "data",
                "first_page_url",
                "from",
                "last_page",
                "last_page_url",
                "links",
                "next_page_url",
                "path",
                "per_page",
                "prev_page_url",
                "to",
                "total"
            ],
        ]);
    }

    public function testStoreProvinceSuccess()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post('/api/admin/provinces', ['name' => 'SUMATERA UTARA']);
        $response->assertStatus(201);
        $response->assertJson([
           "code" => 201,
           'message' => "success",
            "data" => [
               "name" => "SUMATERA UTARA"
            ]
        ]);
    }

    public function testStoreProvinceEmptyProperty()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post('/api/admin/provinces', ['name' => '']);
        $response->assertStatus(422);
        $response->assertJson([
            "message" => "The name field is required.",
            "errors" => [
                "name" => [
                    "The name field is required."
                ]
            ]
        ]);
    }

    public function testStoreInvalidLength()
    {
        $name = "Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quis expedita beatae ratione deleniti. Eius alias placeat vero, suscipit necessitatibus distinctio magnam, quas provident inventore, quia libero! Voluptatibus, molestiae eveniet. Placeat debitis, provident ullam autem quisquam libero soluta obcaecati optio aliquid cum molestiae sequi perspiciatis doloribus corrupti error odit quis tenetur. Accusamus labore dicta aliquid suscipit ullam tenetur voluptas odio veniam assumenda nulla blanditiis nihil, adipisci atque possimus quaerat, eos ea ducimus! Veritatis, sunt libero quas odio doloremque qui quasi voluptas a optio? Animi vel, libero doloribus a minima ullam quam fugit, odit rem ex est optio earum doloremque vero? Animi?";
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post('/api/admin/provinces', ['name' => $name]);
        $response->assertStatus(422);
        $response->assertJson([
            "message" => "The name must not be greater than 50 characters.",
            "errors" => [
                "name" => [
                    "The name must not be greater than 50 characters."
                ]
            ]
        ]);
    }

    public function testShowProvinceSuccess()
    {
        Province::factory()->create([
            'name' => 'ACEH'
        ]);

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->get('/api/admin/provinces/3');
        $response->assertStatus(200);
        $response->assertJson([
           "code" => 200,
           "message" => "success",
           "data" => [
               "id" => 3,
               "name" => "ACEH"
           ]
        ]);
    }

    public function testShowProvinceNotFound()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->get('/api/admin/provinces/asal');
        $response->assertStatus(404);
        $response->assertJson([
            "code" => 404,
            "message" => "Province not found!"
        ]);
    }

    public function testUpdateProvinceSuccess()
    {
        Province::factory()->create([
            'name' => 'ACEH'
        ]);

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->put('/api/admin/provinces/4', ['name' => 'SUMATERA UTARA']);
        $response->assertStatus(200);
        $response->assertJson([
            "code" => 200,
            "message" => "success"
        ]);
    }

    public function testUpdateCityInvalidProperty()
    {
        Province::factory()->create([
            'name' => 'ACEH'
        ]);

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->put('/api/admin/provinces/5', ['name' => '']);
        $response->assertStatus(422);
        $response->assertJson([
            "message" => "The name field is required.",
            "errors" => [
                "name" => [
                    "The name field is required."
                ]
            ]
        ]);
    }

    public function testUpdateProvinceNotFound()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->put('/api/admin/provinces/asal', ['name' => 'SUMATERA UTARA']);
        $response->assertStatus(404);
        $response->assertJson([
            "code" => 404,
            "message" => "Province not found!"
        ]);
    }

    public function testDeleteProvinceSuccess()
    {
        Province::factory()->create([
            'name' => 'ACEH'
        ]);

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->delete('/api/admin/provinces/6');
        $response->assertStatus(200);
        $response->assertJson([
            "code" => 200,
            "message" => "success"
        ]);
    }

    public function testDeleteProvinceNotFound()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->delete('/api/admin/provinces/asal');
        $response->assertStatus(404);
        $response->assertJson([
            "code" => 404,
            "message" => "Province not found!"
        ]);
    }
}
