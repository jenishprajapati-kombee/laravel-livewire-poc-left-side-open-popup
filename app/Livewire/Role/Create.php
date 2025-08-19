<?php
namespace App\Livewire\Role;

use App\Models\Role;
use Livewire\Component;

class Create extends Component
{

    public $id;
    public $name;
    public $bg_color;
    

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
            $role = Role::create($data);
        }

        session()->flash('success', __('messages.role.messages.success'));
        return $this->redirect('/role', navigate: true); // redirect to role listing page
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.role.create')->title(__('messages.meta_title.create_role'));
    }

}
