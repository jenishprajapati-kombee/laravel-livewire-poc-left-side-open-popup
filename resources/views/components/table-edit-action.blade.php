<button title="{{ __('messages.tooltip.click_edit') }}" class="btn btn-icon btn-light-secondary" wire:click="edit('{{$idValue}}')" wire:loading.attr="disabled">
    <i class="las la-edit fs-2 me-2"></i>
</button>