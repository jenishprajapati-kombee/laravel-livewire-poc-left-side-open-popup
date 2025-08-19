@php
$currentUser = Auth::user(); // Retrieve the authenticated user
$getRoleName = App\Helper::getAllRoles()[$currentUser->role_id] ?? null;
@endphp
<!--begin::User account menu-->
<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <div class="menu-content d-flex align-items-center px-3">
            <!--begin::Avatar-->
            <div class="symbol symbol-50px me-5">
                @if($currentUser->name)
                <div class="symbol-label fs-3 {{ app(\App\Actions\GetThemeType::class)->handle('bg-light-? text-?', $currentUser->name) }}">
                    {{ substr($currentUser->name, 0, 1) }}
                </div>
                @else
                <img src="{!! asset('assets/media/avatars/blank.png') !!}" alt="user" />
                @endif
            </div>
            <!--end::Avatar-->
            <!--begin::Username-->
            <div class="d-flex flex-column">
                <div class="fw-bold d-flex align-items-center fs-5">
                    {{ $currentUser->name}}
                </div>

                @if ($getRoleName)
                <p class="word-break fw-semibold text-muted text-hover-primary fs-7">{{ $getRoleName }}</p>
                @endif

                <p class="word-break fw-semibold text-muted text-hover-primary fs-7">{{ $currentUser->email }}</p>
            </div>
            <!--end::Username-->
        </div>
    </div>
    <!--end::Menu item-->

    <!--begin::Menu separator-->
    <div class="separator my-2"></div>
    <!--end::Menu separator-->

    <!--begin::Menu item-->
    {{-- <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
        <a href="#" class="menu-link px-5">
			<span class="menu-title position-relative">Mode
			<span class="ms-5 position-absolute translate-middle-y top-50 end-0">{!! getIcon('night-day', 'theme-light-show fs-2') !!} {!! getIcon('moon', 'theme-dark-show fs-2') !!}</span></span>
		</a>
		@include('partials/theme-mode/__menu')
	</div> --}}
    <!--end::Menu item-->

    {{-- <div class="menu-item px-5">
        <a href="/role" wire:navigate class="menu-link px-5">
            Role
        </a>
    </div> --}}

    @if($currentUser->role_id == config('constants.roles.admin'))
    <div class="menu-item px-5">
        <a href="{{ route('permission') }}" wire:navigate class="menu-link px-5">
            @lang('messages.side_menus.label_permission')
        </a>
    </div>

    <!--begin::Menu separator-->
    <div class="separator my-2"></div>
    <!--end::Menu separator-->
    @endif


    @auth
    <div class="menu-item px-5">
        <a class="menu-link" href="/change-password" wire:navigate>
            <span class="menu-title">@lang('messages.side_menus.label_change_password')</span>
        </a>
    </div>
    <!--begin::Menu separator-->
    <div class="separator my-2"></div>
    <!--end::Menu separator-->
    <div class="menu-item px-5">
        <a class="menu-link" href="/roles" wire:navigate>
            <span class="menu-title">@lang('messages.side_menus.label_role')</span>
        </a>
    </div>
    <!--begin::Menu separator-->
    <div class="separator my-2"></div>
    <!--end::Menu separator-->


    <!--begin::Menu item-->
    <div class="menu-item px-5">
        <livewire:auth.logout />
    </div>
    <!--end::Menu item-->
    @endauth
    <!--begin::Menu separator-->
    {{-- <div class="separator my-2"></div>
    <!--end::Menu separator-->
    <!--begin::Menu item-->
    <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
        <a href="#" class="menu-link px-5">
			<span class="menu-title position-relative">Mode
			<span class="ms-5 position-absolute translate-middle-y top-50 end-0">{!! getIcon('night-day', 'theme-light-show fs-2') !!} {!! getIcon('moon', 'theme-dark-show fs-2') !!}</span></span>
		</a>
		@include('partials/theme-mode/__menu')
	</div> --}}
    <!--end::Menu item-->
</div>
<!--end::User account menu-->
