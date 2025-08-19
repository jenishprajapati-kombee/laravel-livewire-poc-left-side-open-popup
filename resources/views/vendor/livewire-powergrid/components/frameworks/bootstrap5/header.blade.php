<div>
    @includeIf(data_get($setUp, 'header.includeViewOnTop'))
    <div class="dt--top-section sp-line-bottom">
        <div class="row">
            <div class="col-6 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3">
                @include(powerGridThemeRoot() . '.header.search')
            </div>

            <div class="col-6 col-sm-6 text-end d-flex justify-content-end mt-sm-0 mt-3">
                <div class="me-3 mt-3">
                    @includeWhen(boolval(data_get($setUp, 'header.wireLoading')), powerGridThemeRoot() . '.header.loading')
                </div>
                <div>
                    @include(powerGridThemeRoot() . '.header.actions')
                </div>
                {{-- @if ($this->hasColumnFilters)
                    <div>
                        @include('livewire-powergrid::components.popup-filters')
                    </div>
                @endif --}}
                <div class="">
                    @includeWhen(data_get($setUp, 'exportable'), powerGridThemeRoot() . '.header.export')
                </div>
                @include(powerGridThemeRoot() . '.header.toggle-columns')
                @includeIf(powerGridThemeRoot() . '.header.soft-deletes')
            </div>
        </div>
    </div>
    @include(powerGridThemeRoot() . '.header.batch-exporting')
    @include(powerGridThemeRoot() . '.header.enabled-filters')
    @include(powerGridThemeRoot() . '.header.multi-sort')
    @includeIf(data_get($setUp, 'header.includeViewOnBottom'))
    @includeIf(powerGridThemeRoot() . '.header.message-soft-deletes')
</div>
