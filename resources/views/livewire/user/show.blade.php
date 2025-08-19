<div class="col-lg-12">
    <div class="card-xl-stretch-1 mb-4">
        <div>
            <x-show-info key="{{ __('messages.user.show.details.name') }}" value="{{ !is_null($user) ? $user->name : '-' }}" />
            <hr>
            <x-show-info key="{{ __('messages.user.show.details.email') }}" value="{{ !is_null($user) ? $user->email : '-' }}" />
            <hr>
            <x-show-info key="{{ __('messages.user.show.details.role_name') }}" value="{{ !is_null($user) ? $user->role_name : '-' }}" />
            <hr>
            <x-show-info key="{{ __('messages.user.show.details.dob') }}" value="{{ !is_null($user) ? $user->dob : '-' }}" />
            <hr>
            <div class="row">
                <div class="col-sm-5">
                    <p class="mb-0">{{ __('messages.user.show.details.profile') }}</p>
                </div>
                <div class="col-sm-7">
                    <p class="text-muted mb-0"> {!! isset($user) && $user->profile !='' ? '<a target="_blank" class="btn btn-light-info" href="' . $user->profile . '">View Image <i class="las la-file-image fs-4 me-2"></i></a>' : '-' !!}</p>
                </div>
            </div>
            <hr>
            <x-show-info key="{{ __('messages.user.show.details.country_name') }}" value="{{ !is_null($user) ? $user->country_name : '-' }}" />
            <hr>
            <x-show-info key="{{ __('messages.user.show.details.state_name') }}" value="{{ !is_null($user) ? $user->state_name : '-' }}" />
            <hr>
            <x-show-info key="{{ __('messages.user.show.details.city_name') }}" value="{{ !is_null($user) ? $user->city_name : '-' }}" />
            <hr>
            <x-show-info key="{{ __('messages.user.show.details.gender') }}" value="{{ !is_null($user) ? $user->gender : '-' }}" />
            <hr>
            <x-show-info key="{{ __('messages.user.show.details.status') }}" value="{{ !is_null($user) ? $user->status : '-' }}" />
            <hr>
            <x-show-info key="{{ __('messages.user.show.details.sort_order') }}" value="{{ !is_null($user) ? $user->sort_order : '-' }}" />
            <hr>
        </div>
    </div>
</div>
