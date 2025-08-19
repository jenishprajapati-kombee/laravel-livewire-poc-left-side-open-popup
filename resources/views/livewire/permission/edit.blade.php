<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div id="kt_app_content_container" class="app-container  container-xxl stepper stepper-pills"
        id="kt_stepper_example_basic">
        <div class="card">
            <!--begin::Content-->
            <div id="kt_account_settings_deactivate" class="collapse show">
                <!--begin::Card body-->
                <div class="card-body row g-6">
                    <div class="col-md-12">
                        <x-label class="required" for="dlt_message_id"
                            value="{{ __('messages.permission.edit.label_role') }}" />
                        <x-forms.select2 variable="$role"
                            data-placeholder="{{ __('messages.permission.edit.placeholder_role') }}">
                            <option value="">@lang('messages.permission.edit.placeholder_role')</option>
                            @foreach ($roles as $i => $role)
                                <option value="{{ $i }}">
                                    {{ ucwords(strtolower($role)) }}
                                </option>
                            @endforeach
                        </x-forms.select2>
                        <x-input-error for="role" />
                    </div>
                </div>
                <!--begin::Menu separator-->
                <div class="separator my-2"></div>
                <!--end::Menu separator-->

                <div class="card-body role-permission-1 row g-6">
                    @if (!empty($getAllPermissions) && $showAllPermissions)
                        <div class="col-md-12">
                            <form class="form">
                                <!--begin::Accordion-->
                                <div class="accordion accordion-icon-toggle" id="kt_accordion_2">
                                    <!--begin::Item-->
                                    @foreach ($getAllPermissions as $permission)
                                        <div class="mb-5">
                                            <!--begin::Header-->
                                            <div class="accordion-header py-3 d-flex justify-content-between collapsed"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#kt_accordion_2_item_{{ $permission['id'] }}">
                                                <h3 class="fs-4 fw-semibold mb-0 ms-4">{{ $permission['label'] }}</h3>
                                                <span class="accordion-icon">
                                                    <i class="ki-duotone ki-arrow-right fs-4">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </span>
                                            </div>
                                            <!--end::Header-->

                                            <!--begin::Body-->
                                            @if (!empty($permission['sub_permissions']))
                                                <div id="kt_accordion_2_item_{{ $permission['id'] }}"
                                                    class="fs-6 collapse ps-6 {{ $permission['id'] == $rootPermissionId ? 'show' : '' }}" data-bs-parent="#kt_accordion_2">
                                                    <div class="form-group">
                                                        <div class="col-form-label">
                                                            <div class="checkbox-inline mb-3">
                                                                <div class="row">
                                                                    @foreach ($permission['sub_permissions'] as $index => $subPermission)
                                                                        <div class="col-12 col-sm-12 col-md-3 col-lg-3">
                                                                            <div
                                                                                class="d-flex align-items-center form-check-label mb-4">
                                                                                <div
                                                                                    class="pe-4 form-check form-check-custom form-check-solid">
                                                                                    <input class="form-check-input"
                                                                                        value="{{ $subPermission['id']}}"
                                                                                        type="checkbox"
                                                                                        {{ $subPermission['is_permission'] ? 'checked' : '' }}
                                                                                        wire:click="setUnsetPermission({{ $subPermission['id']}}, $event.target.checked, {{ $permission['id'] }})"
                                                                                        >
                                                                                </div>
                                                                                <div>{{ $subPermission['label'] }}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <!--end::Body-->
                                        </div>
                                    @endforeach
                                    <!--end::Item-->
                                </div>
                                <!--end::Accordion-->
                            </form>
                        </div>
                    @endif
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Content-->
        </div>
    </div>
</div>
