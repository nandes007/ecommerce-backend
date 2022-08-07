<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = DB::table('categories')
                        ->select('name', 'slug')
                        ->get();
        
        return $this->output(status: 'success', data: $categories, code: 200);
    }
}
