<?php

namespace App\Imports;

use App\Models\User;
use App\Traits\CreatedbyUpdatedby;
use App\Traits\CommonTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class UserImport implements ToCollection, WithStartRow
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
  '0' => 'required|max:100',
  '1' => 'required|max:200|email|unique:users,email,NULL,id,deleted_at,NULL',
  '2' => 'required|min:6|max:191',
  '3' => 'required|exists:roles,id,deleted_at,NULL',
  '4' => 'required|date_format:Y-m-d',
  '5' => 'required|exists:countries,id,deleted_at,NULL',
  '6' => 'required|exists:states,id,deleted_at,NULL',
  '7' => 'required|exists:cities,id,deleted_at,NULL',
  '8' => 'required|in:F,M',
  '9' => 'required|in:Y,N',
  '10' => 'required|max:191',
];
    }

    public function validationMessages()
    {
       return  [
  '0.required' => __('messages.user.validation.messsage.0.required'),
  '0.max' => __('messages.user.validation.messsage.0.max'),
  '1.required' => __('messages.user.validation.messsage.1.required'),
  '1.max' => __('messages.user.validation.messsage.1.max'),
  '1.email' => __('messages.user.validation.messsage.1.email'),
  '2.required' => __('messages.user.validation.messsage.2.required'),
  '2.min' => __('messages.user.validation.messsage.2.min'),
  '2.max' => __('messages.user.validation.messsage.2.max'),
  '3.required' => __('messages.user.validation.messsage.3.required'),
  '4.required' => __('messages.user.validation.messsage.4.required'),
  '4.date_format' => __('messages.user.validation.messsage.4.date_format'),
  '5.required' => __('messages.user.validation.messsage.5.required'),
  '6.required' => __('messages.user.validation.messsage.6.required'),
  '7.required' => __('messages.user.validation.messsage.7.required'),
  '8.required' => __('messages.user.validation.messsage.8.required'),
  '8.in' => __('messages.user.validation.messsage.8.in'),
  '9.required' => __('messages.user.validation.messsage.9.required'),
  '9.in' => __('messages.user.validation.messsage.9.in'),
  '10.required' => __('messages.user.validation.messsage.10.required'),
  '10.max' => __('messages.user.validation.messsage.10.max'),
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
                $user = User::create([
                        'name' =>  $col[0],
     'email' =>  $col[1],
     'password' =>  bcrypt($col['.2.']),
     'role_id' =>  $col[3],
     'dob' =>  $col[4],
     'country_id' =>  $col[5],
     'state_id' =>  $col[6],
     'city_id' =>  $col[7],
     'gender' =>  $col[8],
     'status' =>  $col[9],
     'sort_order' =>  $col[10],

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
