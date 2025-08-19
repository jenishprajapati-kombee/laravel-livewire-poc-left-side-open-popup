<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Post-->
    <div class="post sp-data d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card body-->
                <div class="card-body">
                    <x-session-message></x-session-message>
                    <x-export-progress-bar></x-export-progress-bar>
                    <!--begin::Table-->
                    <livewire:role.table />
                    <x-slide-panel />
                    {{-- <livewire:role.show /> --}}
                    <livewire:role.delete />
                    <livewire:common-code />
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>
