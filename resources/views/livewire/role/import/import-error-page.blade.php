<div>
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="importErrorShowModal" tabindex="-1" role="dialog" aria-labelledby="importErrorShowModal" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-630px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>{{ __('messages.role.import_error_title') }}</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->

                <div class="card card-flush pt-3 overflow-auto" style="max-height:500px;">
                    <div class="card card-flush pt-3">
                        <div class="card-body pt-0">
                            <!--begin::Table wrapper-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <div id="kt_subscription_products_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <div class="table-responsive">
                                        @if ($errorLogs)
                                        <table class="table align-middle table-row-dashed fs-6 fw-semibold gy-4 dataTable no-footer" id="kt_subscription_products_table">
                                            <thead>
                                                <tr class="text-start text-muted fw-bold fs-7 text-capitalize gs-0">
                                                    <th>
                                                        <h6>@lang('messages.role.import_error.header_one')</h6>
                                                    </th>
                                                    <th>
                                                        <h6>@lang('messages.role.import_error.header_two')</h6>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-gray-600">
                                                @foreach($errorLogs as $eLog)
                                                <tr class="odd">
                                                    <td>{{ $eLog->row }}</td>
                                                    <td>
                                                        @foreach($eLog->error as $err)
                                                        <p> {{ $err}} </p>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @endif
                                    </div>
                                </div>
                                <!--end::Table-->
                            </div>
                            <!--end::Table wrapper-->
                        </div>
                    </div>
                </div>

            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
</div>
