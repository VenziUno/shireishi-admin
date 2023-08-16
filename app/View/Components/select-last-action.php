<?php

namespace App\View\Components;

use Illuminate\View\Component;

class select-last-action extends Component
{
    public $id;
    public $name;
    public $options;
    public $label;
    public $onchange;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct$id, $name, $options, $label, $onchange()
    {
        $this->id = $id;
        $this->name = $name;
        $this->options = $options;
        $this->label = $label;
        $this->onchange = $onchange;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select-last-action');
    }
}
