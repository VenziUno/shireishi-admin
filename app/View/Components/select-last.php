<?php

namespace App\View\Components;

use Illuminate\View\Component;

class select-last extends Component
{
    public $id;
    public $name;
    public $options;
    public $label;
    public $value;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $name, $options, $label, $value)
    {
        $this->id = $id;
        $this->name = $name;
        $this->options = $options;
        $this->label = $label;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select-last');
    }
}
