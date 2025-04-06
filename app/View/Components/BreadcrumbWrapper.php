<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BreadcrumbWrapper extends Component
{
    public array $breadcrumbs;

    public function __construct(array $breadcrumbs = [])
    {
        $this->breadcrumbs = $breadcrumbs;
    }

    public function render()
    {
        return view('components.breadcrumb-wrapper');
    }
}