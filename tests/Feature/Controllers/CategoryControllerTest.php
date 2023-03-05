<?php

namespace Tests\Feature\Controllers;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testGetCategoryNotEmptyEndpoint()
    {
        Category::factory()->create([
            'name' => 'Gadget',
            'slug' => Str::slug('Gadget')
        ]);

        $response = $this->getJson('/api/admin/categories');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            "code" => 200,
            "message" => "success",
            "data" => [
                "data" => [
                    [
                        "id" => 1,
                        "name" => "Gadget",
                        "slug" => "gadget"
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

    public function testGetCategoryEmptyEndpoint()
    {
        $response = $this->getJson('/api/admin/categories');

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

    public function testSearchCategoryEndpoint()
    {
        Category::factory()->create([
            'name' => 'Gadget',
            'slug' => Str::slug('Gadget')
        ]);

        $response = $this->getJson('/api/admin/categories/search', ['q' => 'gadget']);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            "code" => 200,
            "message" => "success",
            "data" => [
                [
                    "name" => "Gadget"
                ]
            ]
        ]);
    }

    public function testSearchCategoryEmptyEndpoint()
    {
        $response = $this->getJson('/api/admin/categories/search', ['q' => 'gadget']);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            "code" => 200,
            "message" => "success",
            "data" => []
        ]);
    }

    public function testStoreCategorySuccess()
    {
        $response = $this->withHeaders([
            "Accept" => 'application/json'
        ])->post('api/admin/categories', ['name' => 'Fashion']);
        $response->assertStatus(201);
        $response->assertJson([
            "code" => 201,
            "message" => "success",
            "data" => [
                "name" => "Fashion",
                "slug" => "fashion"
            ]
        ]);
    }

    public function testStoreCategoryEmptyProperty()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post('/api/admin/categories', ['name' => '']);
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
        ])->post('/api/admin/categories', ['name' => $name]);
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

    public function testShowCategorySuccess()
    {
        Category::factory()->create([
            'name' => 'Gadget',
            'slug' => Str::slug('Gadget')
        ]);

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->get('/api/admin/categories/4');
        $response->assertStatus(200);
        $response->assertJson([
            "code" => 200,
            "message" => "success",
            "data" => [
                "id" => 4,
                "name" => "Gadget",
                "slug" => "gadget",
                "parent_id" => NULL
            ]
        ]);
    }

    public function testShowCategoryNotFound()
    {
        $response = $this->withHeaders([
            "Accept" => 'application/json'
        ])->get('/api/admin/categories/notfound');
        $response->assertStatus(404);
        $response->assertJson([
            "code" => 404,
            "message" => "Category not found!"
        ]);
    }

    public function testUpdateCategorySuccess()
    {
        Category::factory()->create([
            'name' => 'Gadget',
            'slug' => Str::slug('Gadget')
        ]);

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->put('/api/admin/categories/5', ['name' => 'Gadget']);
        $response->assertStatus(200);
        $response->assertJson([
            "code" => 200,
            "message" => "success"
        ]);
    }

    public function testUpdateCategoryInvalid()
    {
        Category::factory()->create([
            'name' => 'Gadget',
            'slug' => Str::slug('Gadget')
        ]);

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->put('/api/admin/categories/6', ['name' => '']);
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

    public function testUpdateCategoryNotFound()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->put('/api/admin/categories/notfound', ['name' => 'Fashion']);
        $response->assertStatus(404);
        $response->assertJson([
            "code" => 404,
            "message" => "Category not found!"
        ]);
    }

    public function testDeleteCategorySuccess()
    {
        Category::factory()->create([
            'name' => 'Gadget',
            'slug' => Str::slug('Gadget')
        ]);

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->delete('/api/admin/categories/7');
        $response->assertStatus(200);
        $response->assertJson([
            "code" => 200,
            "message" => "success"
        ]);
    }

    public function testDeleteCategoryNotFound()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->delete('/api/admin/categories/notfound');
        $response->assertStatus(404);
        $response->assertJson([
            "code" => 404,
            "message" => "Category not found!"
        ]);
    }
}
