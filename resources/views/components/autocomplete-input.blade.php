@props([
    'label' => '',
    'searchPlaceholder' => 'Search...',
    'data' => [],
    'model' => '',
    'key' => 'id',
    'value' => 'name',
    'wireModel' => '',
    'disabled' => false,
    'selectedId' => null,
])

<div x-data="{
    allItems: {{ json_encode($data) }},
    search: '',
    filteredItems: {{ json_encode($data) }},
    selectedId: {{ json_encode($selectedId) }},
    dropdownVisible: false,
    {{ $wireModel }}: @entangle($wireModel),
    filterItems() {
        if (this.search.length > 0) {
            this.filteredItems = this.allItems.filter(item => {
                return item.{{ $value }}.toLowerCase().includes(this.search.toLowerCase());
            });
            this.dropdownVisible = this.filteredItems.length > 0;
        } else {
            this.filteredItems = this.allItems;
            this.dropdownVisible = false;
        }
    },
    selectItem(item) {
        this.search = item.{{ $value }};
        this.filteredItems = [];
        this.dropdownVisible = false;
        this.{{ $wireModel }} = item.{{ $key }};
    },
    init() {
        // Initialize the search field with the selected value for edit mode
        if (this.selectedId) {
            const selectedItem = this.allItems.find(item => item.{{ $key }} === this.selectedId);
            if (selectedItem) {
                this.search = selectedItem.{{ $value }};
            }
        }
    }
}" x-init="init()">

    <!-- Search Input -->
    <input class="form-control" type="text" x-model="search" @input="filterItems" @click.away="dropdownVisible = false"
        placeholder="{{ $searchPlaceholder }}" {{ $disabled ? 'disabled' : '' }} />

    <!-- Dropdown for filtered items -->
    <div x-show="dropdownVisible" aria-labelledby="roleSearch" x-transition>
        <template x-for="item in filteredItems" :key="item[key]">
            <a href="#" class="form-control" @click.prevent="selectItem(item)"> <span
                    x-text="item.{{ $value }}"></span> </a>
        </template>
    </div>
</div>
