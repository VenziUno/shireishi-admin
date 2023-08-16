<?php

namespace App\View\Components;

use Illuminate\View\Component;

class input-text extends Component
{
    public $id;
    public $name;
    public $label;
    public $value;
    public $type;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $label, $id, $value, $type)
    {
        $this->id = $id;
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input-text');
    }
}
