<div class="input-group time">
    <input type="text" placeholder="yyyy-mm-dd" {!! $attributes->merge(['class' => 'form-control timepicker']) !!}/>
    <span class="input-group-append" onclick="focusCalendarInput(this)">
        <span class="input-group-text bg-light d-block">
            <i class="fa fa-calendar"></i>
        </span>
    </span>
</div>
