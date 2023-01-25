<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Description extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    protected $text;
    public function __construct($text)
    {
        $this->text = $text;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $text = $this->text;
        return view('components.description', compact('text'));
    }
}
