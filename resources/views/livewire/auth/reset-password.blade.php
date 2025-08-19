<div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2">
    <!--begin::Form-->
    <div class="d-flex flex-center flex-column flex-lg-row-fluid">
        <!--begin::Wrapper-->
        <div class="w-lg-500px p-10 b-shadow">
            <!--begin::Page-->
            <!--begin::Form-->
            <form class="form w-100" wire:submit="resetPassword">
                <input type="hidden" wire:model="token">
                <!--begin::Heading-->
                <div class="text-center mb-10">
                    <!--begin::Title-->
                    <h1 class="text-dark mb-3">@lang('messages.login.reset_passowrd')</h1>
                    <!--end::Title-->
                </div>
                <!--begin::Heading-->

                <!--begin::Input group-->
                <div class="fv-row mb-10">
                    <x-label for="email" value="{{ __('messages.login.label_email') }}" />
                    <x-input type="text" name="email" :value="old('email')" wire:model.live="email" autofocus autocomplete="email" onblur="value=value.trim()" />
                    <x-input-error for="email" />
                </div>

                <div class="fv-row mb-10">
                    <x-label for="password" value="{{ __('messages.login.label_password') }}" />
                    <div x-data="{ passwordVisible: false, password: '' }">
                        <x-input type="passwordVisible ? 'text' : 'password'" name="password" id="password" :value="old('password')" wire:model.live="password" autofocus autocomplete="password" required x-bind:type="passwordVisible ? 'text' : 'password'" />
                        <i :class="passwordVisible ? 'fa fa-fw fa-eye' : 'fa fa-fw fa-eye-slash'" @click="passwordVisible = !passwordVisible" class="toggle-password" style="cursor: pointer;"></i>

                        <x-input-error for="password" />
                    </div>
                </div>

                <div class="fv-row mb-10">
                    <x-label for="password_confirmation" value="{{ __('messages.login.label_confirm_password') }}" />
                    <div x-data="{ passwordVisible: false, password_confirmation: '' }">
                        <x-input type="passwordVisible ? 'text' : 'password'" name="password_confirmation" id="password_confirmation" :value="old('password')" wire:model.live="password_confirmation" autofocus autocomplete="password_confirmation" required x-bind:type="passwordVisible ? 'text' : 'password'" />
                        <i :class="passwordVisible ? 'fa fa-fw fa-eye' : 'fa fa-fw fa-eye-slash'" @click="passwordVisible = !passwordVisible" class="toggle-password" style="cursor: pointer;"></i>

                        <x-input-error for="password_confirmation" />
                    </div>
                </div>

        <!--end::Input group-->
        <!--begin::Actions-->
        <div class="text-center">
            <!--begin::Submit button-->
            <x-button-primary class="btn-lg w-100 mb-5" wire:loading.attr="disabled" wire:target='resetPassword'>
                {{ __('messages.reset_password_button_text') }}
                <x-button-progress-bar wire:loading wire:target='resetPassword' />
            </x-button-primary>
            <!--end::Submit button-->
        </div>
        <!--end::Actions-->
        </form>
        <!--end::Form-->
        <!--end::Page-->
        </div>
    </div>
    <!--end::Wrapper-->
    <div class="text-muted copy-login">© {{ date('Y') }} @lang('messages.footer_text')</div>
</div>
<!--end::Form-->
</div>
