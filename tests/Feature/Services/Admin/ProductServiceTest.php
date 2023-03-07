<?php

namespace Tests\Feature\Services\Admin;

use App\Models\Product;
use App\Services\Admin\Product\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    use RefreshDatabase;

    private ProductService $productService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productService = $this->app->make(ProductService::class);
    }

    public function testProductNotNull()
    {
        $this->assertNotNull($this->productService);
    }

    public function testGetProductNotEmpty()
    {
        $product = [
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
        ];

        $this->productService->save($product);
        $products = $this->productService->getAll();
        $this->assertCount(1, $products->items());
        $this->assertInstanceOf(LengthAwarePaginator::class, $products);
        $this->assertEquals($product["sku"], $products->items()[0]->sku);
        $this->assertEquals($product["barcode"], $products->items()[0]->barcode);
        $this->assertEquals($product["product_name"], $products->items()[0]->product_name);
        $this->assertEquals($product["slug"], $products->items()[0]->slug);
        $this->assertEquals($product["unit"], $products->items()[0]->unit);
        $this->assertEquals($product["fraction"], $products->items()[0]->fraction);
        $this->assertEquals($product["status"], $products->items()[0]->status);
        $this->assertEquals($product["avgcost"], $products->items()[0]->avgcost);
        $this->assertEquals($product["lastcost"], $products->items()[0]->lastcost);
        $this->assertEquals($product["unitprice"], $products->items()[0]->unitprice);
        $this->assertEquals($product["price_old"], $products->items()[0]->price_old);
        $this->assertEquals($product["price"], $products->items()[0]->price);
        $this->assertEquals($product["weight"], $products->items()[0]->weight);
        $this->assertEquals($product["tax"], $products->items()[0]->tax);
        $this->assertEquals($product["description"], $products->items()[0]->description);
    }

    public function testSaveProduct()
    {
        $request = [
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
        ];
        $this->productService->save($request);

        $this->assertDatabaseHas('products', $request);
    }

    public function testFindProductSuccess()
    {
        $request = [
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
        ];

        $this->productService->save($request);
        $product = $this->productService->find(3);

        $this->assertEquals($request["sku"], $product->sku);
        $this->assertEquals($request["barcode"], $product->barcode);
        $this->assertEquals($request["product_name"], $product->product_name);
        $this->assertEquals($request["slug"], $product->slug);
        $this->assertEquals($request["unit"], $product->unit);
        $this->assertEquals($request["fraction"], $product->fraction);
        $this->assertEquals($request["status"], $product->status);
        $this->assertEquals($request["avgcost"], $product->avgcost);
        $this->assertEquals($request["lastcost"], $product->lastcost);
        $this->assertEquals($request["unitprice"], $product->unitprice);
        $this->assertEquals($request["price_old"], $product->price_old);
        $this->assertEquals($request["price"], $product->price);
        $this->assertEquals($request["weight"], $product->weight);
        $this->assertEquals($request["tax"], $product->tax);
        $this->assertEquals($request["description"], $product->description);
    }

    public function testUpdateProductSuccess()
    {
        $request = [
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
        ];

        $requestUpdate = new Product();
        $requestUpdate->sku = "0070071";
        $requestUpdate->barcode = "001001001";
        $requestUpdate->product_name = "Macbook Book Pro";
        $requestUpdate->unit = "PCS";
        $requestUpdate->fraction = "10";
        $requestUpdate->status = "active";
        $requestUpdate->avgcost = 32000;
        $requestUpdate->lastcost = 32000;
        $requestUpdate->unitprice = 32000;
        $requestUpdate->price_old = 40000;
        $requestUpdate->price = 40000;
        $requestUpdate->weight = 10;
        $requestUpdate->tax = true;
        $requestUpdate->description = "test product";


        $this->productService->save($request);
        $status = $this->productService->update($requestUpdate, 4);
        $this->assertEquals(1, $status);
        $this->assertDatabaseHas('products', [
            "barcode" => "001001001",
            "product_name" => "Macbook Book Pro"
        ]);
    }

    public function testDeleteProductSuccess()
    {
        $request = [
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
        ];

        $this->productService->save($request);

        $status = $this->productService->delete(5);
        $this->assertEquals(1, $status);
    }
}
