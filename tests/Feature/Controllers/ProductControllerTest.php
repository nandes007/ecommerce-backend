<?php

namespace Tests\Feature\Controllers;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testGetProductNotEmptyEndpoint()
    {
        Product::factory()->create([
            "sku" => "0070071",
            "barcode" => "000123000123",
            "product_name" => "Syrup Marjan",
            "slug" => "syrup-marjan",
            "unit" => "PCS",
            "fraction" => "1",
            "status" => "active",
            "avgcost" => 32000,
            "lastcost" => 32000,
            "unitprice" => 32000,
            "price_old" => 40000,
            "price" => 40000,
            "weight" => 10,
            "tax" => true,
            "description" => "test product"
        ]);

        $response = $this->getJson('/api/admin/products');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            "code" => 200,
            "message" => "success",
            "data" => [
                "data" => [
                    [
                        "id" => 1,
                        "sku" => "0070071",
                        "barcode" => "000123000123",
                        "product_name" => "Syrup Marjan",
                        "slug" => "syrup-marjan",
                        "unit" => "PCS",
                        "fraction" => "1",
                        "status" => "active",
                        "avgcost" => 32000,
                        "lastcost" => 32000,
                        "unitprice" => 32000,
                        "price_old" => 40000,
                        "price" => 40000,
                        "weight" => 10,
                        "tax" => true,
                        "description" => "test product"
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

    public function testGetProductEmptyEndpoint()
    {
        $response = $this->getJson('/api/admin/products');

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

    public function testStoreProductSuccess()
    {
        $response = $this->withHeaders([
            "Accept" => "application/json"
        ])->post('/api/admin/products', [
            "sku" => "0070071",
            "barcode" => "000123000123",
            "product_name" => "Syrup Marjan",
            "slug" => "syrup-marjan",
            "unit" => "PCS",
            "fraction" => "1",
            "status" => "active",
            "avgcost" => 32000,
            "lastcost" => 32000,
            "unitprice" => 32000,
            "price_old" => 40000,
            "price" => 40000,
            "weight" => 10,
            "tax" => true,
            "description" => "test product"
        ]);
        $response->assertStatus(201);
        $response->assertJson([
            "code" => 201,
            "message" => "success",
            "data" => [
                "sku" => "0070071",
                "barcode" => "000123000123",
                "product_name" => "Syrup Marjan",
                "slug" => "syrup-marjan",
                "unit" => "PCS",
                "fraction" => "1",
                "status" => "active",
                "avgcost" => 32000,
                "lastcost" => 32000,
                "unitprice" => 32000,
                "price_old" => 40000,
                "price" => 40000,
                "weight" => 10,
                "tax" => true,
                "description" => "test product"
            ]
        ]);
    }

    public function testStoreProductEmptyProperty()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post('/api/admin/products', [
            "sku" => "",
            "barcode" => "",
            "product_name" => "",
            "slug" => "",
            "unit" => "",
            "fraction" => "",
            "status" => "",
            "avgcost" => "",
            "lastcost" => "",
            "unitprice" => "",
            "price_old" => "",
            "price" => "",
            "weight" => "",
            "tax" => ""
        ]);
        $response->assertJson([
            "message" => "The sku field is required. (and 12 more errors)",
            "errors" => [
                "sku" => [
                    "The sku field is required."
                ],
                "barcode" => [
                    "The barcode field is required."
                ],
                "product_name" => [
                    "The product name field is required."
                ],
                "unit" => [
                    "The unit field is required."
                ],
                "fraction" => [
                    "The fraction field is required."
                ],
                "status" => [
                    "The status field is required."
                ],
                "avgcost" => [
                    "The avgcost field is required."
                ],
                "lastcost" => [
                    "The lastcost field is required."
                ],
                "unitprice" => [
                    "The unitprice field is required."
                ],
                "price_old" => [
                    "The price old field is required."
                ],
                "price" => [
                    "The price field is required."
                ],
                "weight" => [
                    "The weight field is required."
                ],
                "tax" => [
                    "The tax field is required."
                ]
            ]
        ]);
    }

    public function testStoreInvalidProperty()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post('/api/admin/products', [
            "sku" => "010101",
            "barcode" => "020202",
            "product_name" => "Piatos snack kentang",
            "slug" => "piatos-snack-kentang",
            "unit" => "PCS",
            "fraction" => "asd",
            "status" => "active",
            "avgcost" => "abc",
            "lastcost" => "abc",
            "unitprice" => "abc",
            "price_old" => "abc",
            "price" => "abc",
            "weight" => "abc",
            "tax" => true
        ]);
        $response->assertJson([
            "message" => "The fraction must be a number. (and 6 more errors)",
            "errors" => [
                "fraction" => [
                    "The fraction must be a number."
                ],
                "avgcost" => [
                    "The avgcost must be a number."
                ],
                "lastcost" => [
                    "The lastcost must be a number."
                ],
                "unitprice" => [
                    "The unitprice must be a number."
                ],
                "price_old" => [
                    "The price old must be a number."
                ],
                "price" => [
                    "The price must be a number."
                ],
                "weight" => [
                    "The weight must be a number."
                ]
            ]
        ]);
    }

    public function testStoreInvalidLength()
    {
        $oneHundredOneWord = "Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quis expedita beatae ratione deleniti. Eius alias placeat vero, suscipit necessitatibus distinctio magnam, quas provident inventore, quia libero! Voluptatibus, molestiae eveniet. Placeat debitis, provident ullam autem quisquam libero soluta obcaecati optio aliquid cum molestiae sequi perspiciatis doloribus corrupti error odit quis tenetur. Accusamus labore dicta aliquid suscipit ullam tenetur voluptas odio veniam assumenda nulla blanditiis nihil, adipisci atque possimus quaerat, eos ea ducimus! Veritatis, sunt libero quas odio doloremque qui quasi voluptas a optio? Animi vel, libero doloribus a minima ullam quam fugit, odit rem ex est optio earum doloremque vero? Animi?";
        $twentyFiveRandNumber = 1231231231231231231231123;
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post('/api/admin/products', [
            "sku" => $oneHundredOneWord,
            "barcode" => $oneHundredOneWord,
            "product_name" => $oneHundredOneWord,
            "slug" => $oneHundredOneWord,
            "unit" => $oneHundredOneWord,
            "fraction" => $twentyFiveRandNumber,
            "status" => $oneHundredOneWord
        ]);
        $response->assertJson([
            "message" => "The sku must not be greater than 20 characters. (and 11 more errors)",
            "errors" => [
                "sku" => [
                    "The sku must not be greater than 20 characters."
                ],
                "barcode" =>  [
                    "The barcode must not be greater than 20 characters."
                ],
                "product_name" => [
                    "The product name must not be greater than 100 characters."
                ],
                "unit" => [
                    "The unit must not be greater than 10 characters."
                ],
                "status" => [
                    "The status must not be greater than 20 characters."
                ],
                "avgcost" => [
                    "The avgcost field is required."
                ],
                "lastcost" => [
                    "The lastcost field is required."
                ],
                "unitprice" => [
                    "The unitprice field is required."
                ],
                "price_old" => [
                    "The price old field is required."
                ],
                "price" => [
                   "The price field is required."
                ],
                "weight" => [
                    "The weight field is required."
                ],
                "tax" => [
                    "The tax field is required."
                ]
            ]
        ]);
    }

    public function testShowProductSuccess()
    {
        Product::factory()->create([
            "sku" => "0070071",
            "barcode" => "000123000123",
            "product_name" => "Syrup Marjan",
            "slug" => "syrup-marjan",
            "unit" => "PCS",
            "fraction" => "1",
            "status" => "active",
            "avgcost" => 32000,
            "lastcost" => 32000,
            "unitprice" => 32000,
            "price_old" => 40000,
            "price" => 40000,
            "weight" => 10,
            "tax" => true,
            "description" => "test product"
        ]);

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->get('/api/admin/products/3');
        $response->assertStatus(200);
        $response->assertJson([
            "code" => 200,
            "message" => "success",
            "data" => [
                "id" => 3,
                "sku" => "0070071",
                "barcode" => "000123000123",
                "product_name" => "Syrup Marjan",
                "slug" => "syrup-marjan",
                "unit" => "PCS",
                "fraction" => "1",
                "status" => "active",
                "avgcost" => 32000.00,
                "lastcost" => 32000.00,
                "unitprice" => 32000.00,
                "price_old" => 40000.00,
                "price" => 40000.00,
                "weight" => 10.00,
                "tax" => true,
                "description" => "test product"
            ]
        ]);
    }

    public function testShowProductNotFound()
    {
        $response = $this->withHeaders([
            "Accept" => "application/json"
        ])->get('/api/admin/products/notfound');
        $response->assertStatus(404);
        $response->assertJson([
            "code" => 404,
            "message" => "Product not found!"
        ]);
    }

    public function testUpdateProductSuccess()
    {
        Product::factory()->create([
            "sku" => "0070071",
            "barcode" => "000123000123",
            "product_name" => "Syrup Marjan",
            "slug" => "syrup-marjan",
            "unit" => "PCS",
            "fraction" => "1",
            "status" => "active",
            "avgcost" => 32000,
            "lastcost" => 32000,
            "unitprice" => 32000,
            "price_old" => 40000,
            "price" => 40000,
            "weight" => 10,
            "tax" => true,
            "description" => "test product"
        ]);

        $response = $this->withHeaders([
            "Accept" => 'application/json'
        ])->put('/api/admin/products/4', [
            "sku" => "0010011",
            "barcode" => "001002003004",
            "product_name" => "Syrup Marjan",
            "slug" => "syrup-marjan",
            "unit" => "PCS",
            "fraction" => "1",
            "status" => "active",
            "avgcost" => 32000,
            "lastcost" => 32000,
            "unitprice" => 32000,
            "price_old" => 40000,
            "price" => 40000,
            "weight" => 10,
            "tax" => true,
            "description" => "test product"
        ]);
        $response->assertStatus(200);
        $response->assertJson([
            "code" => 200,
            "message" => "success"
        ]);
    }

    public function testUpdateCategoryInvalid()
    {
        Product::factory()->create([
            "sku" => "0070071",
            "barcode" => "000123000123",
            "product_name" => "Syrup Marjan",
            "slug" => "syrup-marjan",
            "unit" => "PCS",
            "fraction" => "1",
            "status" => "active",
            "avgcost" => 32000,
            "lastcost" => 32000,
            "unitprice" => 32000,
            "price_old" => 40000,
            "price" => 40000,
            "weight" => 10,
            "tax" => true,
            "description" => "test product"
        ]);

        $response = $this->withHeaders([
            "Accept" => "application/json"
        ])->put('/api/admin/products/5', [
            "sku" => "",
            "barcode" => "",
            "product_name" => "",
            "slug" => "",
            "unit" => "",
            "fraction" => "",
            "status" => "",
            "avgcost" => "",
            "lastcost" => "",
            "unitprice" => "",
            "price_old" => "",
            "price" => "",
            "weight" => "",
            "tax" => ""
        ]);
        $response->assertStatus(422);
        $response->assertJson([
            "message" => "The sku field is required. (and 12 more errors)",
            "errors" => [
                "sku" => [
                    "The sku field is required."
                ],
                "barcode" => [
                    "The barcode field is required."
                ],
                "product_name" => [
                    "The product name field is required."
                ],
                "unit" => [
                    "The unit field is required."
                ],
                "fraction" => [
                    "The fraction field is required."
                ],
                "status" => [
                    "The status field is required."
                ],
                "avgcost" => [
                    "The avgcost field is required."
                ],
                "lastcost" => [
                    "The lastcost field is required."
                ],
                "unitprice" => [
                    "The unitprice field is required."
                ],
                "price_old" => [
                    "The price old field is required."
                ],
                "price" => [
                    "The price field is required."
                ],
                "weight" => [
                    "The weight field is required."
                ],
                "tax" => [
                    "The tax field is required."
                ]
            ]
        ]);
    }

    public function testUpdateProductNotFound()
    {
        $response = $this->withHeaders([
            "Accept" => "application/json"
        ])->put("/api/admin/products/notfound", [
            "sku" => "0070071",
            "barcode" => "000123000123",
            "product_name" => "Syrup Marjan",
            "slug" => "syrup-marjan",
            "unit" => "PCS",
            "fraction" => "1",
            "status" => "active",
            "avgcost" => 32000,
            "lastcost" => 32000,
            "unitprice" => 32000,
            "price_old" => 40000,
            "price" => 40000,
            "weight" => 10,
            "tax" => true,
            "description" => "test product"
        ]);
        $response->assertStatus(404);
        $response->assertJson([
            "code" => 404,
            "message" => "Product not found!"
        ]);
    }

    public function testDeleteProductSuccess()
    {
        Product::factory()->create([
            "sku" => "0070071",
            "barcode" => "000123000123",
            "product_name" => "Syrup Marjan",
            "slug" => "syrup-marjan",
            "unit" => "PCS",
            "fraction" => "1",
            "status" => "active",
            "avgcost" => 32000,
            "lastcost" => 32000,
            "unitprice" => 32000,
            "price_old" => 40000,
            "price" => 40000,
            "weight" => 10,
            "tax" => true,
            "description" => "test product"
        ]);

        $response = $this->withHeaders([
            "Accept" => "application/json"
        ])->delete('/api/admin/products/6');
        $response->assertStatus(200);
        $response->assertJson([
            "code" => 200,
            "message" => "success"
        ]);
    }

    public function testDeleteProductNotFound()
    {
        $response = $this->withHeaders([
            "Accept" => "application/json"
        ])->delete("/api/admin/products/notfound");
        $response->assertStatus(404);
        $response->assertJson([
            "code" => 404,
            "message" => "Product not found!"
        ]);
    }
}
