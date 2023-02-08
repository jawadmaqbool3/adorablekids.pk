<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function handleQuery(Request $request)
    {
        $results = [];
        $queries = explode(" ",$request->search_query);
        $products = Product::select("name", "thumbnail", "slug");
        $categories = Category::select("name", "thumbnail", "slug");
        foreach ($queries as $key => $query) {
            $products = $products->where("name", "LIKE", "%" . $query . "%");
            $categories = $categories->where("name", "LIKE", "%" . $query . "%");
        }
        $categories = $categories->get();
        $products = $products->get();
        foreach ($products as $product) {
            $name = $product->name;
            foreach ($queries as $key => $query) {
                $name = str_replace($query, "<strong class=\"text-info\">" . $query . "</strong>", $name);
            }
            $results[] = [
                "name" => $name,
                "url" => route("product.show", $product->slug),
                "thumb" => config("app.media_url") . "/assets/media/products/thumbs/" . $product->thumbnail
            ];
        }
        foreach ($categories as $category) {
            $name = $category->name;
            foreach ($queries as $key => $query) {
                $name = str_replace($query, "<strong class=\"text-info\">" . $query . "</strong>", $name);
            }
            $results[] = [
                "name" => $name,
                "url" => route("category.show", $category->slug),
                "thumb" => config("app.media_url") . "/assets/media/categories/thumbs/" . $category->thumbnail
            ];
        }

        return response([
            "success" => true,
            "results" => $results
        ]);
    }
}
