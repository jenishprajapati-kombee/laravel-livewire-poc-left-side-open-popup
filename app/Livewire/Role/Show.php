<?php
namespace App\Livewire\Role;

use App\Models\Role;
use Livewire\Component;

class Show extends Component
{
    public $id;
    public $role;

    public function mount($id)
    {
        $this->role = null;
        $this->role = Role::select(
            'roles.id', 'roles.name', 'roles.bg_color'
        )->where('roles.id', $id)->first();

    }

    public function render()
    {
        return view('livewire.role.show');
    }
}
