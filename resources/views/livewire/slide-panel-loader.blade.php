<div>
    @if ($componentName)
        @livewire($componentName, $params, key($componentName . json_encode($params)))
    @else
        {{-- Initial placeholder before any component is loaded --}}
        <div class="d-flex flex-column justify-content-center align-items-center py-10">
            <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;" role="status"></div>
            <span class="text-muted">Loading...</span>
        </div>
    @endif
</div>
