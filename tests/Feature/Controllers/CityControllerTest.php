<?php

namespace Tests\Feature\Controllers;

use App\Models\City;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class CityControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testGetCityNotEmptyEndpoint()
    {
        City::factory()->create([
            'province_id' => 1,
            'name' => 'KOTA MEDAN'
        ]);

        $response = $this->getJson('/api/admin/cities');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            "code" => 200,
            "message" => "success",
            "data" => [
                "data" => [
                    [
                        "id" => 1,
                        "province_id" => 1,
                        "name" => "KOTA MEDAN"
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

    public function testGetEmptyEndpoint()
    {
        $response = $this->getJson('/api/admin/cities');

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

    public function testStoreCitySuccess()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post('/api/admin/cities', ['province_id' => 1, 'name' => 'MEDAN']);
        $response->assertStatus(201);
        $response->assertJson([
            "code" => 201,
            "message" => "success",
            "data" => [
                "province_id" => 1,
                "name" => "MEDAN"
            ]
        ]);
    }

    public function testStoreProvinceEmptyProperty()
    {
        $response = $this->withHeaders([
            "Accept" => "application/json"
        ])->post('/api/admin/cities', ['province_id' => '', 'name' => '']);
        $response->assertStatus(422);
        $response->assertJson([
            "message" => "The province id field is required. (and 1 more error)",
            "errors" => [
                "province_id" => [
                    "The province id field is required."
                ],
                "name" => [
                    "The name field is required."
                ]
            ]
        ]);
    }

    public function testStoreInvalidLength()
    {
        $name = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure facere officia rem? Dolorum minus enim laborum iusto asperiores? Adipisci voluptates nemo rerum facilis voluptatum eligendi animi dolores tenetur exercitationem mollitia quis magni cumque ex, vel culpa quibusdam ipsam error quam illo fugiat minima! Modi fugit quaerat, illo architecto voluptatem sed. Iure ipsa magnam non doloremque, ipsum, quaerat repudiandae, explicabo unde saepe commodi dicta ratione enim quo nemo. A, modi sint nemo quae nesciunt consequatur rem eveniet facere eos minus, illo necessitatibus voluptas totam perferendis sequi aperiam odit quas, nulla voluptatibus fugiat sunt voluptatem dicta qui? Quae sint quidem sequi beatae voluptates.';
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post('/api/admin/cities', ['province_id' => 1, 'name' => $name]);
        $response->assertStatus(422);
        $response->assertJson([
            "message" => "The name must not be greater than 100 characters.",
            "errors" => [
                "name" => [
                    "The name must not be greater than 100 characters."
                ]
            ]
        ]);
    }

    public function testShowCitySuccess()
    {
        City::factory()->create([
            'province_id' => 1,
            'name' => 'KOTA MEDAN'
        ]);

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->get('/api/admin/cities/3');
        $response->assertStatus(200);
        $response->assertJson([
            "code" => 200,
            "message" => "success",
            "data" => [
                "id" => 3,
                "province_id" => 1,
                "name" => "KOTA MEDAN"
            ]
        ]);
    }

    public function testShowCityNotFound()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->get('/api/admin/cities/notfound');
        $response->assertStatus(404);
        $response->assertJson([
            "code" => 404,
            "message" => "City not found!"
        ]);
    }

    public function testUpdateCitySuccess()
    {
        City::factory()->create([
            'province_id' => 1,
            'name' => 'KOTA MEDAN'
        ]);

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->put('/api/admin/cities/4', ['province_id' => 2, 'name' => 'KOTA BINJAI']);
        $response->assertStatus(200);
        $response->assertJson([
            "code" => 200,
            "message" => "success"
        ]);
    }

    public function testUpdateCityInvalidProperty()
    {
        City::factory()->create([
            'province_id' => 1,
            'name' => 'KOTA MEDAN'
        ]);

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->put('/api/admin/cities/5', ['province_id' => '', 'name' => '']);
        $response->assertStatus(422);
        $response->assertJson([
            "message" => "The province id field is required. (and 1 more error)",
            "errors" => [
                "province_id" => [
                    "The province id field is required."
                ],
                "name" => [
                    "The name field is required."
                ]
            ]
        ]);
    }

    public function testUpdateCityNotFound()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->put('/api/admin/cities/notfound', ['province_id' => 2, 'name' => 'KOTA MEDAN']);
        $response->assertStatus(404);
        $response->assertJson([
            "code" => 404,
            "message" => "City not found!"
        ]);
    }

    public function testDeleteCitySuccess()
    {
        City::factory()->create([
            'province_id' => 1,
            'name' => 'KOTA MEDAN'
        ]);

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->delete('/api/admin/cities/6');
        $response->assertStatus(200);
        $response->assertJson([
            "code" => 200,
            "message" => "success"
        ]);
    }

    public function testDeleteCityNotFound()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->delete('/api/admin/cities/notfound');
        $response->assertStatus(404);
        $response->assertJson([
            "code" => 404,
            "message" => "City not found!"
        ]);
    }
}
