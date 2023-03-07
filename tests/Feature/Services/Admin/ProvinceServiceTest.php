<?php

namespace Tests\Feature\Services\Admin;

use App\Models\Province;
use App\Services\Admin\Province\ProvinceService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class ProvinceServiceTest extends TestCase
{
    use RefreshDatabase;

    protected ProvinceService $provinceService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->provinceService = $this->app->make(ProvinceService::class);
    }

    public function testProvinceServiceNotNull()
    {
        $this->assertNotNull($this->provinceService);
    }

    public function testGetProvinceNotEmpty()
    {
        $expected = [
            [
                "name" => "ACEH"
            ],
            [
                "name" => "SUMATERA UTARA"
            ]
        ];

        $province1 = [
            "name" => "ACEH"
        ];

        $province2 = [
            "name" => "SUMATERA UTARA"
        ];

        $this->provinceService->save($province1);
        $this->provinceService->save($province2);

        $provinces = $this->provinceService->getAll();

        $this->assertCount(2, $provinces->items());
        $this->assertInstanceOf(LengthAwarePaginator::class, $provinces);

        $this->assertEquals($expected[0]["name"], $provinces->items()[0]->name);
        $this->assertEquals($expected[1]["name"], $provinces->items()[1]->name);
    }

    public function testSaveProvice()
    {
        $request = [
            "name" => "ACEH"
        ];

        $this->provinceService->save($request);

        $this->assertDatabaseHas('provinces', [
            'name' => 'ACEH'
        ]);
    }

    public function testFindProvice()
    {
        $request = [
            "name" => "ACEH"
        ];

        $this->provinceService->save($request);

        $province = $this->provinceService->find(4);
        $this->assertEquals(4, $province->id);
        $this->assertEquals("ACEH", $province->name);
    }

    public function testUpdateProvince()
    {
        $request = [
            "name" => "ACEH"
        ];
        $requestUpdate = new Province();
        $requestUpdate->name = "SUMATERA UTARA";

        $this->provinceService->save($request);
        $provinceId = $this->provinceService->update($requestUpdate, 5);
        $this->assertEquals(1, $provinceId);
    }

    public function testDeleteProvinceSuccess()
    {
        $request = [
            "name" => "ACEH"
        ];

        $this->provinceService->save($request);
        $provinceId = $this->provinceService->delete(6);
        $this->assertEquals(6, $provinceId);
    }
}
