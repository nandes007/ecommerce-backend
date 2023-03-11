<?php

namespace App\Services\Admin\Province;

use App\Models\Province;

class ProvinceServiceImpl implements ProvinceService
{
    protected Province $province;

    public function __construct(Province $province)
    {
        $this->province = $province;
    }

    public function getAll()
    {
        return $this->province->paginate(10);
    }

    public function getAllWithoutPagination()
    {
        return $this->province->all();
    }

    public function save($request)
    {
        return $this->province->create($request);
    }

    public function find($id)
    {
        return $this->province->find($id);
    }

    public function update($request, $id)
    {
        return $this->province->where('id', $id)
                    ->update([
                        'name' => $request->name
                    ]);
    }

    public function delete($id)
    {
        return $this->province->find($id)->delete();
    }
}
