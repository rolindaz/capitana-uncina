<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ResourceTable extends Component
{
    public string $title;
    public ?string $createRoute;

    public function __construct(string $title, ?string $createRoute = null)
    {
        $this->title = $title;
        $this->createRoute = $createRoute;
    }

    public function render(): View|Closure|string
    {
        return view('admin.components.resource-table');
    }
}
