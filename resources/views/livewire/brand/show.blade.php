<div>
    <x-show-info-modal modalTitle="{{ __('messages.brand.show.label_brand') }}" :eventName="$event">
        <div class="col-lg-12">
            <div class="card-xl-stretch-1 mb-4">
                <div>
                        <x-show-info key="{{ __('messages.brand.show.details.name') }}" value="{{ !is_null($brand) ? $brand->name : '-' }}" /><hr>
                             <x-show-info key="{{ __('messages.brand.show.details.remark') }}" value="{{ !is_null($brand) ? $brand->remark : '-' }}" /><hr>
                             <x-show-info key="{{ __('messages.brand.show.details.status') }}" value="{{ !is_null($brand) ? $brand->status : '-' }}" /><hr>
                </div>
            </div>
        </div>
    </x-show-info-modal>
</div>
