<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Post-->
    <div class="post sp-data d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!-- begin::Bulk Upload File -->
            <div class="card mb-5 mb-xxl-8">
                <livewire:dropzone-component :importData="$importData" />
            </div>
            <!-- end::Bulk Upload File-->
            <!--begin::Card-->
            <div class="card">
                <x-session-message></x-session-message>
                <!--begin::Card body-->
                <div class="card-body">
                    <!--begin::Table-->
                    <livewire:brand.import.import-table>
                        <!--end::Table-->
                        <livewire:brand.import.import-error-page />
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>
