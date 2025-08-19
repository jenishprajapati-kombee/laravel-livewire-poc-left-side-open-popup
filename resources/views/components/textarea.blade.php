@props(['disabled' => false])

<textarea  {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-control']) !!} style="height: 100px"></textarea>
