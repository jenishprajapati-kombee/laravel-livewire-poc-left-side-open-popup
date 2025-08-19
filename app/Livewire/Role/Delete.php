<?php

namespace App\Livewire\Role;

use App\Models\Role;
use Livewire\Attributes\On;
use Livewire\Component;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class Delete extends Component
{
    public $selectedRoleIds = [];

    public $tableName;


    #[On('delete-confirmation')]
    public function deleteConfirmation($ids, $tableName)
    {
         // Initialize table name and reset selected ids
        $this->tableName = $tableName;
        $this->selectedRoleIds = [];

        // Fetch the ids of the roles that match the given IDs and organization ID
        $roleIds = Role::whereIn('id', $ids)
            ->pluck('id')
            ->toArray();

        if (!empty($roleIds)) {
            $this->selectedRoleIds = $ids;
            if(count($this->selectedRoleIds) > 1){
                 $message = __('messages.role.messages.bulk_delete_confirmation_text', ['count' => count($this->selectedRoleIds)]);
            }else{
                $message = __('messages.role.messages.delete_confirmation_text');
            }

            $this->dispatch('showDeleteConfirmation', message: $message);
        }else {
             // If no roles were found, show an error message
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => __('messages.role.delete.record_not_found')
            ]);
        }

    }

    #[On('delete-confirmed')]
    public function destroy()
    {
        if (!empty($this->selectedRoleIds)) {
            // Proceed with deletion of selected role
            Role::whereIn('id', $this->selectedRoleIds)->delete();
            session()->flash('success', __('messages.role.messages.delete'));
            return $this->redirect(route('role.index'), navigate: true);
        } else {
            $this->dispatch('alert', type: 'error', message: __('messages.role.messages.record_not_found'));
        }
    }

    /**
     * closeModal
     *
     * @return void
     */
    public function closeModal()
    {
        $this->dispatch('hide-modal', id: '#deleteRoleModal');
    }

    public function render()
    {
        return view('livewire.role.delete');
    }
}
