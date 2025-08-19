<div wire:ignore class="py-5" data-bs-theme="light">
    <textarea wire:model="body" name="body" id="body">
        {!! $value !!}
    </textarea>
</div>

@script
<script>
    ClassicEditor
        .create(document.querySelector('#body'))
        .then(editor => {
            editor.model.document.on('change:data', () => {
                $wire.body = editor.getData();
            })
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endscript
