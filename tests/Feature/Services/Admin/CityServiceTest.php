<?php

namespace Tests\Feature\Services\Admin;

use App\Models\City;
use App\Services\Admin\City\CityService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class CityServiceTest extends TestCase
{
    use RefreshDatabase;

    protected CityService $cityService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cityService = $this->app->make(CityService::class);
    }

    public function testCityServiceNotNull()
    {
        $this->assertNotNull($this->cityService);
    }

    public function testGetCityNotEmpty()
    {
        $expected = [
            [
                "province_id" => 2,
                "name" => "KOTA MEDAN"
            ],
            [
                "province_id" => 2,
                "name" => "KOTA BINJAI"
            ]
        ];

        $city1 = [
            "province_id" => 2,
            "name" => "KOTA MEDAN"
        ];

        $city2 = [
            "province_id" => 2,
            "name" => "KOTA BINJAI"
        ];

        $this->cityService->save($city1);
        $this->cityService->save($city2);

        $cities = $this->cityService->getAll();

        $this->assertCount(2, $cities->items());
        $this->assertInstanceOf(LengthAwarePaginator::class, $cities);

        $this->assertEquals($expected[0]["province_id"], $cities->items()[0]->province_id);
        $this->assertEquals($expected[0]["name"], $cities->items()[0]->name);
        $this->assertEquals($expected[1]["province_id"], $cities->items()[1]->province_id);
        $this->assertEquals($expected[1]["name"], $cities->items()[1]->name);
    }

    public function testSaveCity()
    {
        $request = [
            "province_id" => 2,
            "name" => "KOTA MEDAN"
        ];

        $this->cityService->save($request);
        $this->assertDatabaseHas('cities', [
            "province_id" => 2,
            "name" => "KOTA MEDAN"
        ]);
    }

    public function testFindCity()
    {
        $request = [
            "province_id" => 2,
            "name" => "KOTA MEDAN"
        ];

        $this->cityService->save($request);

        $city = $this->cityService->find(1);
        $this->assertEquals(1, $city->id);
        $this->assertEquals("KOTA MEDAN", $city->name);
    }

    public function testUpdateCity()
    {
        $request = [
            "province_id" => 2,
            "name" => "KOTA MEDAN"
        ];
        $requestUpdate = new City();
        $requestUpdate->province_id = 2;
        $requestUpdate->name = "KOTA BINJAI";

        $this->cityService->save($request);
        $cityId = $this->cityService->update($requestUpdate, 1);
        $this->assertEquals(1, $cityId);
    }

    public function testDeleteCity()
    {
        $request = [
            "province_id" => 2,
            "name" => "KOTA MEDAN"
        ];

        $this->cityService->save($request);
        $cityId = $this->cityService->delete(1);
        $this->assertEquals(1, $cityId);
    }
}
