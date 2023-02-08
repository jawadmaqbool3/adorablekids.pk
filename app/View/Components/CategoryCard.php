<?php

namespace App\View\Components;

use App\Models\Category;
use Illuminate\View\Component;

class CategoryCard extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    protected $category;
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $category = $this->category;
        return view('components.category-card', compact('category'));
    }
}
