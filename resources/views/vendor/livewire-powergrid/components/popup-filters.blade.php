<div class="dropdown">
    <button class="btn btn-info dropdown-toggle btn-custom-class sp-p me-1" type="button" onclick="handleDropdownClick('popupFilters')" aria-expanded="false">
        <svg
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            height="20"
            width="20"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z"
            />
        </svg>
    </button>
    <ul class="dropdown-menu pg-popup-filters" id="popupFilters">
        {{-- @foreach ($this->visibleColumns as $column)
            @if(count($column->filters) > 0)
                <li
                    class="{{ $theme->table->tdBodyClass }}"
                    wire:key="column-filter-{{ $column->field }}"
                    style="{{ $column->hidden === true ? 'display:none' : '' }}; {{ $theme->table->tdBodyStyle }}"
                >
                    <div class="dropdown-item">
                        @foreach ($column->filters as $key => $filter)
                            <div wire:key="filter-{{ $column->field }}-{{ $key }}">
                                @if (str(data_get($filter, 'className'))->contains('FilterMultiSelect'))
                                    <x-livewire-powergrid::inputs.select
                                        :tableName="$tableName"
                                        :filter="$filter"
                                        :theme="$theme->filterMultiSelect"
                                        :initialValues="data_get(data_get($filters, 'multi_select'), data_get($filter, 'field'), [])"
                                    />
                                @endif
                                @if (str(data_get($filter, 'className'))->contains(['FilterSelect', 'FilterEnumSelect']))
                                    @includeIf($theme->filterSelect->view, [
                                        'inline' => true,
                                        'column' => $column,
                                        'filter' => $filter,
                                        'theme' => $theme->filterSelect,
                                    ])
                                @endif
                                @if (str(data_get($filter, 'className'))->contains('FilterInputText'))
                                    @includeIf($theme->filterInputText->view, [
                                        'inline' => true,
                                        'filter' => $filter,
                                        'theme' => $theme->filterInputText,
                                    ])
                                @endif
                                @if (str(data_get($filter, 'className'))->contains('FilterNumber'))
                                    @includeIf($theme->filterNumber->view, [
                                        'inline' => true,
                                        'filter' => $filter,
                                        'theme' => $theme->filterNumber,
                                    ])
                                @endif
                                @if (str(data_get($filter, 'className'))->contains('FilterDynamic'))
                                    <x-dynamic-component
                                        :component="data_get($filter, 'component', '')"
                                        :attributes="new \Illuminate\View\ComponentAttributeBag(
                                            data_get($filter, 'attributes', []),
                                        )"
                                    />
                                @endif
                                @if (str(data_get($filter, 'className'))->contains('FilterDateTimePicker'))
                                    @includeIf($theme->filterDatePicker->view, [
                                        'inline' => true,
                                        'filter' => $filter,
                                        'type' => 'datetime',
                                        'tableName' => $tableName,
                                        'classAttr' => 'w-full',
                                        'theme' => $theme->filterDatePicker,
                                    ])
                                @endif
                                @if (str(data_get($filter, 'className'))->contains('FilterDatePicker'))
                                    @includeIf($theme->filterDatePicker->view, [
                                        'inline' => true,
                                        'filter' => $filter,
                                        'type' => 'date',
                                        'tableName' => $tableName,
                                        'classAttr' => 'w-full',
                                        'theme' => $theme->filterDatePicker,
                                    ])
                                @endif
                                @if (str(data_get($filter, 'className'))->contains('FilterBoolean'))
                                    @includeIf($theme->filterBoolean->view, [
                                        'inline' => true,
                                        'filter' => $filter,
                                        'theme' => $theme->filterBoolean,
                                    ])
                                @endif
                            </div>
                        @endforeach
                    </div>
                </li>
            @endif
        @endforeach --}}
         @foreach ($this->visibleColumns as $column)
            @php
                $filterClass = str(data_get($column, 'filters.className'));
            @endphp
            @if($column->filters && count($column->filters) > 0)
                <li
                    class="{{ data_get($theme, 'table.tdBodyClass') }} dropdown-item"
                    wire:key="column-filter-{{ data_get($column, 'field') }}"
                    style="{{ data_get($column, 'hidden') === true ? 'display:none' : '' }}; {{ data_get($theme, 'table.tdBodyStyle') }}"
                >
                    <div wire:key="filter-{{ data_get($column, 'field') }}-{{ $loop->index }}">
                        @if ($filterClass->contains('FilterMultiSelect'))
                            <x-livewire-powergrid::inputs.select
                                :table-name="$tableName"
                                :title="data_get($column, 'title')"
                                :filter="(array) data_get($column, 'filters')"
                                :theme="data_get($theme, 'filterMultiSelect')"
                                :initial-values="data_get($filters, 'multi_select.'.data_get($column, 'dataField'))"
                            />
                        @elseif ($filterClass->contains(['FilterSelect', 'FilterEnumSelect']))
                            @includeIf(data_get($theme, 'filterSelect.view'), [
                                'inline' => true,
                                'filter' => (array) data_get($column, 'filters'),
                                'theme' => data_get($theme, 'filterSelect'),
                            ])
                        @elseif ($filterClass->contains('FilterInputText'))
                            @includeIf(data_get($theme, 'filterInputText.view'), [
                                'inline' => true,
                                'filter' => (array) data_get($column, 'filters'),
                                'theme' => data_get($theme, 'filterInputText'),
                            ])
                        @elseif ($filterClass->contains('FilterNumber'))
                            @includeIf(data_get($theme, 'filterNumber.view'), [
                                'inline' => true,
                                'filter' => (array) data_get($column, 'filters'),
                                'theme' => data_get($theme, 'filterNumber'),
                            ])
                        @elseif ($filterClass->contains('FilterDateTimePicker'))
                            @includeIf(data_get($theme, 'filterDatePicker.view'), [
                                'inline' => true,
                                'filter' => (array) data_get($column, 'filters'),
                                'type' => 'datetime',
                                'tableName' => $tableName,
                                'classAttr' => 'w-full',
                                'theme' => data_get($theme, 'filterDatePicker'),
                            ])
                        @elseif ($filterClass->contains('FilterDatePicker'))
                            @includeIf(data_get($theme, 'filterDatePicker.view'), [
                                'inline' => true,
                                'filter' => (array) data_get($column, 'filters'),
                                'type' => 'date',
                                'classAttr' => 'w-full',
                                'theme' => data_get($theme, 'filterDatePicker'),
                            ])
                        @elseif ($filterClass->contains('FilterBoolean'))
                            @includeIf(data_get($theme, 'filterBoolean.view'), [
                                'inline' => true,
                                'filter' => (array) data_get($column, 'filters'),
                                'theme' => data_get($theme, 'filterBoolean'),
                            ])
                        @elseif ($filterClass->contains('FilterDynamic'))
                            <x-dynamic-component
                                :component="data_get($column, 'filters.component')"
                                :attributes="new \Illuminate\View\ComponentAttributeBag(
                                    data_get($column, 'filters.attributes', []),
                                )"
                            />
                        @endif
                    </div>
                </li>
            @endif
        @endforeach
    </ul>
</div>
