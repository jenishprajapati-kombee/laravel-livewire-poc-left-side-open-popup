<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" {!! printHtmlAttributes('html') !!}>
<!--begin::Head-->

<head>
    <base href="" />
    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="" />
    <link rel="canonical" href="" />

    {!! includeFavicon() !!}

    <!--begin::Fonts-->
    {!! includeFonts() !!}
    <!--end::Fonts-->

    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    {{-- @if (Route::current()->uri != '/')  --}}
    <link rel="stylesheet" href="{{ asset('assets/livewire-powergrid/bootstrap5.css') }}">
    {{-- @endif --}}
    @foreach (getGlobalAssets('css') as $path)
        {!! sprintf('<link rel="stylesheet" href="%s">', asset($path)) !!}
    @endforeach
    <!--end::Global Stylesheets Bundle-->

    <!--begin::Vendor Stylesheets(used by this page)-->
    @foreach (getVendors('css') as $path)
        {!! sprintf('<link rel="stylesheet" href="%s">', asset($path)) !!}
    @endforeach
    <!--end::Vendor Stylesheets-->

    <!--begin::Custom Stylesheets(optional)-->
    @foreach (getCustomCss() as $path)
        {!! sprintf('<link rel="stylesheet" href="%s">', asset($path)) !!}
    @endforeach
    <!--end::Custom Stylesheets-->

    <style>
        /* Add your custom CSS here */
        .ck-editor__editable_inline {
            min-height: 300px;
            /* Set the height here */
        }
    </style>

    <script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    
    @livewireStyles
</head>
<!--end::Head-->

<!--begin::Body-->

