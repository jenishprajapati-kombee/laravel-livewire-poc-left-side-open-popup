<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait CreatedbyUpdatedby
{
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $user = Auth::user();

            if ($user) {

                $model->created_by = $user->id;
                $model->updated_by = $user->id;
            }
        });

        static::updating(function ($model) {
            $user = Auth::user();

            if ($user) {
                $model->updated_by = $user->id;
            }
        });
    }
}
