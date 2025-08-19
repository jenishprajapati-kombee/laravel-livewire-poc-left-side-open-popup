@props(['placeholder' => ''])
<div class="powergrid-column-search">
    <input class="form-control" {{ $attributes->get('inputAttributes')->merge(['placeholder' => $placeholder]) }}>
    <i class="input-search-icon fa fa-search"></i>
</div>
