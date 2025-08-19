<?php
namespace App\Livewire\Brand;

use App\Livewire\Breadcrumb;
use App\Models\Brand;
use App\Models\BrandDetail;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public $brand;

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
    public $isEdit = true;

    public function __construct()
    {
        // Init layout file
        app(config('settings.KT_THEME_BOOTSTRAP.default'))->init();
    }

    /**
     * @param  $brand
     * @return void
     */
    public function mount($id)
    {
        /* begin::Set breadcrumb */
        $segmentsData = [
            'title'  => __('messages.brand.breadcrumb.title'),
            'item_1' => '<a href="/brand" class="text-muted text-hover-primary" wire:navigate>' . __('messages.brand.breadcrumb.brand') . '</a>',
            'item_2' => __('messages.brand.breadcrumb.edit'),
        ];
        $this->dispatch('breadcrumbList', $segmentsData)->to(Breadcrumb::class);
        /* end::Set breadcrumb */

        $this->brand = Brand::find($id);

        if ($this->brand) {
            foreach ($this->brand->getAttributes() as $key => $value) {
                $this->{$key} = $value; // Dynamically assign the attributes to the class
            }
        }

        $BrandDetailInfo = BrandDetail::select('description', 'status', 'brand_image', 'bg_color', 'id')->where("brand_id", $id)->get();
        if ($BrandDetailInfo->isNotEmpty()) {
            foreach ($BrandDetailInfo as $index => $addInfo) {
                $this->adds[] = [
                    'description'      => $addInfo->description,
                    'status'           => $addInfo->status,
                    'show_brand_image' => $addInfo->brand_image,
                    'bg_color'         => $addInfo->bg_color,
                    'id'               => $addInfo->id,
                ];
            }
        } else {
            $this->adds = [$this->newAdd];
        }
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
            $rules["adds.$index.brand_image"] = "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096";
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
            $this->brand->update($data); // Update data into the DB
        }

        foreach ($this->adds as $add) {
            $BrandDetailId   = $add["id"] ?? 0;
            $BrandDetailInfo = BrandDetail::find($BrandDetailId);
            $BrandDetailData = [
                'description' => $add['description'],
                'status'      => $add['status'],
                'bg_color'    => $add['bg_color'],
                'brand_id'    => $this->brand->id,
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

        session()->flash('success', __('messages.brand.messages.update'));
        return $this->redirect('/brand', navigate: true); // redirect to brand listing page
    }

    // Dynamic deletion method
    #[On('deleteImageConfirmed')]
    public function deleteImage($model, $imageId, $imagePath, $getVariableName, $parentColumnName)
    {
        $modelClass = "\App\Models\\" . $model;

        // Dynamically resolve the model and find the record
        $getData = $modelClass::find($imageId);

        if ($getData) {
            // Delete the image file from the storage
            Storage::disk('public')->delete($imagePath);

            // Delete the record from the database
            $getData->delete();

            // Refresh the gallery/pictures
            $this->$getVariableName = $modelClass::where($parentColumnName, $this->user->id)->get();

            session()->flash('success', __('messages.brand.messages.image_delete'));
        }
    }

    public function render()
    {
        return view('livewire.brand.edit')->title(__('messages.meta_title.edit_brand'));
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
