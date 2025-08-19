<?php

namespace App\Models;

use App\Traits\CreatedbyUpdatedby;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PushNotificationHistory extends Model
{
    use CreatedbyUpdatedby, HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'title',
        'body',
        'image',
        'is_read',
        'button_name',
        'button_link',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public static function storeHistory($Id, $title, $body, $image, $template)
    {
        PushNotificationHistory::create([
            'id' => $Id,
            'title' => $title,
            'body' => $body,
            'image' => $image,
            'is_read' => config('constants.notification_is_read.unread'),
            'button_name' => $template->button_name,
            'button_link' => $template->button_link,
        ]);
    }

    public static function getNotificationCount($Id) {
        return PushNotificationHistory::where('id', $Id)->where('is_read', config('constants.notification_is_read.unread'))->count();
    }
}
