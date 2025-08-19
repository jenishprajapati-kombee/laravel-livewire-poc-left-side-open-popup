<?php

namespace App\Livewire\Brand;

use App\Livewire\Breadcrumb;
use Livewire\Component;

class Index extends Component
{
    public function __construct()
    {
        // Init layout file
        app(config('settings.KT_THEME_BOOTSTRAP.default'))->init();
    }

    /**
     * @return void
     */
    public function mount()
    {
        /* Set breadcrumb */
        $segmentsData = [
            'title' => __('messages.brand.breadcrumb.title'),
            'item_1' => __('messages.brand.breadcrumb.brand'),
            'item_2' => __('messages.brand.breadcrumb.list'),
        ];
        $this->dispatch('breadcrumbList', $segmentsData)->to(Breadcrumb::class);
    }

    /**
     * @return mixed
     */
    public function render()
    {
        return view('livewire.brand.index')->title(__('messages.meta_title.index_brand'));
    }
}
