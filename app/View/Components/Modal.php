<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{

    public string $id;
    public string $title;
    public array $buttons;
    public string $size;

    public function __construct($id = '', $title = '', $buttons = [], $size = 'md')
    {
        $this->id = $id;
        $this->title = $title;
        $this->buttons = $buttons;
        $this->size = $size;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal');
    }
}
