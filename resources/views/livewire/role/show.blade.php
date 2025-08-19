<div class="col-lg-12">
    <div class="card-xl-stretch-1 mb-4">
        <div>
            <x-show-info key="{{ __('messages.role.show.details.name') }}" value="{{ !is_null($role) ? $role->name : '-' }}" />
            <hr>
            <x-show-info key="{{ __('messages.role.show.details.bg_color') }}" value="{{ !is_null($role) ? $role->bg_color : '-' }}" />
            <hr>
        </div>
    </div>
</div>
