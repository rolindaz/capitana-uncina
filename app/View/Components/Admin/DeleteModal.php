<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeleteModal extends Component
{
    public function render(): View|Closure|string
    {
        return view('admin.components.delete-modal');
    }
}
