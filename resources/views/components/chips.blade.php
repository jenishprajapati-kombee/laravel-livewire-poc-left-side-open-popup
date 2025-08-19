
<!-- Chips Input Section -->
@props(['model'])
<div x-data="{
    chipInput: '',
    tags: @entangle($model), // Bind to Livewire's model
    addChip() {
        const trimmedChip = this.chipInput.trim();
        if (trimmedChip !== '' && !this.tags.includes(trimmedChip)) {
            this.tags.push(trimmedChip); // Add the chip to tags
            this.chipInput = ''; // Clear input field
           
        }
    },
    removeChip(index) {
        this.tags.splice(index, 1); // Remove chip from tags
       
    }
}">
    <div class="input-group">
        <input type="text" x-model="chipInput" placeholder="Enter {{ ucwords(str_replace('_', ' ', $model)) }}..."
            class="form-control" @keydown.enter.prevent="addChip" />
        <button type="button" @click.prevent="addChip" class="btn btn-primary btn-sm">Add</button>
    </div>

    <div class="chip-list mt-2">
        <template x-for="(tag, index) in tags" :key="index">
            <span class="chip">
                <span x-text="tag"></span>
                <button @click.prevent="removeChip(index)" type="button" class="remove-chip">X</button>
            </span>
        </template>
    </div>
</div>