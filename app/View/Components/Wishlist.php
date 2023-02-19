<?php

namespace App\View\Components;

use App\Models\Product;
use Illuminate\View\Component;

class Wishlist extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    protected $products;
    public function __construct()
    {
        $this->products = Product::whereHas('wishListUsers', function ($query) {
            $query->where('users.id', auth()->user()->id);
        })->published()->paginate(20);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $products  = $this->products;
        return view('components.wishlist', compact('products'));
    }
}
