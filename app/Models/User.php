<?php

namespace App\Models;

use App\Helper;
use App\Traits\CreatedbyUpdatedby;
use App\Traits\UploadTrait;
use App\Traits\ImportTrait;
use App\Traits\Legendable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable implements MustVerifyEmail
{
    use CreatedbyUpdatedby, HasApiTokens, Notifiable, SoftDeletes, UploadTrait,ImportTrait,Legendable,HasFactory;

    protected $fillable = [ 'name', 'email', 'role_id', 'dob', 'profile', 'country_id', 'state_id', 'city_id', 'gender', 'status', 'email_verified_at', 'remember_token', 'sort_order' ];

    protected $casts = [
            
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    
            /**
             * The gender relationship.
             */
            public static function gender()
            {
                return collect(
                    [['key' => 'F', 'label' => 'Female'], ['key' => 'M', 'label' => 'Male']]
                );
            }

            /**
             * The status relationship.
             */
            public static function status()
            {
                return collect(
                    [['key' => 'Y', 'label' => 'Active'], ['key' => 'N', 'label' => 'Inactive']]
                );
            }

    public function hasPermission($permission, $roleId)
    {
        $permissions = Helper::getCachedPermissionsByRole($roleId);

        return in_array($permission, $permissions);
    }

    
/**
 * @return \Illuminate\Contracts\Routing\UrlGenerator|string|null
 */
public function getProfileAttribute($value)
{
    if (!empty($value) && $this->is_file_exists($value)) {
        return $this->getFilePathByStorage($value);
    }
    return null;
}

}
