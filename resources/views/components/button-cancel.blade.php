@props(['link' => 'javascript:void(0);'])

<a href="{{ $link }}" data-testid="cancel_button" class="btn btn-secondary btn-sm" wire:navigate>
    {{ __('messages.cancel_button_text') }}
</a>
