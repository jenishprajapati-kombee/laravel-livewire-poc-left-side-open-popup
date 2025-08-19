
            <div class="content dashbord-1 d-flex flex-column flex-column-fluid" id="kt_content">

                <div id="kt_app_content_container" class="app-container  container-xxl stepper stepper-pills" id="kt_stepper_example_basic">
                    <div class="">
                        <div class="row">
                                            @if (Gate::allows('view-role'))
                <div class="col-6 col-md-4 xs-mb-15">
                    <a href="/role" wire:navigate class="card hover-elevate-up shadow-sm parent-hover">
                        <div class="card-body d-flex align-items">
                            <i class="las la-2x la-users-cog fs-2"><span class="path1"></span><span class="path2"></span></i>
                            <span class="ms-3 text-gray-700 parent-hover-primary fs-6 fw-bold">
                                @lang('messages.side_menu.role')
                            </span>
                        </div>
                    </a>
                </div>
                @endif
                @if (Gate::allows('view-user'))
                <div class="col-6 col-md-4 xs-mb-15">
                    <a href="/user" wire:navigate class="card hover-elevate-up shadow-sm parent-hover">
                        <div class="card-body d-flex align-items">
                            <i class="las la-2x la-users-cog fs-2"><span class="path1"></span><span class="path2"></span></i>
                            <span class="ms-3 text-gray-700 parent-hover-primary fs-6 fw-bold">
                                @lang('messages.side_menu.user')
                            </span>
                        </div>
                    </a>
                </div>
                @endif
                @if (Gate::allows('view-brand'))
                <div class="col-6 col-md-4 xs-mb-15">
                    <a href="/brand" wire:navigate class="card hover-elevate-up shadow-sm parent-hover">
                        <div class="card-body d-flex align-items">
                            <i class="las la-2x la-users-cog fs-2"><span class="path1"></span><span class="path2"></span></i>
                            <span class="ms-3 text-gray-700 parent-hover-primary fs-6 fw-bold">
                                @lang('messages.side_menu.brand')
                            </span>
                        </div>
                    </a>
                </div>
                @endif
<!-- Dynamic blocks will be inserted here -->
                        </div>
                    </div>
                </div>

            </div>