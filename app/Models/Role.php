<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CreatedbyUpdatedby;
use App\Traits\CommonTrait;
use App\Traits\UploadTrait;
use App\Traits\ImportTrait;
use App\Traits\Legendable;

class Role extends Model
{
    use SoftDeletes, CommonTrait, CreatedbyUpdatedby, HasFactory, UploadTrait, ImportTrait, Legendable;

    protected $fillable = [ 'name', 'bg_color' ];

    protected $casts = [
        
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    

    
}
