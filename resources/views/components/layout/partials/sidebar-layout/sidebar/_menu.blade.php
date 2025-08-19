<!--begin::sidebar menu-->
<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
    <!--begin::Menu wrapper-->
    <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
        <!--begin::Menu-->
        <div class="menu menu-column menu-rounded menu-sub-indention px-3 fw-semibold fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">

            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link {{ request()->is('dashboard') ? 'active' : '' }}" href="/dashboard" wire:navigate>
                    <span class="menu-icon">
                        <i class="las la-clock la-2x fs-2"></i>
                    </span>
                    <span class="menu-title">@lang('messages.side_menus.dashboard')</span>
                </a>
                <!--end:Menu link-->
            </div>
            @if (Gate::allows('view-role'))

            <div class='menu-item'>
                <a class='menu-link sidebar-menu-link {{ request()->is('role') ? 'active' : '' }}' href='/role' wire:navigate>
                    <span class='menu-icon'>
                        <i class='las la-2x la-gift fs-2'></i>
                    </span>
                    <span class='menu-title'>@lang('messages.side_menu.role')</span>
                </a>
            </div>
@endif
@if (Gate::allows('view-user'))

            <div class='menu-item'>
                <a class='menu-link sidebar-menu-link {{ request()->is('user') ? 'active' : '' }}' href='/user' wire:navigate>
                    <span class='menu-icon'>
                        <i class='las la-2x la-gift fs-2'></i>
                    </span>
                    <span class='menu-title'>@lang('messages.side_menu.user')</span>
                </a>
            </div>
@endif
@if (Gate::allows('view-brand'))

            <div class='menu-item'>
                <a class='menu-link sidebar-menu-link {{ request()->is('brand') ? 'active' : '' }}' href='/brand' wire:navigate>
                    <span class='menu-icon'>
                        <i class='las la-2x la-gift fs-2'></i>
                    </span>
                    <span class='menu-title'>@lang('messages.side_menu.brand')</span>
                </a>
            </div>
@endif

            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                <span class="menu-link">
                    <span class="menu-icon">
                        <i class="las la-2x la-history fs-2"></i>
                    </span>
                    <span class="menu-title">@lang('messages.side_menus.user_import')</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    @if (Gate::allows('import-role'))

            <div class='menu-item'>
                <a class='menu-link sidebar-menu-link {{ request()->is('role-imports') ? 'active' : '' }}' href='/role-imports' wire:navigate>
                    <span class='menu-icon'>
                        <i class='las la-2x la-gift fs-2'></i>
                    </span>
                    <span class='menu-title'>@lang('messages.side_menu.role')</span>
                </a>
            </div>
@endif
@if (Gate::allows('import-user'))

            <div class='menu-item'>
                <a class='menu-link sidebar-menu-link {{ request()->is('user-imports') ? 'active' : '' }}' href='/user-imports' wire:navigate>
                    <span class='menu-icon'>
                        <i class='las la-2x la-gift fs-2'></i>
                    </span>
                    <span class='menu-title'>@lang('messages.side_menu.user')</span>
                </a>
            </div>
@endif
@if (Gate::allows('import-brand'))

            <div class='menu-item'>
                <a class='menu-link sidebar-menu-link {{ request()->is('brand-imports') ? 'active' : '' }}' href='/brand-imports' wire:navigate>
                    <span class='menu-icon'>
                        <i class='las la-2x la-gift fs-2'></i>
                    </span>
                    <span class='menu-title'>@lang('messages.side_menu.brand')</span>
                </a>
            </div>
@endif
                </div>
            </div>
            <!--end:Menu item-->
        </div>
        <!--end::Menu-->
    </div>
    <!--end::Menu wrapper-->
</div>
<!--end::sidebar menu-->
