@php
    $currentUser = Auth::user(); // Retrieve the authenticated user
@endphp
<div class="app-navbar flex-shrink-0">
    <!--begin::User menu-->
	<div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
        <!--begin::Menu wrapper-->
		<div class="cursor-pointer symbol symbol-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
            @if($currentUser->name)
                <div class="symbol-label fs-3 {{ app(\App\Actions\GetThemeType::class)->handle('bg-light-? text-?', $currentUser->name) }}">
                    {{ substr($currentUser->name, 0, 1) }}
                </div>
            @else
                <img src="{!! asset('assets/media/avatars/blank.png') !!}" alt="user" />
            @endif
        </div>
        @include('partials/menus/_user-account-menu')
        <!--end::Menu wrapper-->
    </div>
    <!--end::User menu-->
	<!--end::Header menu toggle-->
</div>
