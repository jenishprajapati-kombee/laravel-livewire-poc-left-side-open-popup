<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class Delete extends Component
{
    public $selectedUserIds = [];

    public $tableName;


    #[On('delete-confirmation')]
    public function deleteConfirmation($ids, $tableName)
    {
         // Initialize table name and reset selected ids
        $this->tableName = $tableName;
        $this->selectedUserIds = [];

        // Fetch the ids of the roles that match the given IDs and organization ID
        $userIds = User::whereIn('id', $ids)
            ->pluck('id')
            ->toArray();

        if (!empty($userIds)) {
            $this->selectedUserIds = $ids;
            if(count($this->selectedUserIds) > 1){
                 $message = __('messages.user.messages.bulk_delete_confirmation_text', ['count' => count($this->selectedUserIds)]);
            }else{
                $message = __('messages.user.messages.delete_confirmation_text');
            }

            $this->dispatch('showDeleteConfirmation', message: $message);
        }else {
             // If no roles were found, show an error message
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => __('messages.user.delete.record_not_found')
            ]);
        }

    }

    #[On('delete-confirmed')]
    public function destroy()
    {
        if (!empty($this->selectedUserIds)) {
            // Proceed with deletion of selected user
            User::whereIn('id', $this->selectedUserIds)->delete();
            session()->flash('success', __('messages.user.messages.delete'));
            return $this->redirect(route('user.index'), navigate: true);
        } else {
            $this->dispatch('alert', type: 'error', message: __('messages.user.messages.record_not_found'));
        }
    }

    /**
     * closeModal
     *
     * @return void
     */
    public function closeModal()
    {
        $this->dispatch('hide-modal', id: '#deleteUserModal');
    }

    public function render()
    {
        return view('livewire.user.delete');
    }
}
