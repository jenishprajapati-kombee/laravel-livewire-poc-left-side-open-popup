<?php
namespace App\Livewire\Role;

use App\Models\Role;
use Livewire\Component;

class Edit extends Component
{

    public $role;

    public $id;
    public $name;
    public $bg_color;

    
    /**
     * @param  $role
     * @return void
     */
    public function mount($id)
    {
        $this->role = Role::find($id);

        if ($this->role) {
            foreach ($this->role->getAttributes() as $key => $value) {
                $this->{$key} = $value; // Dynamically assign the attributes to the class
            }
        }

    }

    public function rules()
    {

        $rules = [
            'name'     => 'required|max:191',
            'bg_color' => 'required|max:191',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'     => __('messages.role.validation.messsage.name.required'),
            'name.max'          => __('messages.role.validation.messsage.name.max'),
            'bg_color.required' => __('messages.role.validation.messsage.bg_color.required'),
            'bg_color.max'      => __('messages.role.validation.messsage.bg_color.max'),
        ];
    }

    public function store()
    {
        $this->validate();

        $data = [
            'name'     => $this->name,
            'bg_color' => $this->bg_color,
        ];
        if (! empty($data)) {
            $this->role->update($data); // Update data into the DB
        }

        session()->flash('success', __('messages.role.messages.update'));
        return $this->redirect('/role', navigate: true); // redirect to role listing page
    }

    public function render()
    {
        return view('livewire.role.edit')->title(__('messages.meta_title.edit_role'));
    }

}
