<?php

namespace App\Models;

use App\Traits\CreatedbyUpdatedby;
use App\Traits\Mailable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailTemplate extends Model
{
    use CreatedbyUpdatedby, HasFactory, Mailable, SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = ['id', 'type', 'label', 'subject', 'body', 'created_by', 'updated_by'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'type' => 'string',
        'subject' => 'string',
        'body' => 'string',
    ];
}
