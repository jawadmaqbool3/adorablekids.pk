<?php

namespace App\View\Components;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\Component;

class ProductsPaginator extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    private $products;
    public function __construct(Category $category = null)
    {
        if ($category) {
            $this->products = Product::whereHas('categories', function($query) use($category){
                $query->where('category_id', $category->id);
            })->published()->paginate(20);
        } else {
            $this->products = Product::published()->paginate(20);
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $products =  $this->products;
        return view('components.products-paginator', compact('products'));
    }
}
