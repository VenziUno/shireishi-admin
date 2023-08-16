<?php

namespace App\View\Components;

use Illuminate\View\Component;

class button extends Component
{
    public $href;
    public $target;
    public $type;
    public $label;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($href, $target, $type, $label)
    {
        $this->href = $href;
        $this->target = $target;
        $this->type = $type;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.button');
    }
}
