@props(['disabled' => false, 'type' => 'text', 'uploadedFile' => null])
@if ($type == 'file')
    <div class="file-input-group">
        <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-control', 'type' => $type]) !!} >
        @if ($uploadedFile)
            <i class="file-clear-icon fa fa-times" title="Clear" wire:click='resetFileValidation'></i>
        @endif
    </div>
@else 
    <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-control', 'type' => $type]) !!} >
@endif