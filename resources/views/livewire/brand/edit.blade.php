<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div id="kt_app_content_container" class="app-container container-xxl stepper stepper-pills" id="kt_stepper_example_basic">
        <div class="row g-5 g-xxl-8">
            <div class="p-0-0">
                <form wire:submit.prevent="store">
                    <div class="card mb-5 mb-xxl-8">
                        <div class="card-body row g-6">
                            <div class="col-md-6">
                                <x-label for="name" value="{{ __('messages.brand.create.label_name') }}" class="required" />
                                <x-input type="text" wire:model="name" id="name" required />
                                <x-input-error for="name" />
                            </div>
                            <div class="col-md-6">
                                <x-label for="remark" value="{{ __('messages.brand.create.label_remark') }}" class="" />
                                <x-input type="text" wire:model="remark" id="remark" />
                                <x-input-error for="remark" />
                            </div>
                            <div class="col-md-6">
                                <x-label for="status" value="{{ __('messages.brand.create.label_status') }}" class="required" />
                                <div class="form-check form-check-custom form-check-solid">
                                    <label class="form-check-label me-3">
                                        <input class="form-check-input me-2" type="radio" wire:model="status" name="status" value="{{ config('constants.brand.status.key.active') }}">
                                        {{ config('constants.brand.status.value.active') }}
                                    </label> <label class="form-check-label me-3">
                                        <input class="form-check-input me-2" type="radio" wire:model="status" name="status" value="{{ config('constants.brand.status.key.inactive') }}">
                                        {{ config('constants.brand.status.value.inactive') }}
                                    </label>
                                </div>
                                <x-input-error for="status" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-5">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h3 class="card-title fw-bold">Add New</h3>
                                    <button type="button" class="btn btn-success btn-custom-class sp-p" wire:click.prevent="add">
                                        <i class="las la-plus fs-1"></i>
                                    </button>
                                </div>

                                <div class="card-body">
                                    @if (!empty($adds))
                                    <div class="accordion" id="accordionTargets">
                                        @foreach ($adds as $index => $add)
                                        @php
                                        $hasError = $errors->getBag('default')->keys()
                                        ? collect($errors->getBag('default')->keys())->contains(
                                        fn($key) => Str::startsWith($key, "adds.$index"),
                                        )
                                        : false;

                                        $shouldShow = $isEdit || $hasError || $index === 0;
                                        @endphp
                                        <div class="accordion-item mb-4 shadow-sm border rounded">
                                            <!-- Accordion Header -->
                                            <h2 class="accordion-header position-relative" id="heading{{ $index }}">
                                                <button class="accordion-button {{ $shouldShow ? '' : 'collapsed' }} bg-light fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $shouldShow ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}">
                                                    Add New {{ $index + 1 }}
                                                </button>

                                                @if ($index > 0)
                                                <button type="button" wire:click.prevent="remove({{ $index }}, {{ $add['id'] ?? 0 }})" class="btn btn-sm btn-icon btn-light-danger position-absolute" style="top: 8px; right: 40px; z-index: 5;" onclick="event.stopPropagation();">
                                                    <i class="las la-trash fs-2"></i>
                                                </button>
                                                @endif
                                            </h2>

                                            <!-- Accordion Body -->
                                            <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $shouldShow ? 'show' : '' }}" aria-labelledby="heading{{ $index }}">
                                                <div class="accordion-body">
                                                    <div class="row g-4">
                                                        <input type="hidden" name="add_id[]" value="{{ $add['id'] }}">
                                                        <div class="col-md-6">
                                                            <x-label for="description_{{$index}}" value="{{ __('messages.brand.create.label_description') }}" class="required" />
                                                            <x-textarea wire:model="adds.{{$index}}.description" id="description_{{$index}}" />
                                                            <x-input-error for="adds.{{$index}}.description" />
                                                        </div>

                                                        <div class="col-md-6">
                                                            <x-file-upload model="adds.{{$index}}.brand_image" label="{{ __('messages.brand.create.label_brand_image') }}" note="Extensions: jpeg, png, jpg, gif, svg | Size: Maximum 4096 KB" classRequired='' />
                                                            @if (!empty($adds[$index]['show_brand_image']))
                                                            <a href="{{ $adds[$index]['show_brand_image'] }}" class="btn btn-info mt-2" target="_blank">
                                                                {{ __('messages.image.view_image') }}
                                                                <i class="las la-file-image fs-4 me-2"></i>
                                                            </a>
                                                            @endif
                                                        </div>


                                                        <div class="col-md-6">
                                                            <x-label for="status_{{$index}}" value="{{ __('messages.brand.create.label_status') }}" class="required" />
                                                            <x-forms.select2 variable="adds.{{$index}}.status" data-placeholder="{{ __('messages.brand.create.label_status') }}">
                                                                <option value=''>{{ __('messages.brand.create.label_status') }}</option>
                                                                <option value="{{ config('constants.brand.status.key.active') }}"> {{ config("constants.brand.status.value.active") }}</option>
                                                                <option value="{{ config('constants.brand.status.key.inactive') }}"> {{ config("constants.brand.status.value.inactive") }}</option>
                                                            </x-forms.select2>
                                                            <x-input-error for="adds.{{$index}}.status" />
                                                        </div>

                                                        <div class="col-md-6">
                                                            <x-label for="bg_color_{{$index}}" value="{{ __('messages.brand.create.label_bg_color') }}" class="required" />
                                                            <x-input type="color" wire:model="adds.{{$index}}.bg_color" class="form-control-color" id="bg_color_{{$index}}" required />
                                                            <x-input-error for="adds.{{$index}}.bg_color" />
                                                        </div>
                                                    </div> <!-- /.row -->
                                                </div> <!-- /.accordion-body -->
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- begin::Action Button -->
                    <div class="col-12 d-grid gap-2 d-md-flex">
                        <x-button-primary wire:loading.attr="disabled">
                            {{ __('messages.update_button_text') }}
                            <x-button-progress-bar wire:loading wire:target='store' />
                        </x-button-primary>

                        <a href="/brand" class="btn btn-secondary btn-sm" wire:navigate>{{ __('messages.cancel_button_text') }}</a>
                    </div>
                    <!-- end::Action Button -->
                </form>
            </div>
        </div>
    </div>
</div>
