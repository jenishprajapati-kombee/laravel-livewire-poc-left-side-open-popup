<div x-data="slidePanel" @open-slide.window="show($event.detail.title, $event.detail.component, $event.detail.params)"
    id="kt_drawer_chat" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="chat" data-kt-drawer-activate="true"
    data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'300px', 'md': '800px'}" data-kt-drawer-direction="end"
    data-kt-drawer-toggle="#kt_drawer_chat_toggle" data-kt-drawer-close="#kt_drawer_chat_close">

    <div class="card w-100 border-0 rounded-0" id="kt_drawer_chat_messenger">
        <!-- Card header -->
        <div class="card-header pe-5" id="kt_drawer_chat_messenger_header">
            <div class="card-title">
                <div class="d-flex justify-content-center flex-column me-3">
                    <span class="fs-4 fw-bold text-gray-900 me-1 mb-2 lh-1" x-text="title"></span>
                </div>
            </div>
            <div class="card-toolbar">
                <div class="btn btn-sm btn-icon btn-active-color-primary" id="kt_drawer_chat_close" @click="hide()">
                    ✕
                </div>
            </div>
        </div>

        <!-- Card body -->
        <div class="card-body">
            @livewire('slide-panel-loader', key('slide-panel'))
        </div>
    </div>
</div>
