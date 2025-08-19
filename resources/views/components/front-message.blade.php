<div x-data="{ showFlashMessage: @entangle('showFlashMessage'), flashMessage: @entangle('flashMessage') }">
    <template x-if="showFlashMessage">
        <div x-show="showFlashMessage" x-text="flashMessage"
             id="session-alert"
             class="bg-green-500 px-4 py-2 mt-4 rounded-md cursor-pointer alert alert-success alert-dismissible"
             x-effect="setTimeout(() => showFlashMessage = false, 3000)"
             @click="showFlashMessage = false">
        </div>
    </template>
</div>
