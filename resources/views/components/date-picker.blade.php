<div class="input-group date">
    <input type="text" placeholder="yyyy-mm-dd" {!! $attributes->merge(['class' => 'form-control datepicker']) !!}/>
    <span class="input-group-append" onclick="focusCalendarInput(this)">
        <span class="input-group-text bg-light d-block">
            <i class="fa fa-calendar"></i>
        </span>
    </span>
</div>
