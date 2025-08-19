<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div id="kt_app_content_container" class="app-container container-xxl stepper stepper-pills" id="kt_stepper_example_basic">
        <div class="row g-5 g-xxl-8">
            <div class="p-0-0">
                <form wire:submit.prevent="store">
                    <div class="card mb-5 mb-xxl-8">
                        <div class="card-body row g-6">
                            <div class="col-md-6">
                                <x-label for="name" value="{{ __('messages.role.create.label_name') }}" class="required" />
                                <x-input type="text" wire:model="name" id="name" required />
                                <x-input-error for="name" />
                            </div>
                            <div class="col-md-6">
                                <x-label for="bg_color" value="{{ __('messages.role.create.label_bg_color') }}" class="required" />
                                <x-input type="color" wire:model="bg_color" class="form-control-color" id="bg_color" />
                                <x-input-error for="bg_color" />
                            </div>
                        </div>
                    </div>

                    <!-- begin::Action Button -->
                    <div class="col-12 d-grid gap-2 d-md-flex">
                        <x-button-primary wire:loading.attr="disabled">
                            {{ __('messages.update_button_text') }}
                            <x-button-progress-bar wire:loading wire:target='store' />
                        </x-button-primary>

                        <a href="/role" class="btn btn-secondary btn-sm" wire:navigate>{{ __('messages.cancel_button_text') }}</a>
                    </div>
                    <!-- end::Action Button -->
                </form>
            </div>
        </div>
    </div>
</div>
