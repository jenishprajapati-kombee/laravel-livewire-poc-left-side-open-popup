<?php

namespace App\Models;

use App\Traits\CreatedbyUpdatedby;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SmsHistory extends Model
{
    use CreatedbyUpdatedby, HasFactory, SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = ['id', 'mobile_number', 'message', 'created_by', 'updated_by'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native numbers.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'number' => 'string',
    ];

    public static function storeHistory($number, $message, $Id)
    {
        $data['mobile_number'] = $number;
        $data['message'] = $message;
        $data['id'] = $Id;

        SmsHistory::create($data);
    }
}
