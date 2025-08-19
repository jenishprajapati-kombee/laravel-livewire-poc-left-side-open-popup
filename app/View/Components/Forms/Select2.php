<?php

namespace App\View\Components\Forms;


use Illuminate\View\Component;

class select2 extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public string $variable)
    {

    }

    public function render()
    {
        return view('components.forms.select2');
    }
}
