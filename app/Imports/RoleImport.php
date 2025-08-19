<?php

namespace App\Imports;

use App\Models\Role;
use App\Traits\CreatedbyUpdatedby;
use App\Traits\CommonTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class RoleImport implements ToCollection, WithStartRow
{
    use CreatedbyUpdatedby, CommonTrait;

    private $errors = [];

    private $rows = 0;

    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function getErrors()
    {
        return $this->errors; // return all errors
    }

    public function rules(): array
    {
        return  [
  '0' => 'required|max:191',
  '1' => 'required|max:191',
];
    }

    public function validationMessages()
    {
       return  [
  '0.required' => __('messages.role.validation.messsage.0.required'),
  '0.max' => __('messages.role.validation.messsage.0.max'),
  '1.required' => __('messages.role.validation.messsage.1.required'),
  '1.max' => __('messages.role.validation.messsage.1.max'),
];
    }

    public function validateBulk($collection){
        $i=1;
        foreach ($collection as $col) {
            $i++;
            $errors[$i] = ['row' => $i];

            $validator = Validator::make($col->toArray(), $this->rules(), $this->validationMessages());
            if ($validator->fails()) {
                foreach ($validator->errors()->messages() as $messages) {
                    foreach ($messages as $error) {
                         $errors[$i]['error'][] = $error;
                    }
                }

                $this->errors[] = (object) $errors[$i];
            }

        }
        return $this->getErrors();
    }

    public function collection(Collection $collection)
    {
        $error = $this->validateBulk($collection);

        if ($error) {
            return;
        } else {
            foreach ($collection as $col) {
                $role = Role::create([
                        'name' =>  $col[0],
     'bg_color' =>  $col[1],

                ]);

                

                $this->rows++;
            }
        }
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }
}
