<?php

namespace App\Services\Admin\City;

use App\Models\City;

class CityServiceImpl implements CityService
{

    protected City $city;

    public function __construct(City $city)
    {
        $this->city = $city;
    }

    public function getAll()
    {
        return $this->city->paginate(10);
    }

    public function save($request)
    {
        return $this->city->create($request);
    }

    public function find($id)
    {
        return $this->city->find($id);
    }

    public function update($request, $id)
    {
        return $this->city->where('id', $id)
                    ->update([
                        'province_id' => $request->province_id,
                        'name' => $request->name
                    ]);
    }

    public function delete($id)
    {
        return $this->city->find($id)->delete();
    }
}
