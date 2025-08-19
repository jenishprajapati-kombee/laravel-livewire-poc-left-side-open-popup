<?php
namespace App\Models;

use App\Traits\CommonTrait;
use App\Traits\CreatedbyUpdatedby;
use App\Traits\ImportTrait;
use App\Traits\Legendable;
use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BrandDetail extends Model
{
    use SoftDeletes, CommonTrait, CreatedbyUpdatedby, HasFactory, UploadTrait, ImportTrait, Legendable;

    protected $fillable = ['brand_id', 'description', 'status', 'brand_image', 'bg_color'];

    protected $casts = [

    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string|null
     */
    public function getBrandImageAttribute($value)
    {
        if (! empty($value) && $this->is_file_exists($value)) {
            return $this->getFilePathByStorage($value);
        }
        return null;
    }

}
