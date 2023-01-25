<?php

namespace App\View\Components;

use App\Models\Product;
use Illuminate\View\Component;

class FeaturedProductGrid extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    protected $products;
    public function __construct()
    {
        $this->products = Product::featured()->published()->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $products =  $this->products;
        return view('components.featured-product-grid', compact('products'));
    }
}
