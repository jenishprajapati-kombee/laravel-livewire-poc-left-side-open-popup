@php
    $class = 'form-select custom-select2';
@endphp

@error($variable)
  @php
      $class .= 'border-danger';
  @endphp
@enderror

<select data-control="select2"  {{  $attributes->merge(['class' => $class]) }} wire:model="{{  str_replace('$','', $variable)  }}" data-livewire="@this">
    {{ $slot }}
</select>
