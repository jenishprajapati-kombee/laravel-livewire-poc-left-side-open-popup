<?php

namespace App\Livewire\Brand;

use App\Models\Brand;
use Livewire\Attributes\On;
use Livewire\Component;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class Delete extends Component
{
    public $selectedBrandIds = [];

    public $tableName;


    #[On('delete-confirmation')]
    public function deleteConfirmation($ids, $tableName)
    {
         // Initialize table name and reset selected ids
        $this->tableName = $tableName;
        $this->selectedBrandIds = [];

        // Fetch the ids of the roles that match the given IDs and organization ID
        $brandIds = Brand::whereIn('id', $ids)
            ->pluck('id')
            ->toArray();

        if (!empty($brandIds)) {
            $this->selectedBrandIds = $ids;
            if(count($this->selectedBrandIds) > 1){
                 $message = __('messages.brand.messages.bulk_delete_confirmation_text', ['count' => count($this->selectedBrandIds)]);
            }else{
                $message = __('messages.brand.messages.delete_confirmation_text');
            }

            $this->dispatch('showDeleteConfirmation', message: $message);
        }else {
             // If no roles were found, show an error message
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => __('messages.brand.delete.record_not_found')
            ]);
        }

    }

    #[On('delete-confirmed')]
    public function destroy()
    {
        if (!empty($this->selectedBrandIds)) {
            // Proceed with deletion of selected brand
            Brand::whereIn('id', $this->selectedBrandIds)->delete();
            session()->flash('success', __('messages.brand.messages.delete'));
            return $this->redirect(route('brand.index'), navigate: true);
        } else {
            $this->dispatch('alert', type: 'error', message: __('messages.brand.messages.record_not_found'));
        }
    }

    /**
     * closeModal
     *
     * @return void
     */
    public function closeModal()
    {
        $this->dispatch('hide-modal', id: '#deleteBrandModal');
    }

    public function render()
    {
        return view('livewire.brand.delete');
    }
}
