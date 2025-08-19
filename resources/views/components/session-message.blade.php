<div wire:key="{{ rand() }}">
    @if (session()->has('success'))
        <div x-data="{show: true}" x-effect="setTimeout(() => show = false, 3000)" x-show="show" id="session-alert"
             class="alert alert-success alert-dismissible"
            {{--x-on:click="show = false"--}}>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session()->has('warning'))
        <div x-data="{show: true}" x-effect="setTimeout(() => show = false, 3000)" x-show="show" id="session-alert"
             class="alert alert-warning alert-dismissible"
            {{--x-on:click="show = false"--}}>
            {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session()->has('error'))
        <div x-data="{show: true}" x-effect="setTimeout(() => show = false, 3000)" x-show="show" id="session-alert"
             class="alert alert-danger alert-dismissible"
            {{--x-on:click="show = false"--}}>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>
