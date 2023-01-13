<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::published()
            ->get();
        $featuredCategories = Category::published()
            ->featured()
            ->get();
        $featuredProductCategories = Category::published()
            ->whereHas('featuredProducts')
            ->with('featuredProducts')
            ->get();
        return view('dashboard.index', compact('categories', 'featuredCategories', 'featuredProductCategories'));
    }
}
