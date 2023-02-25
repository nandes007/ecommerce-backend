<?php

namespace Tests\Feature\Services\Admin;

use App\Models\Category;
use App\Services\Admin\Category\CategoryService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryServiceTest extends TestCase
{
    use RefreshDatabase;

    private CategoryService $categoryService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->categoryService = $this->app->make(CategoryService::class);
    }

    public function testCategoryNotNull()
    {
        $this->assertNotNull($this->categoryService);
    }

    public function testGetCategoriesNotEmpty()
    {
        $expected = [
            [
                "name" => "Gedget",
                "slug" => "gadget",
                "parent_id" => NULL
            ],
            [
                "name" => "Fashion",
                "slug" => "fashion",
                "parent_id" => 3
            ],
        ];

        $category1 = [
            "name" => "Gedget",
            "slug" => Str::slug('gadget'),
        ];

        $category2 = [
            "name" => "Fashion",
            "slug" => Str::slug('fashion'),
            "parent_id" => 3
        ];

        $this->categoryService->storeCategory($category1);
        $this->categoryService->storeCategory($category2);
        $categories = $this->categoryService->getAllCategory();

        $this->assertCount(2, $categories->items());
        $this->assertInstanceOf(LengthAwarePaginator::class, $categories);

        $this->assertEquals($expected[0]["name"], $categories->items()[0]->name);
        $this->assertEquals($expected[0]["slug"], $categories->items()[0]->slug);
        $this->assertEquals($expected[0]["parent_id"], $categories->items()[0]->parent_id);

        $this->assertEquals($expected[1]["name"], $categories->items()[1]->name);
        $this->assertEquals($expected[1]["slug"], $categories->items()[1]->slug);
        $this->assertEquals($expected[1]["parent_id"], $categories->items()[1]->parent_id);
    }

    public function testStoreCategory()
    {
        $request = [
            "name" => "test category",
            "slug" => Str::slug('test category'),
        ];
        $this->categoryService->storeCategory($request);

        $this->assertDatabaseHas('categories', [
            'name' => 'test category',
            'slug' => 'test-category'
        ]);
    }

    public function testShowCategorySuccess()
    {
        $name = "test category 2";
        $request = [
            "name" => $name,
            "slug" => Str::slug($name),
        ];
         $this->categoryService->storeCategory($request);

        $category = $this->categoryService->showCategory(4);
        $this->assertEquals(4, $category->id);
        $this->assertEquals("test category 2", $category->name);
        $this->assertEquals("test-category-2", $category->slug);
        $this->assertNull($category->parent_id);
    }

    public function testUpdateCategorySuccess()
    {
        $request = [
            "name" => "test category 2",
            "slug" => Str::slug('test category 2'),
        ];
        $requestUpdate = new Category();
        $requestUpdate->name = "test category 2 update";

        $this->categoryService->storeCategory($request);
        $categoryId = $this->categoryService->updateCategory($requestUpdate, 5);
        $this->assertEquals(1, $categoryId);
    }

    public function testDeleteCategorySuccess()
    {
        $request = [
            "name" => "test category 2",
            "slug" => Str::slug('test category 2'),
        ];

        $this->categoryService->storeCategory($request);

        $categoryId = $this->categoryService->deleteCategory(6);
        $this->assertEquals(1, $categoryId);
    }
}
