<?php

namespace App\Services\Admin\City;

interface CityService
{
    public function getAll();

    public function save($request);

    public function find($id);

    public function update($request, $id);

    public function delete($id);

}
