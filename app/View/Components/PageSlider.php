<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PageSlider extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    protected $images;
    protected $prefix;
    public function __construct($images, $prefix)
    {
        $this->images = $images;
        $this->prefix = $prefix;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $images = $this->images;
        $prefix = $this->prefix;
        return view('components.page-slider', compact('images', 'prefix'));
    }
}
