<div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2">
    <!--begin::Form-->
    <div class="d-flex flex-center flex-column flex-lg-row-fluid">
        <!--begin::Wrapper-->
        <div class="card w-lg-500px p-10 b-shadow">
            <!--begin::Page-->
            <!--begin::Form-->
            <form class="form w-100" wire:submit.prevent="login">
            <x-session-message></x-session-message>
                <!--begin::Heading-->
                <div class="text-center mb-10">
                    <!--begin::Title-->
                    <h1 class="text-dark mb-3">@lang('messages.login.title')</h1>
                    <!--end::Title-->
                </div>
                <!--begin::Heading-->

                <!--begin::Input group-->
                <div class="fv-row mb-10">
                    <x-label for="email" value="{{ __('messages.login.label_email') }}" />
                    <x-input type="text" name="email" :value="old('email')" wire:model="email" autofocus autocomplete="email" onblur="value=value.trim()" />
                    <x-input-error for="email" />
                </div>

                <div class="fv-row mb-10">

                    <x-label for="password" value="{{ __('messages.login.label_password') }}" />
                    <div x-data="{ passwordVisible: false, password: '' }">
                        <x-input type="passwordVisible ? 'text' : 'password'" name="password" id="password" :value="old('password')" wire:model="password" autofocus autocomplete="password" required x-bind:type="passwordVisible ? 'text' : 'password'" />
                        <i :class="passwordVisible ? 'fa fa-fw fa-eye' : 'fa fa-fw fa-eye-slash'" @click="passwordVisible = !passwordVisible" class="toggle-password" style="cursor: pointer;"></i>

                        <x-input-error for="password" />
                    </div>
                </div>
                <!--end::Input group-->

                <input type="hidden" id="recaptcha-token" name="recaptcha_token" wire:model="recaptchaToken">

                <!--begin::Actions-->
                <div class="text-center">
                    <!--begin::Submit button-->
                    <x-button-primary class="btn-lg w-100 mb-5 h-45px" id="login-button" wire:loading.attr="disabled" wire:target='login'>
                        {{ __('messages.submit_button_text') }}
                        <x-button-progress-bar wire:loading wire:target='login' />
                    </x-button-primary>
                    <!--end::Submit button-->
                </div>
                <div class="forgot-well text-center"><a href="/forgot-password" wire:navigate>{{ __('messages.login.forgot_password_title') }}</a></div>
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

@push('scripts')
<script src="https://www.google.com/recaptcha/api.js?render={{ config('constants.google_recaptcha_key') }}"></script>
<script>
    $("body").delegate("#login-button", "click", function() {
        event.preventDefault(); // Prevent the form from submitting immediately
        grecaptcha.ready(function() {
            grecaptcha.execute("{{ config('constants.google_recaptcha_key') }}", {
                action: 'login'
            }).then(function(token) {
                @this.set('recaptchaToken', token).then(function() {
                    @this.call('login'); // Call the Livewire method to submit the form
                });
            });
        });
    });
</script>
@endpush
