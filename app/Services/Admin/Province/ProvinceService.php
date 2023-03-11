<?php

namespace App\Services\Admin\Province;

interface ProvinceService
{
    public function getAll();

    public function getAllWithoutPagination();

    public function save($request);

    public function find($id);

    public function update($request, $id);

    public function delete($id);
}
