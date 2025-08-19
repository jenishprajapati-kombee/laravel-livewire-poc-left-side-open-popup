<?php
namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class SlidePanelLoader extends Component
{
    public $componentName = null;
    public $params        = [];

    #[On('loadSlideComponent')]
    public function loadSlideComponent($component, $params)
    {
        $this->componentName = $component;
        $this->params        = $params;
    }

    public function render()
    {
        return view('livewire.slide-panel-loader');
    }
}
