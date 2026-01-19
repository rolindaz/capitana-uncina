<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ResourceTable extends Component
{
    public string $title;
    public ?string $createRoute;
    public ?string $action;

    public function __construct(string $title, ?string $createRoute = null, ?string $action = null)
    {
        $this->title = $title;
        $this->createRoute = $createRoute;
        $this->action = $action;
    }

    public function render(): View|Closure|string
    {
        return view('admin.components.resource-table');
    }
}
