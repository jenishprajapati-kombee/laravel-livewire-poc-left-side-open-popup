@props(['model', 'label', 'note', 'disabled' => false, 'value' => null, 'multiple', 'classRequired' => ''])

<div x-data="{
    uploading: false,
    progress: 0,
    uploadId: '{{ md5($model) }}'
}" class="mb-4">
    @if ($label)
        <label class="form-label fs-6 fw-bolder text-dark {{ $classRequired }}">{{ $label }}</label>
    @endif
    <div class="relative">
        <div class="d-flex align-items-center gap-2">
            <input type="file" class="form-control {{ $disabled ? 'cursor-not-allowed bg-gray-100' : '' }}"
                wire:model="{{ $model }}" x-on:livewire-upload-start="uploading = true"
                x-on:livewire-upload-finish="uploading = false" x-on:livewire-upload-error="uploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress"
                @if ($disabled) disabled @endif wire:loading.attr="disabled">
            @php
                $attachment = $value ?? null;
                $isValidUrl = $attachment && \Illuminate\Support\Str::startsWith($attachment, ['http://', 'https://']);
            @endphp
            @if ($value && $isValidUrl)
                <a href="{{ $value }}" target="_blank" class="btn btn-sm btn-icon btn-light" title="Preview">
                    <i class="fas fa-eye"></i>
                </a>
            @endif
        </div>

        <!-- Progress Bar -->
        <div x-show="uploading" class="mt-2">
            <div class="progress">
                <div class="progress-bar" role="progressbar" x-bind:style="`width: ${progress}%`"
                    x-bind:aria-valuenow="progress" aria-valuemin="0" aria-valuemax="100" x-text="`${progress}%`">
                </div>
            </div>
        </div>
    </div>
    <p>{{ $note }}</p>
    <x-input-error for="{{ $model }}" />
</div>
