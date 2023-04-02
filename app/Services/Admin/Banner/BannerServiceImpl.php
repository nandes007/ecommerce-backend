<?php

namespace App\Services\Admin\Banner;

use App\Models\Banner;
use Illuminate\Support\Facades\DB;

class BannerServiceImpl implements BannerService
{

    public function __construct(protected Banner $banner)
    {
    }

    public function getAll()
    {
        return $this->banner->with('user')->paginate(10);
    }

    public function save($request)
    {
        return $this->banner->create($request);
    }

    public function find($id)
    {
        return $this->banner->find($id);
    }

    public function update($request, $id)
    {
        return $this->banner->where('id', $id)
                    ->update([
                        'user_id' => $request->user_id,
                        'title' => $request->title,
                        'url' => $request->url,
                        'status' => $request->status,
                        'image_path' => $request->image_path
                    ]);
    }

    public function delete($id)
    {
        return $this->banner->find($id)->delete();
    }
}
