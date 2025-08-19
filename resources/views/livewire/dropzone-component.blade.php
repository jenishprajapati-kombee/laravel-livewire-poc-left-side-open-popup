<div>
    <div class="card-header">
        <h3 class="card-title"><b>@lang('messages.dropzone.title')</b></h3>
    </div>
    <form>
        <div class="card-body row g-6">
            <div class="col-md-12">
                <div class="fv-row">
                    <!--begin::Dropzone-->
                    <div class="dropzone" id="kt_dropzonejs_example_1">
                        <!--begin::Message-->
                        <div class="dz-message needsclick">
                            <!--begin::Icon-->
                            <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                            <!--end::Icon-->

                            <!--begin::Info-->
                            <div class="ms-4">
                                <h3 class="fs-5 fw-bolder text-gray-900 mb-1">@lang('messages.dropzone.note')</h3>
                                <span class="fs-7 fw-bold text-gray-400">@lang('messages.dropzone.file_type_text')</span>
                            </div>
                            <!--end::Info-->
                        </div>
                    </div>
                    <!--end::Dropzone-->
                </div>
                <p class="mt-2 fw-bold fs-8">@lang('messages.dropzone.upload_record_limit_text')</p>
            </div>
            <div id="flash-message">
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    var myDropzone = new Dropzone("#kt_dropzonejs_example_1", {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        url: "{{ route('uploadFile') }}", // Set the url for your upload script location
        paramName: "file", // The name that will be used to transfer the file
        maxFiles: 1,
        maxFilesize: 10, // MB
        addRemoveLinks: true,
        acceptedFiles: ".csv, text/csv, application/vnd.ms-excel, application/csv, text/x-csv, application/x-csv, text/comma-separated-values, text/x-comma-separated-values",
        init: function() {
            this.on("sending", function (file, xhr, formData) {
                // Add additional form data with each file upload
                formData.append("folderName", '{{ $importData['folderName'] }}');
                formData.append("modelName", '{{ $importData['modelName'] }}');
                formData.append("userId", '{{ $userID }}');
            });

            this.on("error", function (file, response, xhr) {
                // Display the error message to the user
                Livewire.dispatch('alert', { type: 'error', message:  response.error });
            });

            this.on("success", function (file, response, xhr) {
                // Handle the success response here
                this.removeAllFiles();

                // Clear any existing content
                $('#flash-message').empty();
                // Append the message to the element
                $('#flash-message').text(response.success).addClass('col-12 d-grid gap-2 d-md-flex alert alert-success');
                // Set a timeout to remove the message after a specified duration
                setTimeout(function(){
                    $('#flash-message').empty().removeClass();
                }, 10000);
                Livewire.dispatch('pg:eventRefresh-default');
            });
        }
    });
</script>
@endpush