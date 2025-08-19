<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
    @if(!empty($segments))
    <!--begin::Title-->
    <h1 class="d-flex align-items-center text-dark fw-bolder fs-5 my-1">{!! isset($segments['title']) ? $segments['title'] : '' !!}</h1>
    <!--end::Title-->
    <!--begin::Separator-->
    <span class="h-20px border-gray-200 mx-1"></span>
    <!--end::Separator-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <span class="fa-solid fa-angle-right"></span>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">{!! isset($segments['item_1']) ? $segments['item_1'] : '' !!}</li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <span class="fa-solid fa-angle-right"></span>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item text-dark">{!! isset($segments['item_2']) ? $segments['item_2'] : '' !!}</li>
        <!--end::Item-->
    </ul>
    <!--end::Breadcrumb-->
    @endif
</div>