<body {!! printHtmlClasses('body') !!} {!! printHtmlAttributes('body') !!}>

    @include('partials/theme-mode/_init')

    @yield('content')

    <!--begin::Javascript-->
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    @foreach (getGlobalAssets() as $path)
        {!! sprintf('<script src="%s"></script>', asset($path)) !!}
    @endforeach
    <!--end::Global Javascript Bundle-->

    <!--begin::Vendors Javascript(used by this page)-->
    @foreach (getVendors('js') as $path)
        {!! sprintf('<script src="%s"></script>', asset($path)) !!}
    @endforeach
    <!--end::Vendors Javascript-->

    <!--begin::Custom Javascript(optional)-->
    @foreach (getCustomJs() as $path)
        {!! sprintf('<script src="%s"></script>', asset($path)) !!}
    @endforeach
    <!--end::Custom Javascript-->
    @stack('scripts')
    <!--end::Javascript-->

    <script>
        document.addEventListener('livewire:initialized', () => {
            let shouldContinue = true;

            const expirationTimeInSeconds = 60; // 1 Minute

            select2Init();
            selectDatePicker();
            selectTimePicker();
            selectDateTimePicker();
            initializeTinyMceEditor();

            window.addEventListener('alert', event => {
                const windowWidth = window.innerWidth || document.documentElement.clientWidth || document
                    .body.clientWidth;
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut",
                    "positionClass": (windowWidth < 768) ? "toastr-top-center" : 'toastr-top-right',
                }
                toastr[event.detail.type](event.detail.message, event.detail.title ?? '');
            });

            window.addEventListener('showAlert', event => {
                Swal.fire({

                        text: event.detail.message ?? '',
                        html: event.detail.badgeName ? `The selected badges <strong>` + event.detail
                            .badgeName +
                            `</strong> are in the badge approval listing. Please take action by <a target="_blank" href="#">clicking here</a>` :
                            '',

                        icon: event.detail.type,
                        buttonsStyling: false,
                        //showCancelButton: true,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: event.detail.buttonColor,
                            //cancelButton: 'btn btn-danger'
                        }
                    })
                    .then((isOkay) => {
                        if (isOkay) {
                            //
                        }
                    });
            })

            Livewire.on('success', (message) => {
                toastr.success(message);
            });

            Livewire.on('error', (message) => {
                toastr.error(message);
            });

            Livewire.on('swal', (message, icon, confirmButtonText) => {
                if (typeof icon === 'undefined') {
                    icon = 'success';
                }
                if (typeof confirmButtonText === 'undefined') {
                    confirmButtonText = 'Ok, got it!';
                }
                Swal.fire({
                    text: message,
                    icon: icon,
                    buttonsStyling: false,
                    confirmButtonText: confirmButtonText,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
            });

            Livewire.on('clearFileInput', function(params) {
                if (params.fileId) {
                    const fileEl = document.getElementById(params.fileId);
                    if (fileEl) {
                        fileEl.value = null;
                    }
                }
            });

            Livewire.on('autoFocusElement', function(params) {
                if (params.elId) {
                    setAutoFocus(params.elId);
                }
            });

            window.addEventListener('show-modal', event => {
                $(event.detail.id).modal('show');
            })

            window.addEventListener('hide-modal', event => {
                $(event.detail.id).modal('hide');
            })

            Livewire.hook('request', ({
                uri,
                options,
                payload,
                respond,
                succeed,
                fail
            }) => {
                // Runs after commit payloads are compiled, but before a network request is sent...

                respond(({
                    status,
                    response
                }) => {
                    // Runs when the response is received...
                    // "response" is the raw HTTP response object
                    // before await response.text() is run...
                })

                succeed(({
                    status,
                    json
                }) => {
                    setTimeout(function() {
                        select2Init();
                        selectDatePicker();
                        initializeTinyMceEditor();
                        selectTimePicker();
                        selectDateTimePicker();
                    }, 5);
                })

                fail(({
                    status,
                    content,
                    preventDefault
                }) => {
                    // Runs when the response has an error status code...
                    // "preventDefault" allows you to disable Livewire's
                    // default error handling...
                    // "content" is the raw response content...
                })
            })

            $(document).mouseup(function(e) {
                let containerClass = ".dropdown-menu";
                $(containerClass).each(function() {
                    var container = $(this);

                    if (!container.is(e.target) && container.has(e.target).length === 0) {
                        container.removeClass('show');
                    }
                });
            });
        });

        document.addEventListener('livewire:navigated', () => {
            selectDatePicker();
            selectTimePicker();
            selectDateTimePicker();
            setTimeout(() => {
                KTComponents.init();
                setActiveMenu();
            }, 500)
            $(".block-unblock-modal").on('click', function(event) {
                setTimeout(() => {
                    const elll = document.getElementById('remark')
                    elll.focus();
                }, 1500)
            });
        });

        function setAutoFocus(elId) {
            setTimeout(() => {
                $(`#${elId}`).focus()
            }, 1500);
        }

        function isMobileNumberValid(event) {
            const input = event.target;
            const inputValue = (input.value + event.key);
            const originalInputValue = (input.value);
            const keyCode = event.keyCode;
            // Allow backspace and arrow keys
            if (keyCode === 8 || keyCode === 9 || keyCode === 13 || (keyCode >= 37 && keyCode <= 40)) {
                return;
            }
            // Check if the input is a digit and meets the other criteria
            if (!/^\d+$/.test(inputValue)) {
                event.preventDefault(); // Prevent the input if criteria are not met
            }
        }

        function setActiveMenu() {
            const currentPath = window.location.pathname.split('/');
            if (currentPath.length > 1) {
                const moduleRoute = currentPath[1];
                $('.sidebar-menu-link').each(function() {
                    const $this = $(this);
                    $this.removeClass('active');
                    if ($this.attr('href') === `/${moduleRoute}`) {
                        $this.addClass('active');
                    }
                });
            }
        }

        function focusCalendarInput(event) {
            $(event).closest('.input-group').find('input').focus();
        }

        function selectDatePicker() {
            flatpickr(".datepicker", {
                // Configure the date picker settings here
                dateFormat: "Y-m-d",
            });
        }

        function selectTimePicker() {
            flatpickr(".timepicker", {
                enableTime: true,
                noCalendar: true,
                enableSeconds: true,
                dateFormat: "H:i:s",
                time_24hr: true,
            });
        }

        function selectDateTimePicker() {
            flatpickr(".datetimepicker", {
                enableTime: true,
                enableSeconds: true, // 🔧 This is required to format as H:i:s
                dateFormat: "Y-m-d H:i:s",
                time_24hr: true,
                minDate: new Date().fp_incr(0),
            });
        }

        function select2Init() {

            $(document).find('.custom-select2').each(function() {

                var option = {
                    with: '100%',
                };

                if ($(this).attr('data-hide-search') === "true") {
                    option.minimumResultsForSearch = -1;
                    option.closeOnSelect = false;

                }

                if ($(this).attr('data-placeholder')) {
                    option.placeholder = $(this).attr('data-placeholder');
                }

                $(this).select2(option).on('change', function(e) {
                    let livewire = $(this).data('livewire');
                    let variable = $(this).attr('wire:model');
                    eval(livewire).set(variable, $(this).val());
                });
            });
        }

        function handleDropdownClick(elId) {
            $('.dropdown-menu').each(function() {
                const $this = $(this);
                if ($this.attr('id') != elId) {
                    $this.removeClass('show');
                }
            });
            $(`#${elId}`).toggleClass("show");
            $(`#${elId}`).css({
                "position": "absolute",
                "inset": "0px 0px auto auto",
                "margin": "0px",
                "transform": "translate3d(-3.2px, 39.2px, 0px)"
            });
        }

        /* Show Alert For Delete Confirmation */
        window.addEventListener('showDeleteConfirmation', event => {
            Swal.fire({
                text: event.detail.message ?? '',
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "{{ __('messages.common_message.delete_confirm_button_text') }}",
                cancelButtonText: "{{ __('messages.common_message.delete_cancel_button_text') }}",
                confirmButtonColor: '#3085d6',
                customClass: {
                    confirmButton: 'btn btn-primary btn-sm', // Add your custom class here
                    cancelButton: 'btn btn-secondary btn-sm' // Optionally add a custom class for the cancel button
                }
            }).then((result) => {
                if (result.value) {
                    Livewire.dispatch('delete-confirmed');
                }
            });
        })

        /* Show Alert For Delete Confirmation */
        window.addEventListener('showMultipleDeleteConfirmation', event => {
            Swal.fire({
                text: event.detail.message ?? '',
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "{{ __('messages.common_message.delete_confirm_button_text') }}",
                cancelButtonText: "{{ __('messages.common_message.delete_cancel_button_text') }}",
                confirmButtonColor: '#3085d6',
                customClass: {
                    confirmButton: 'btn btn-primary btn-sm', // Add your custom class here
                    cancelButton: 'btn btn-secondary btn-sm' // Optionally add a custom class for the cancel button
                }

            }).then((result) => {
                if (result.value) {
                    Livewire.dispatch('multiple-delete-confirmed');
                }
            });
        })

        // Show Alert For Delete Confirmation
        window.addEventListener('showFileDeleteConfirmation', event => {
            Swal.fire({
                text: event.detail.message ?? 'Are you sure you want to delete this image?',
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "{{ __('messages.common_message.delete_confirm_button_text') }}",
                cancelButtonText: "{{ __('messages.common_message.delete_cancel_button_text') }}",
                confirmButtonColor: '#3085d6',
                customClass: {
                    confirmButton: 'btn btn-primary btn-sm', // Add your custom class here
                    cancelButton: 'btn btn-secondary btn-sm' // Optionally add a custom class for the cancel button
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Correct dispatch format: use an object as the payload
                    Livewire.dispatch('deleteImageConfirmed', {
                        model: event.detail.model,
                        imageId: event.detail.imageId,
                        imagePath: event.detail.imagePath,
                        getVariableName: event.detail.getVariableName,
                        parentColumnName: event.detail.parentColumnName,
                    });
                }
            });
        });

        document.addEventListener('livewire:initialized', () => {
            Livewire.on('updateExportProgress', (eventData) => {
                try {
                    const eventObj = JSON.parse(eventData);
                    const exportProgress = eventObj.exportProgress;
                    const waitingMessage = eventObj.waitingMessage;
                    document.getElementById('progressBarDiv').style.display = 'block';
                    document.getElementById('progressBar').style.width = exportProgress + '%';
                    document.getElementById('progressText').textContent = exportProgress + '%';
                    document.getElementById('waitingMessage').textContent = waitingMessage;

                    setTimeout(() => {
                        Livewire.dispatch('showExportProgressEvent', eventData);
                    }, 1000);

                } catch (err) {
                    console.log(err.message);
                }
            });

            Livewire.on('stopExportProgressEvent', () => {
                try {
                    stopExportProgress();

                } catch (err) {
                    console.log(err.message);
                }
            });

            function stopExportProgress() {
                try {
                    document.getElementById('progressBarDiv').style.display = 'none';

                } catch (err) {
                    console.log(err.message);
                }
            }

            Livewire.on('downloadExportFileEvent', (downloadedEventData) => {
                try {
                    downloadExportFile(downloadedEventData);

                } catch (err) {
                    console.log(err.message);
                }
            });

            function downloadExportFile(downloadedData) {
                try {
                    const downloadedObj = JSON.parse(downloadedData);
                    const downloadUrl = downloadedObj.downloadUrl;
                    const downloadFileName = downloadedObj.downloadFileName;

                    const downloadLink = document.createElement('a');
                    downloadLink.href = downloadUrl;
                    downloadLink.download = downloadFileName;
                    document.body.appendChild(downloadLink);
                    downloadLink.click();
                    document.body.removeChild(downloadLink);

                } catch (err) {
                    console.log(err.message);
                }
            }
        });

        function initializeTinyMceEditor() {
            const handleImageUpload = (blobInfo, progress, submitButton) => {
                return new Promise((resolve, reject) => {
                    const xhr = new XMLHttpRequest();
                    xhr.withCredentials = true;
                    
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    if (!csrfToken) {
                        reject('CSRF token not found');
                        return;
                    }
                    
                    xhr.open('POST', '{{ route('uploadEditorFile') }}');
                    xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
                    xhr.setRequestHeader('Accept', 'application/json');
                    
                    const toggleSubmitButton = (disabled) => {
                        if (submitButton) {
                            submitButton.disabled = disabled;
                            submitButton.classList.toggle('disabled', disabled);
                        }
                    };
                    
                    toggleSubmitButton(true);
                    
                    xhr.upload.onprogress = (e) => {
                        progress(e.loaded / e.total * 100);
                    };
                    
                    xhr.onerror = function() {
                        console.error('Upload failed:', xhr.status, xhr.statusText);
                        console.error('Response:', xhr.responseText);
                        reject('Image upload failed. Status: ' + xhr.status);
                    };
                    
                    xhr.onload = function() {
                        if (xhr.status !== 200) {
                            console.error('Upload failed:', xhr.status, xhr.statusText);
                            console.error('Response:', xhr.responseText);
                            reject('HTTP Error: ' + xhr.status);
                            return;
                        }
                        
                        try {
                            const json = JSON.parse(xhr.responseText);
                            console.log('Upload response:', json);
                            if (!json || !json.location) {
                                reject('Invalid JSON response');
                                return;
                            }
                            resolve(json.location);
                        } catch (e) {
                            console.error('JSON parse error:', e);
                            reject('Invalid JSON: ' + xhr.responseText);
                        } finally {
                            toggleSubmitButton(false);
                        }
                    };
                    
                    const formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                    xhr.send(formData);
                });
            };

            const defaultConfig = {
                license_key: 'gpl',
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount advlist code',
                toolbar: 'undo redo | blocks fontfamily fontsize | code | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                height: 400,
                menubar: true,
                branding: false,
                promotion: false,
                relative_urls: false,
                remove_script_host: false,
                convert_urls: false,
                paste_data_images: true,
                automatic_uploads: true,
                file_picker_types: 'image',
                images_upload_url: "{{ route('uploadEditorFile') }}",
                images_upload_credentials: true,
                images_reuse_filename: true,
                images_upload_base_path: '/',
                images_upload_handler: (blobInfo, progress) => handleImageUpload(blobInfo, progress, submitButton)
            };

            document.querySelectorAll('.tinymce-editor').forEach(textarea => {
                const index = textarea.getAttribute('data-index');
                const submitButton = document.querySelector('button[type="submit"]');
                const isReadOnly = textarea.dataset.readonly === 'true';

                tinymce.init({
                    ...defaultConfig,
                    selector: `textarea[data-index="${index}"]`,
                    images_upload_handler: (blobInfo, progress) => handleImageUpload(blobInfo, progress, submitButton),
                    setup: function(editor) {
                        const updateTextarea = () => {
                            textarea.value = editor.getContent();
                            textarea.dispatchEvent(new Event('input'));
                        };

                        editor.on('change keyup', updateTextarea);

                        if (typeof Livewire !== 'undefined') {
                            Livewire.on('contentUpdated', (content) => {
                                if (content) {
                                    editor.setContent(content);
                                }
                            });
                        }

                        if (isReadOnly) {
                            editor.mode.set('readonly');
                        }
                    }
                });
            });
        }

        document.addEventListener('alpine:init', () => {
            Alpine.data('slidePanel', () => ({
                open: false
                , title: ''
                , component: ''
                , params: {}
                , show(title, component, params = {}) {
                    this.title = title;
                    this.component = component;
                    this.params = params;
                    this.open = true;

                    // Tell Livewire to load the component
                    // Tell Livewire to load the component
                    if (typeof Livewire !== 'undefined') {
                        Livewire.dispatch('loadSlideComponent', {
                            component: this.component
                            , params: this.params
                        });
                    }

                    // Trigger KT Drawer open
                    if (typeof KTDrawer !== 'undefined') {
                        const drawer = KTDrawer.getInstance(document.querySelector('#kt_drawer_chat'));
                        drawer.show();
                    }
                }
                , hide() {
                    this.open = false;
                    if (typeof KTDrawer !== 'undefined') {
                        this.title = '';
                        this.component = '';
                        this.params = '';
                        const drawer = KTDrawer.getInstance(document.querySelector('#kt_drawer_chat'));
                        drawer.hide();
                    }
                }
            }));
        });

    </script>

    @livewireScripts

    <script src="{{ asset('assets/livewire-powergrid/powergrid.js') }}"></script>
</body>

</html>
