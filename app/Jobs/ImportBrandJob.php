<?php

namespace App\Jobs;

use App\Imports\BrandImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\ImportLog;
use App\Models\Brand;
use App\Helper;

class ImportBrandJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Fetch pending import logs for brands
            $importLogs = ImportLog::where('model_name', config('constants.import_csv_log.models.brand'))
                ->where('status', config('constants.import_csv_log.status.key.pending'))
                ->where('import_flag', config('constants.import_csv_log.import_flag.key.pending'))
                ->get();

            // If there are pending import logs
            if (!$importLogs->isEmpty()) {
                foreach ($importLogs as $importLog) {
                    // Log initiation of brand data import processing
                    Log::info("Initiate processing of brand data import: " . $importLog->file_name);

                    // Update status to Processing in import_logs table
                    $this->updateStatus($importLog, config('constants.import_csv_log.status.key.processing'));

                    // Log status modification in import_logs table
                    Log::info('Status has been modified to "processing" in the import_logs table.');

                    // Initialize brandImport model
                    $model = new BrandImport($importLog->user_id);

                    // Decode file path and retrieve the file name
                    $path = urldecode(parse_url($importLog->file_path, PHP_URL_PATH));

                    // Generate redirect link for display after import
                    $redirectLink = url('brand-imports?filename=' . $importLog->file_name);

                    // Set email subject for import notification
                    $subject = config('constants.import_csv_log.subject.brand');

                    // Initiate common import process for brands
                    Brand::commonImport($model, $path, $importLog->model_name, $importLog->file_name, $redirectLink, $subject, $importLog);

                    // Log successful file import
                    Log::info('File Imported successfully.(' . $importLog->file_name . ')');
                }
            }
        } catch (\Exception $e) {
            // Log any exceptions that occur during contractor import
            Log::error('Import brand Exception Occurred: ' . $e->getMessage() . PHP_EOL . $e->getTraceAsString());
            Helper::logCatchError($e, static::class, __FUNCTION__);
        }
    }

    /**
     * updateStatus
     *
     * @param $importLog
     * @param $status
     * @return void
     */
    public function updateStatus($importLog, $status)
    {
        $importLog->status = $status;
        $importLog->update();
    }
}
