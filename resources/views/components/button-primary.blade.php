@props(['disabled' => false, 'type' => 'submit'])

<button {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['type' => $type, 'class' => 'btn btn-primary btn-sm']) }}>
    <span class="indicator-label">{{ $slot }}</span>
</button>
