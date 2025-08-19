<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DropzoneComponent extends Component
{
    public $importData;
    public $userID;

    /**
     * mount
     *
     * @param  mixed $importData
     * @return void
     */
    public function mount($importData)
    {
        $user = Auth::user();
        $this->importData = $importData;
        $this->userID = $user->id;
    }

    public function downloadSampleCsv()
    {
        if ($this->importData['modelName'] == config('constants.import_csv_log.models.role')) {
                    $filePath = public_path('samples/import_sample_role.csv');
                }
                         else if ($this->importData['modelName'] == config('constants.import_csv_log.models.user')) {
                    $filePath = public_path('samples/import_sample_user.csv');
                }
                         else if ($this->importData['modelName'] == config('constants.import_csv_log.models.brand')) {
                    $filePath = public_path('samples/import_sample_brand.csv');
                }
                         else {
            $filePath = ''; // Default file path
        }

        if ($filePath != "") {
            return response()->download($filePath);
        } else {
            session()->flash('error', __('messages.something_went_wrong'));
        }
    }

    public function render()
    {
        return view('livewire.dropzone-component');
    }
}
