<?php

namespace App\Models;

use App\Traits\CreatedbyUpdatedby;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImportLog extends Model
{
    protected $table = 'import_csv_logs';

    use CreatedbyUpdatedby, HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['id', 'file_name', 'file_path', 'model_name', 'user_id', 'status', 'no_of_rows', 'error_log', 'import_flag', 'voucher_email', 'redirect_link'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'no_of_rows' => 'string',
        ];
    }

    public static function status()
    {
        return collect(
            [
                ['status' => config('constants.import_csv_log.status.key.success'),  'label' => config('constants.import_csv_log.status.value.success')],
                ['status' => config('constants.import_csv_log.status.key.fail'),  'label' => config('constants.import_csv_log.status.value.fail')],
                ['status' => config('constants.import_csv_log.status.key.pending'),  'label' => config('constants.import_csv_log.status.value.pending')],
                ['status' => config('constants.import_csv_log.status.key.processing'),  'label' => config('constants.import_csv_log.status.value.processing')],
            ]
        );
    }
}
