<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div id="kt_app_content_container" class="app-container  container-xxl stepper stepper-pills" id="kt_stepper_example_basic">

        <div div class="row g-5 g-xxl-8">
            <div class="p-0-0">
                <form wire:submit="changePassword">
                    <!-- begin::Basic User Details-->
                    <div class="card mb-5 mb-xxl-8">
                        <div class="card-body row g-6">

                            <div class="col-md-8">
                                <x-label for="old_password" value="{{ __('messages.login.label_old_password') }}" />
                                <div x-data="{ passwordVisible: false, old_password: '' }">
                                    <x-input type="passwordVisible ? 'text' : 'password'" name="old_password" id="old_password" :value="old('password')" wire:model.live="old_password" autofocus autocomplete="old_password" required x-bind:type="passwordVisible ? 'text' : 'password'" />
                                    <i :class="passwordVisible ? 'fa fa-fw fa-eye' : 'fa fa-fw fa-eye-slash'" @click="passwordVisible = !passwordVisible" class="toggle-password" style="cursor: pointer;"></i>

                                    <x-input-error for="old_password" />
                                </div>
                            </div>

                            <div class="col-md-8">
                                <x-label for="new_password" value="{{ __('messages.login.label_new_password') }}" />
                                <div x-data="{ passwordVisible: false, new_password: '' }">
                                    <x-input type="passwordVisible ? 'text' : 'password'" name="new_password" id="new_password" :value="old('password')" wire:model.live="new_password" autofocus autocomplete="new_password" required x-bind:type="passwordVisible ? 'text' : 'password'" />
                                    <i :class="passwordVisible ? 'fa fa-fw fa-eye' : 'fa fa-fw fa-eye-slash'" @click="passwordVisible = !passwordVisible" class="toggle-password" style="cursor: pointer;"></i>

                                    <x-input-error for="new_password" />
                                </div>
                            </div>

                            <div class="col-md-8">
                                <x-label for="confirm_password" value="{{ __('messages.login.label_confirm_password') }}" />
                                <div x-data="{ passwordVisible: false, confirm_password: '' }">
                                    <x-input type="passwordVisible ? 'text' : 'password'" name="confirm_password" id="confirm_password" :value="old('password')" wire:model.live="confirm_password" autofocus autocomplete="confirm_password" required x-bind:type="passwordVisible ? 'text' : 'password'" />
                                    <i :class="passwordVisible ? 'fa fa-fw fa-eye' : 'fa fa-fw fa-eye-slash'" @click="passwordVisible = !passwordVisible" class="toggle-password" style="cursor: pointer;"></i>

                                    <x-input-error for="confirm_password" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end::Basic User Details -->

                    <!-- begin::Action Button -->
                    <div class="col-12 d-grid gap-2 d-md-flex">
                        <x-button-primary wire:loading.attr="disabled">
                            {{ __('messages.submit_button_text') }}
                            <x-button-progress-bar wire:loading wire:target='changePassword' />
                        </x-button-primary>
                        <a href="/users" class="btn btn-secondary btn-sm"
                        wire:navigate>{{ __('messages.cancel_button_text') }}</a>

                    </div>
                    <!-- end::Action Button -->
                </form>
            </div>
        </div>
<div class="text-muted copy-login">© {{ date('Y') }} @lang('messages.footer_text')</div>
    </div>
</div>
