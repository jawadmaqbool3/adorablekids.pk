<?php

namespace App\View\Components;

use App\Models\Category;
use Illuminate\View\Component;

class FeaturedCategoriesSlider extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    protected $categories;
    public function __construct()
    {
        $this->categories = Category::published()
        ->featured()
        ->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $categories = $this->categories;
        return view('components.featured-categories-slider', compact('categories'));
    }
}
