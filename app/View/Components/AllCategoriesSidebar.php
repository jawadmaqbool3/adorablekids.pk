<?php

namespace App\View\Components;

use App\Models\Category;
use Illuminate\View\Component;

class AllCategoriesSidebar extends Component
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
        return view('components.all-categories-sidebar', compact('categories'));
    }
}
