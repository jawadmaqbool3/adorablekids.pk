<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BreadCrumbs extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    private $links;
    public function __construct($links)
    {
        $this->links = $links;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $links = $this->links;
        return view('components.bread-crumbs', compact('links'));
    }
}
