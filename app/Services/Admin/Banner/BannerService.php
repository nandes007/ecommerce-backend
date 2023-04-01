<?php

namespace App\Services\Admin\Banner;

interface BannerService
{
    public function getAll();

    public function save($request);

    public function find($id);

    public function update($request, $id);

    public function delete($id);
}
