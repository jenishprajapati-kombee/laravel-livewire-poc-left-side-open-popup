<div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2">
    <!--begin::Form-->
    <div class="d-flex flex-center flex-column flex-lg-row-fluid">
    <x-session-message></x-session-message>
        <!--begin::Wrapper-->
        <div class="card w-lg-500px p-10">
            <!--begin::Page-->
            <!--begin::Form-->
            <form class="form w-100" wire:submit="forgotPassword">
                <!--begin::Heading-->
                <div class="text-center mb-10">
                    <!--begin::Title-->
                    <h1 class="text-dark mb-3">@lang('messages.login.forgot_password_title')</h1>
                    <!--end::Title-->
                </div>
                <!--begin::Heading-->

                <!--begin::Input group-->
                <div class="fv-row mb-10">
                    <x-label for="email" value="{{ __('messages.login.label_email') }}" />
                    <x-input type="text" name="email" :value="old('email')" wire:model.live="email" autofocus autocomplete="email" onblur="value=value.trim()" />
                    <x-input-error for="email" />
                </div>
                <!--end::Input group-->
                <!--begin::Actions-->
                <div class="text-center">
                    <!--begin::Submit button-->
                    <x-button-primary class="btn-lg w-100 mb-5" wire:loading.attr="disabled" wire:target='forgotPassword'>
                        {{ __('messages.submit_button_text') }}
                        <x-button-progress-bar wire:loading wire:target='forgotPassword' />
                    </x-button-primary>
                    <!--end::Submit button-->
                </div>
                <div class="forgot-well"><a href="/" wire:navigate>< {{ __('messages.login.label_back_to_login') }}</a></div>
                <!--end::Actions-->
            </form>
            <!--end::Form-->
            <!--end::Page-->
        </div>
        <!--end::Wrapper-->
        <div class="text-muted copy-login">© {{ date('Y') }} @lang('messages.footer_text')</div>
    </div>
    <!--end::Form-->
</div>
