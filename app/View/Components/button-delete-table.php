<?php

namespace App\View\Components;

use Illuminate\View\Component;

class button-delete-table extends Component
{
    public $onclick;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($onclick)
    {
        $this->onclick = $onclick;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.button-delete-table');
    }
}
