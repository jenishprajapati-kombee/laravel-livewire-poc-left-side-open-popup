<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div id="kt_app_content_container" class="app-container container-xxl stepper stepper-pills" id="kt_stepper_example_basic">
        <div class="row g-5 g-xxl-8">
            <div class="p-0-0">
                <form wire:submit.prevent="store">
                    <div class="card mb-5 mb-xxl-8">
                        <div class="card-body row g-6">
                            <div class="col-md-6">
                                <x-label for="name" value="{{ __('messages.user.create.label_name') }}" class="required" />
                                <x-input type="text" wire:model="name" id="name" required />
                                <x-input-error for="name" />
                            </div>
                            <div class="col-md-6">
                                <x-label for="email" value="{{ __('messages.user.create.label_email') }}" class="required" />
                                <x-input type="email" wire:model="email" id="email" required />
                                <x-input-error for="email" />
                            </div>
                            <div class="col-md-6">
                                <x-label for="role_id" value="{{ __('messages.user.create.label_roles') }}" class="required" />
                                <x-forms.select2 variable="$role_id" data-placeholder="{{ __('messages.user.create.label_roles') }}">
                                    <option value=''>{{ __('messages.user.create.label_roles') }}</option>
                                    @if (!empty($roles))
                                    @foreach ($roles as $value)
                                    <option value="{{ $value->id}}">{{$value->name}}</option>
                                    @endforeach
                                    @endif
                                </x-forms.select2>
                                <x-input-error for="role_id" />
                            </div>
                            <div class="col-md-6">
                                <x-label for="dob" value="{{ __('messages.user.create.label_dob') }}" class="required" />
                                <x-date-picker wire:model="dob" id="dob" />
                                <x-input-error for="dob" />
                            </div>
                            <div class="col-md-6">
                                <x-file-upload model="profile_image" label="{{ __('messages.user.create.label_profile') }}" note="Extensions: jpeg, png, jpg, gif, svg | Size: Maximum 4096 KB" classRequired='' />
                                {!! isset($user) && $user->profile != ''
                                ? '<a href="' . $user->profile . '" class="btn btn-info mt-2" target="_blank">'
                                    . __('messages.image.view_image') .
                                    ' <i class="las la-file-image fs-4 me-2"></i></a>'
                                : ''
                                !!}
                            </div>
                            <div class="col-md-6">
                                <x-label for="country_id" value="{{ __('messages.user.create.label_countries') }}" class="required" />
                                <x-forms.select2 variable="$country_id" id="country" data-placeholder="{{ __('messages.user.create.label_countries') }}">
                                    <option value=''>{{ __('messages.user.create.label_countries') }}</option>
                                    @if (!empty($countries))
                                    @foreach ($countries as $value)
                                    <option value="{{ $value->id}}">{{$value->name}}</option>
                                    @endforeach
                                    @endif
                                </x-forms.select2>
                                <x-input-error for="country_id" />
                            </div>
                            <div class="col-md-6">
                                <x-label for="state_id" value="{{ __('messages.user.create.label_states') }}" class="required" />
                                <x-forms.select2 variable="$state_id" id="state" data-placeholder="{{ __('messages.user.create.label_states') }}">
                                    <option value=''>{{ __('messages.user.create.label_states') }}</option>
                                    @if (!empty($states))
                                    @foreach ($states as $value)
                                    <option value="{{ $value->id}}">{{$value->name}}</option>
                                    @endforeach
                                    @endif
                                </x-forms.select2>
                                <x-input-error for="state_id" />
                            </div>
                            <div class="col-md-6">
                                <x-label for="city_id" value="{{ __('messages.user.create.label_cities') }}" class="required" />
                                <x-forms.select2 variable="$city_id" data-placeholder="{{ __('messages.user.create.label_cities') }}">
                                    <option value=''>{{ __('messages.user.create.label_cities') }}</option>
                                    @if (!empty($cities))
                                    @foreach ($cities as $value)
                                    <option value="{{ $value->id}}">{{$value->name}}</option>
                                    @endforeach
                                    @endif
                                </x-forms.select2>
                                <x-input-error for="city_id" />
                            </div>
                            <div class="col-md-6">
                                <x-label for="gender" value="{{ __('messages.user.create.label_gender') }}" class="required" />
                                <div class="form-check form-check-custom form-check-solid">
                                    <label class="form-check-label me-3">
                                        <input class="form-check-input me-2" type="radio" wire:model="gender" name="gender" value="{{ config('constants.user.gender.key.female') }}">
                                        {{ config('constants.user.gender.value.female') }}
                                    </label> <label class="form-check-label me-3">
                                        <input class="form-check-input me-2" type="radio" wire:model="gender" name="gender" value="{{ config('constants.user.gender.key.male') }}">
                                        {{ config('constants.user.gender.value.male') }}
                                    </label>
                                </div>
                                <x-input-error for="gender" />
                            </div>
                            <div class="col-md-6">
                                <x-label for="status" value="{{ __('messages.user.create.label_status') }}" class="required" />
                                <div class="form-check form-check-custom form-check-solid">
                                    <label class="form-check-label me-3">
                                        <input class="form-check-input me-2" type="radio" wire:model="status" name="status" value="{{ config('constants.user.status.key.active') }}">
                                        {{ config('constants.user.status.value.active') }}
                                    </label> <label class="form-check-label me-3">
                                        <input class="form-check-input me-2" type="radio" wire:model="status" name="status" value="{{ config('constants.user.status.key.inactive') }}">
                                        {{ config('constants.user.status.value.inactive') }}
                                    </label>
                                </div>
                                <x-input-error for="status" />
                            </div>
                            <div class="col-md-6">
                                <x-label for="sort_order" value="{{ __('messages.user.create.label_sort_order') }}" class="required" />
                                <x-input type="text" wire:model="sort_order" id="sort_order" required />
                                <x-input-error for="sort_order" />
                            </div>
                        </div>
                    </div>

                    <!-- begin::Action Button -->
                    <div class="col-12 d-grid gap-2 d-md-flex">
                        <x-button-primary wire:loading.attr="disabled">
                            {{ __('messages.update_button_text') }}
                            <x-button-progress-bar wire:loading wire:target='store' />
                        </x-button-primary>

                        <a href="/user" class="btn btn-secondary btn-sm" wire:navigate>{{ __('messages.cancel_button_text') }}</a>
                    </div>
                    <!-- end::Action Button -->
                </form>
            </div>
        </div>
    </div>
</div>
