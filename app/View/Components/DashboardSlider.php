<?php

namespace App\View\Components;

use App\Models\DashboardSetting;
use Illuminate\View\Component;

class DashboardSlider extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    private $images;
    private $sliderImagesDirectory;
    public function __construct()
    {
        $settings = DashboardSetting::first();
        if ($settings) {
            $this->images = json_decode($settings->slider_images);
            $this->sliderImagesDirectory = "assets/media/public_dashboard/slider/images/";
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $images = $this->images;
        $sliderImagesDirectory = $this->sliderImagesDirectory;
        if ($images) {
            return view('components.dashboard-slider', compact('images', 'sliderImagesDirectory'));
        }
    }
}
