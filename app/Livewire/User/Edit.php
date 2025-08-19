<?php
namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public $user;

    public $id;
    public $name;
    public $email;
    public $password;
    public $role_id;
    public $roles = [];
    public $dob;
    public $profile;
    public $profile_image;
    public $country_id;
    public $countries = [];
    public $state_id;
    public $states = [];
    public $city_id;
    public $cities = [];
    public $gender;
    public $status;
    public $email_verified_at;
    public $remember_token;
    public $sort_order;

    
    /**
     * @param  $user
     * @return void
     */
    public function mount($id)
    {
        $this->user = User::find($id);
        if ($this->user) {
            foreach ($this->user->getAttributes() as $key => $value) {
                $this->{$key} = $value; // Dynamically assign the attributes to the class
            }
        }

        $this->roles     = \App\Models\Role::all();
        $this->countries = \App\Models\Country::all();
        $this->states    = \App\Models\State::all();
        $this->cities    = \App\Models\City::all();

    }

    public function rules()
    {

        $rules = [
            'name'          => 'required|max:100',
            'email'         => 'required|max:200|email|unique:users,email,' . $this->user->id . ',id,deleted_at,NULL',
            'role_id'       => 'required|exists:roles,id,deleted_at,NULL',
            'dob'           => 'required|date_format:Y-m-d',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'country_id'    => 'required|exists:countries,id,deleted_at,NULL',
            'state_id'      => 'required|exists:states,id,deleted_at,NULL',
            'city_id'       => 'required|exists:cities,id,deleted_at,NULL',
            'gender'        => 'required|in:F,M',
            'status'        => 'required|in:Y,N',
            'sort_order'    => 'required|max:191',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'          => __('messages.user.validation.messsage.name.required'),
            'name.max'               => __('messages.user.validation.messsage.name.max'),
            'email.required'         => __('messages.user.validation.messsage.email.required'),
            'email.max'              => __('messages.user.validation.messsage.email.max'),
            'email.email'            => __('messages.user.validation.messsage.email.email'),
            'role_id.required'       => __('messages.user.validation.messsage.role_id.required'),
            'dob.required'           => __('messages.user.validation.messsage.dob.required'),
            'dob.date_format'        => __('messages.user.validation.messsage.dob.date_format'),
            'profile_image.required' => __('messages.user.validation.messsage.profile_image.required'),
            'profile_image.max'      => __('messages.user.validation.messsage.profile_image.max'),
            'country_id.required'    => __('messages.user.validation.messsage.country_id.required'),
            'state_id.required'      => __('messages.user.validation.messsage.state_id.required'),
            'city_id.required'       => __('messages.user.validation.messsage.city_id.required'),
            'gender.required'        => __('messages.user.validation.messsage.gender.required'),
            'gender.in'              => __('messages.user.validation.messsage.gender.in'),
            'status.required'        => __('messages.user.validation.messsage.status.required'),
            'status.in'              => __('messages.user.validation.messsage.status.in'),
            'sort_order.required'    => __('messages.user.validation.messsage.sort_order.required'),
            'sort_order.max'         => __('messages.user.validation.messsage.sort_order.max'),
        ];
    }

    public function store()
    {
        $this->validate();

        $data = [
            'name'       => $this->name,
            'email'      => $this->email,
            'role_id'    => $this->role_id,
            'dob'        => $this->dob,
            'profile'    => $this->profile,
            'country_id' => $this->country_id,
            'state_id'   => $this->state_id,
            'city_id'    => $this->city_id,
            'gender'     => $this->gender,
            'status'     => $this->status,
            'sort_order' => $this->sort_order,
        ];
        if (! empty($data)) {
            $this->user->update($data); // Update data into the DB
        }

        if ($this->profile_image) {
            $realPath     = "user/" . $this->user->id . "/";
            $resizeImages = $this->user->resizeImages($this->profile_image, $realPath, true);
            $imagePath    = $realPath . pathinfo($resizeImages["image"], PATHINFO_BASENAME);
            $this->user->update(["profile" => $imagePath]);
        }

        session()->flash('success', __('messages.user.messages.update'));
        return $this->redirect('/user', navigate: true); // redirect to user listing page
    }

    public function updatedCountryId()
    {
        // When country_id is updated, load the dependent options
        $this->states = \App\Models\State::where('country_id', $this->country_id)->get();
    }

    public function updatedStateId()
    {
        // When state_id is updated, load the dependent options
        $this->cities = \App\Models\City::where('state_id', $this->state_id)->get();
    }

    public function render()
    {
        return view('livewire.user.edit');
    }
}
