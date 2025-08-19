@extends('components.layout.master')

@section('content')

<!--begin::App-->
<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <!--begin::Wrapper-->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <!--begin::Body-->
        <div class="d-flex flex-column flex-lg-row-fluid w-lg-30 p-10 order-2 v-align login-bg-1">
            <!--begin::Content-->
            <div class="">
                <!--begin::Content-->
                <div class="">
                    <!--begin::Logo-->
                    <a href="/" class="py-9 mb-5" wire:navigate>
                        <img alt="Logo" src="{!! image('logos/eastern_techno_solutions_logo.jpg') !!}" class="h-50-half mob-logo" />
                    </a>
                    <!--end::Logo-->
                    <!--begin::Title-->
                    {{-- <h1 class="fw-bolder fs-2qx pb-5 pb-md-10" style="color: #ffffff;">@lang('messages.login.heading_title')</h1> --}}
                    <!--end::Title-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Body-->
        <!--begin::Aside-->
        {{$slot}}
        <!--end::Aside-->
    </div>
    <!--end::Wrapper-->
</div>
<!--end::App-->

@endsection