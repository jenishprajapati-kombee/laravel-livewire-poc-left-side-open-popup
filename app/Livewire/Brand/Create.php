<?php
namespace App\Livewire\Brand;

use App\Livewire\Breadcrumb;
use App\Models\Brand;
use App\Models\BrandDetail;
use App\Traits\Mailable;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use Mailable, WithFileUploads;

    public $id;
    public $name;
    public $remark;
    public $status;
    public $adds   = [];
    public $newAdd = [
        'description'      => '',
        'status'           => '',
        'brand_image'      => '',
        'show_brand_image' => '',
        'bg_color'         => '',
        'id'               => 0,
    ];
    public $isEdit = false;

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
        /* begin::Set breadcrumb */
        $segmentsData = [
            'title'  => __('messages.brand.breadcrumb.title'),
            'item_1' => '<a href="/brand" class="text-muted text-hover-primary" wire:navigate>' . __('messages.brand.breadcrumb.brand') . '</a>',
            'item_2' => __('messages.brand.breadcrumb.create'),
        ];
        $this->dispatch('breadcrumbList', $segmentsData)->to(Breadcrumb::class);
        /* end::Set breadcrumb */

        $this->adds[] = $this->newAdd;
    }

    public function rules()
    {
        $rules = [
            'name'   => 'required|max:191',
            'remark' => 'nullable',
            'status' => 'required|in:Y,N',
        ];
        foreach ($this->adds as $index => $add) {
            $rules["adds.$index.description"] = "required";
            $rules["adds.$index.status"]      = "required|in:Y,N";
            $rules["adds.$index.brand_image"] = "required|image|mimes:jpeg,png,jpg,gif,svg|max:4096";
            $rules["adds.$index.bg_color"]    = "required|max:191";

        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'   => __('messages.brand.validation.messsage.name.required'),
            'name.max'        => __('messages.brand.validation.messsage.name.max'),
            'status.required' => __('messages.brand.validation.messsage.status.required'),
            'status.in'       => __('messages.brand.validation.messsage.status.in'),
        ];
    }

    public function store()
    {
        $this->validate();

        $data = [
            'name'   => $this->name,
            'remark' => $this->remark,
            'status' => $this->status,
        ];
        if (! empty($data)) {
            $brand = Brand::create($data);
        }

        foreach ($this->adds as $add) {
            $BrandDetailId   = $add["id"] ?? 0;
            $BrandDetailInfo = BrandDetail::find($BrandDetailId);
            $BrandDetailData = [
                'description' => $add['description'],
                'status'      => $add['status'],
                'bg_color'    => $add['bg_color'],
                'brand_id'    => $brand->id,
            ];
            if ($BrandDetailInfo) {
                BrandDetail::where("id", $BrandDetailId)->update($BrandDetailData);
            } else {
                $BrandDetailInfo = BrandDetail::create($BrandDetailData);
            }

            if (! empty($add["brand_image"])) {
                $realPath     = "branddetail/" . $BrandDetailInfo->id . "/";
                $resizedImage = BrandDetail::resizeImages($add["brand_image"], $realPath, true);
                $imagePath    = $realPath . pathinfo($resizedImage["image"], PATHINFO_BASENAME);
                $BrandDetailInfo->update(["brand_image" => $imagePath]);
            }

        }

        session()->flash('success', __('messages.brand.messages.success'));
        return $this->redirect('/brand', navigate: true); // redirect to brand listing page
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.brand.create')->title(__('messages.meta_title.create_brand'));
    }

    public function add()
    {
        if (count($this->adds) < 5) {
            $this->adds[] = $this->newAdd;
        } else {
            $this->dispatch('alert', type: 'error', message: __('messages.maximum_record_limit_error'));
        }
    }

    public function remove($index, $id)
    {
        if ($id != 0) {
            BrandDetail::where('id', $id)->forceDelete();
        }
        unset($this->adds[$index]);
        $this->adds = array_values($this->adds);
    }
}
