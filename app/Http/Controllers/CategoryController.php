<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategoryController extends Controller
{
    public function getCategories()
{
    $categories = DB::table('categories')
        ->select('id', 'name', 'icon','type')
        ->get();

    return response()->json($categories);
}
}
