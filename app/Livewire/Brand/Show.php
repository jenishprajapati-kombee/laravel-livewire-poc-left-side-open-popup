<?php

namespace App\Livewire\Brand;

use App\Models\Brand;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
    public $id;

    public $brand;

    public $event = 'showbrandInfoModal';

    #[On('show-brand-info')]

    /**
     * @return void
     */
    public function show($id)
    {
        $this->brand = null;

        $this->brand = Brand::select(
                'brands.id','brands.name','brands.remark',
                                DB::raw(
                                '(CASE
                                        WHEN brands.status = "'.config("constants.brand.status.key.active").'" THEN  "'.config("constants.brand.status.value.active").'"
                                        WHEN brands.status = "'.config("constants.brand.status.key.inactive").'" THEN  "'.config("constants.brand.status.value.inactive").'"
                                ELSE " "
                                END) AS status')
            )
            
            ->where('brands.id', $id)
            
            ->first();
        

        if (! is_null($this->brand)) {
            $this->dispatch('show-modal', id: '#' . $this->event);
        } else {
            session()->flash('error', __('messages.brand.messages.record_not_found'));
        }
    }

    public function render()
    {
        return view('livewire.brand.show');
    }
}
