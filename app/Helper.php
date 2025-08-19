<?php

namespace App;


use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Contracts\Validation\Validator;
use Throwable;

class Helper
{
    /**
     * @return string
     */
    public static function formatDate($dateTime, $format = null)
    {
        $format = is_null($format) ? config('constants.date_formats.default') : $format;

        return Carbon::parse($dateTime)->format($format);
    }

    /**
     * @param  $importStatus
     * @return string
     */
    public static function getImportStatusText($status)
    {

        if ($status == config('constants.import_csv_log.status.key.success')) {
            $statusText = '<span class="badge badge-success">'.config('constants.import_csv_log.status.value.success').'</span>';
        } elseif ($status == config('constants.import_csv_log.status.key.fail')) {
            $statusText = '<span class="badge badge-danger">'.config('constants.import_csv_log.status.value.fail').'</span>';
        } elseif ($status == config('constants.import_csv_log.status.key.pending')) {
            $statusText = '<span class="badge badge-primary">'.config('constants.import_csv_log.status.value.pending').'</span>';
        } elseif ($status == config('constants.import_csv_log.status.key.processing')) {
            $statusText = '<span class="badge badge-warning">'.config('constants.import_csv_log.status.value.processing').'</span>';
        } elseif ($status == config('constants.import_csv_log.status.key.convert_decrypted')) {
            $statusText = '<span class="badge badge-warning">'.config('constants.import_csv_log.status.value.convert_decrypted').'</span>';
        } else {
            $statusText = '-';
        }

        return $statusText;
    }

    public static function runExportJob($totalRecord, $filters, $checkboxValues, $search, $headingColumn, $downloadPrefixFileName, $exportClass, $batchName, $extraParam = []): array
    {
        try {
            // Check if there are any records to export
            if (! $totalRecord) {
                return ['status' => false, 'message' => 'We can\'t find any record.'];
            }

            // Calculate batch parameters
            $newFileArray = $jobArray = [];

            // We are chunked as 25000 per process & it's configurable via .env.
            $itemCountBatching = config('constants.export_pagination');
            $count = ($checkboxValues) ? count($checkboxValues) : $totalRecord;
            $jobCount = ceil($count / $itemCountBatching);

            // Export file are stored in "custom_exports" folder in storage.
            $folder = config('constants.export_file_path').uniqid().'/';
            $file = $folder.time();

            // Generate new file names and create export job instances
            for ($index = 1; $index <= $jobCount; $index++) {
                // Exporting file types are CSV
                $newFileArray[] = $new_file = $file.'_'.$index.'.'.config('constants.export_txt_file_type');
                $jobArray[] = new $exportClass($index, $itemCountBatching, $new_file, $filters, $checkboxValues, $search, $extraParam);
            }

            // Check if job array is empty
            if (! $jobArray) {
                return ['status' => false, 'message' => __('messages.common_error_message')];
            }

            // Dispatch batch job and return status and data
            $batchId = Bus::batch($jobArray)->name($batchName)->dispatch()->id;

            return ['status' => true, 'data' => [
                'batchId' => $batchId,
                'folder' => $folder,
                'newFileArray' => $newFileArray,
                'isFileDownloadable' => 0,
                'exportProgress' => 0,
                'waitingMessage' => Helper::getRandomExportWaitingMessage(),
                'downloadPrefixFileName' => $downloadPrefixFileName,
                'headingColumn' => $headingColumn,
            ]];
        } catch (Throwable $e) {
            // Log any exceptions during export job
            logger()->error('app/Helper.php: runExportJob: Throwable', [
                'Message' => $e->getMessage(), 'TraceAsString' => $e->getTraceAsString(),
                'totalRecord' => $totalRecord, 'filters' => $filters, 'checkboxValues' => $checkboxValues, 'search' => $search, 'headingColumn' => $headingColumn,
                'downloadPrefixFileName' => $downloadPrefixFileName, 'exportClass' => $exportClass, 'batchName' => $batchName, 'extraParam' => $extraParam,
            ]);

            return ['status' => false, 'message' => __('messages.common_error_message')];
        }
    }

    public static function putExportData($className, $final_data, $file, $sr_no): bool
    {
        try {
            // Check if final data is empty
            if (! ($final_data && is_array($final_data))) {
                logger()->error('app/Helper.php: appendExportData: There is no data to append', ['className' => $className, 'final_data' => $final_data, 'file' => $file, 'sr_no' => $sr_no]);

                return false;
            }

            // Generate CSV content from final data and store in storage
            $final_string = null;
            foreach ($final_data as $i => $data) {
                // $data = array_merge(['index' => ++$sr_no], $data);
                $final_string .= '"'.implode('","', $data).'"'."\n";
            }

            // Store CSV content in storage
            if ($final_string) {
                // Storage::put($file, trim($final_string, "\n"));
                Storage::put($file, $final_string);

                return true;
            } else {
                return false;
            }
        } catch (Throwable $e) {
            // Log any exceptions during data export
            logger()->error('app/Helper.php: appendExportData: Throwable', [
                'Message' => $e->getMessage(), 'TraceAsString' => $e->getTraceAsString(),
                'className' => $className, 'final_data' => $final_data, 'file' => $file, 'sr_no' => $sr_no,
            ]);

            return false;
        }
    }

    public static function processProgressOfExport($functionParams)
    {
        try {
            // Decode function parameters
            $params = json_decode($functionParams, true);

            // Check if batch ID is provided
            if (! $params['batchId']) {
                logger()->error('app/Helper.php: downloadExportFile: batchId not found', ['functionParams' => $functionParams, 'params' => $params]);

                return ['status' => 0, 'message' => __('messages.common_error_message')];
            }

            // Find batch and check for failed jobs
            $batch = Bus::findBatch($params['batchId']);
            if ($batch->failedJobs) {
                logger()->error('app/Helper.php: downloadExportFile: failedJobs', ['functionParams' => $functionParams, 'params' => $params, 'failedJobs' => $batch->failedJobs]);

                return ['status' => 0, 'message' => __('messages.common_error_message')];
            }

            // Check if file is downloadable and batch is finished
            if (isset($params['isFileDownloadable']) && $params['isFileDownloadable'] && $batch->finished()) {
                $downloadableResponse = Helper::downloadExportFile($functionParams);

                return ['status' => 2, 'message' => 'Exporting Successfully.', 'data' => $downloadableResponse];

                /*$downloadableResponse = Helper::mergeExportFile($functionParams);
            if ($downloadableResponse['status']) {

            return ['status' => 2, 'message' => 'Exporting Successfully.', 'data' => $downloadableResponse['data']];
            } else {

            return ['status' => 0, 'message' => $downloadableResponse['message']];
            }*/
            }

            // Get export progress and update parameters
            $exportProgress = $batch->progress();
            if (isset($params['exportProgress']) && ($params['exportProgress'] != $exportProgress)) {
                // Messages are only change when percentage will change
                $params['waitingMessage'] = Helper::getRandomExportWaitingMessage();
            }

            $params['exportProgress'] = $exportProgress;
            // We are displaying 100% first, after we will process download file. For that we have added isFileDownloadable condition.
            $params['isFileDownloadable'] = $exportProgress == 100 ? 1 : 0;

            return ['status' => 1, 'data' => json_encode($params)];
        } catch (Throwable $e) {
            // Log any exceptions during export progress processing
            logger()->error('app/Helper.php: downloadExportFile: Throwable', ['Message' => $e->getMessage(), 'TraceAsString' => $e->getTraceAsString(), 'functionParams' => $functionParams]);

            return ['status' => 0, 'message' => __('messages.common_error_message')];
        }
    }

    public static function getRandomExportWaitingMessage()
    {
        try {
            // Get random export waiting message
            $exportWaitingMessageArray = __('messages.export.export_waiting_message');

            return $exportWaitingMessageArray[array_rand($exportWaitingMessageArray)];
        } catch (Throwable $e) {
            // Log any exceptions during random message fetching
            logger()->error('app/Helper.php: downloadExportFile: Throwable', ['Message' => $e->getMessage(), 'TraceAsString' => $e->getTraceAsString()]);

            return 'Your export is in progress. Thank you for your patience!';
        }
    }

    public static function downloadExportFile($functionParams)
    {
        try {
            // Decode function parameters
            $params = json_decode($functionParams, true);

            // Get parameters for download file
            $headingColumn = $params['headingColumn'];
            $newFileArray = $params['newFileArray'];
            $folder = $params['folder'];
            $downloadFileName = $params['downloadPrefixFileName'].date('dmY').'.'.config('constants.export_csv_file_type');

            // Stream download of export file
            return response()->streamDownload(function () use ($headingColumn, $newFileArray, $folder) {
                echo $headingColumn."\n";
                foreach ($newFileArray as $file) {
                    echo Storage::get($file);
                }
                // We removed directory from storage after downloaded
                Storage::deleteDirectory($folder);
            }, $downloadFileName);
        } catch (Throwable $e) {
            // Log any exceptions during export file download
            logger()->error('app/Helper.php: downloadExportFile: Throwable', ['Message' => $e->getMessage(), 'TraceAsString' => $e->getTraceAsString()]);
        }
    }

    public static function mergeExportFile($functionParams): array
    {
        try {
            // Decode function parameters
            $params = json_decode($functionParams, true);

            // Get parameters for download file
            $headingColumn = $params['headingColumn'];
            $newFileArray = $params['newFileArray'];
            $folder = $params['folder'];
            $downloadFileName = $params['downloadPrefixFileName'].date('dmY').'.'.config('constants.export_csv_file_type');
            $mergedFileName = $folder.$downloadFileName;
            Storage::put($mergedFileName, $headingColumn, 'public');
            foreach ($newFileArray as $file) {
                Storage::append($mergedFileName, Storage::get($file));
            }

            return [
                'status' => true, 'message' => 'Merge Successfully.',
                'data' => json_encode(['downloadUrl' => Storage::url($mergedFileName), 'downloadFileName' => $downloadFileName]),
            ];
        } catch (Throwable $e) {
            // Log any exceptions during export file download
            logger()->error('app/Helper.php: mergeExportFile: Throwable', ['Message' => $e->getMessage(), 'TraceAsString' => $e->getTraceAsString()]);

            return ['status' => false, 'message' => __('messages.common_error_message')];
        }
    }

    public static function getIp()
    {
        foreach (['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'] as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }

        return request()->ip(); // it will return server ip when no client ip found
    }

    public static function getAllLegends()
    {
        /*try {
            $userModel = new User;
            $legendsArray['Users'] = $userModel->legend;

            return $legendsArray;
        } catch (Throwable $e) {
            // Log any exceptions during export file download
            logger()->error('app/Helper.php: getAllLegends: Throwable', ['Message' => $e->getMessage(), 'TraceAsString' => $e->getTraceAsString()]);
        }*/
    }

    public static function getAllRoles()
    {
        return Role::pluck('name', 'id')->toArray();
        //return Cache::rememberForever('getAllRoles', function () {
           // return Role::pluck('name', 'id')->toArray();
       // });
    }

    public static function getAllPermissions()
    {
        return Cache::rememberForever('getAllPermissions', function () {
            return Permission::select('id', 'name', 'guard_name', 'label')->get()->toArray();
        });
    }

    public static function getCachedPermissionsByRole($roleId)
    {
        return Cache::rememberForever("getCachedPermissionsByRole:$roleId", function () use ($roleId) {
            return PermissionRole::leftJoin('permissions', 'permissions.id', '=', 'permission_role.permission_id')
                ->where('permission_role.role_id', $roleId)->pluck('permissions.name')->toArray();
        });
    }

    /**
     * Log validation errors.
     *
     * @param string $controller_name Name of the controller where the error occurred.
     * @param string $function_name Name of the function where the error occurred.
     * @param Validator $validator Validator instance containing error details.
     * @param string $channel Optional log channel (default: 'validation').
     */
    public static function logValidationError(string $controller_name, string $function_name, Validator $validator, $user = null, string $channel = 'validation'): void
    {
        try {
            // Log detailed validation errors
            logger()->channel($channel)->error("$controller_name: $function_name: Validation error occurred. :", [
                "\nerrors_message" => $validator->errors()->all(),
                "\nkey_failed" => $validator->failed(),
                "\nall_request" => request()->all(),
                "\ndefault_auth_detail" => $user,
                "\nall_headers" => request()->headers->all(),
                "\nip_address" => self::getIp(),
            ]);
        } catch (Throwable $th) {
            // Log exception details if logging fails
            logger()->channel()->error(static::class . ': ' . __FUNCTION__ . ': Throwable', [
                'Message' => $th->getMessage(),
                'TraceAsString' => $th->getTraceAsString(),
                'controller_name' => $controller_name,
                'function_name' => $function_name,
                'validator' => $validator,
                'channel' => $channel,
            ]);
        }
    }

    /**
     * Log exceptions or errors with stack trace and additional details.
     *
     * @param Throwable $th The exception to be logged.
     * @param string $controller_name Name of the controller where the exception occurred.
     * @param string $function_name Name of the function where the exception occurred.
     * @param array $extra_param Optional additional parameters to include in the log.
     * @param string|null $channel Optional log channel (default: null).
     */
    public static function logCatchError(Throwable $th, string $controller_name, string $function_name, array $extra_param = [], $user = null, ?string $channel = null): void
    {
        try {
            // Prepare data for logging
            $dataArray = [
                "\nException" => $th->getMessage(),
                "\nTraceAsString" => $th->getTraceAsString(),
                "\nExtraParam" => $extra_param,
                "\nall_request" => request()->all(),
                "\ndefault_auth_detail" => $user,
                "\nall_headers" => request()->headers->all(),
                "\nip_address" => self::getIp(),
            ];

            // Log the exception
            logger()->channel($channel)->error("$controller_name: $function_name: Throwable:", $dataArray);

            // Notify Bugsnag of the exception with additional metadata
            // Bugsnag::notifyException($th, function ($report) use ($dataArray) {
            //     $report->setMetaData(['Additional Information' => $dataArray]);
            // });
        } catch (Throwable $th) {
            // Log details of any error occurring within this method
            logger()->channel()->error(static::class . ': ' . __FUNCTION__ . ': Throwable', [
                'Message' => $th->getMessage(),
                'TraceAsString' => $th->getTraceAsString(),
                'controller_name' => $controller_name,
                'function_name' => $function_name,
                'extra_param' => $extra_param,
                'channel' => $channel,
            ]);
        }
    }

    public static function logSingleError($controller_name, $function_name, $message, $extra_param = [], $user = null, $channel = null): void
    {
        try {
            $loggerMessage = "$controller_name: $function_name: $message";
            $dataArray = [
                "\nExtraParam" => $extra_param,
            ];
            logger()->channel($channel)->error($loggerMessage, $dataArray);
        } catch (Throwable $th) {
            // Log exception details for debugging purposes
            logger()->channel()->error(static::class . ': ' . __FUNCTION__ . ': Throwable', [
                'Message' => $th->getMessage(),
                'TraceAsString' => $th->getTraceAsString(),
                'controller_name' => $controller_name,
                'function_name' => $function_name,
                'message' => $message,
                'extra_param' => $extra_param,
                'channel' => $channel,
            ]);
        }
    }


    /**
     * Log general error messages with additional context.
     *
     * @param string $controller_name Name of the controller.
     * @param string $function_name Name of the function.
     * @param string $message Error message to log.
     * @param array $extra_param Optional additional parameters.
     * @param string|null $channel Optional log channel (default: null).
     */
    public static function logError(string $controller_name, string $function_name, string $message, array $extra_param = [], $user = null, ?string $channel = null): void
    {
        try {
            // Format the log message
            $loggerMessage = "$controller_name: $function_name: $message";

            // Prepare data for logging
            $dataArray = [
                "\nExtraParam" => $extra_param,
                "\nall_request" => request()->all(),
                "\ndefault_auth_detail" => $user,
                "\nall_headers" => request()->headers->all(),
                "\nip_address" => self::getIp(),
            ];

            // Log the error message
            logger()->channel($channel)->error($loggerMessage, $dataArray);

            // Notify Bugsnag with error details
            // Bugsnag::notifyError(__FUNCTION__, $loggerMessage, function ($report) use ($dataArray) {
            //     $report->setMetaData(['Additional Information' => $dataArray]);
            // });
        } catch (Throwable $th) {
            // Log exception details if logging fails
            logger()->channel()->error(static::class . ': ' . __FUNCTION__ . ': Throwable', [
                'Message' => $th->getMessage(),
                'TraceAsString' => $th->getTraceAsString(),
                'controller_name' => $controller_name,
                'function_name' => $function_name,
                'message' => $message,
                'extra_param' => $extra_param,
                'channel' => $channel,
            ]);
        }
    }

    /**
     * Log a single informational message with optional parameters.
     *
     * @param string $controller_name Name of the controller.
     * @param string $function_name Name of the function.
     * @param string $message Informational message to log.
     * @param array $extra_param Optional additional parameters.
     * @param string|null $channel Optional log channel (default: null).
     */
    public static function logSingleInfo(string $controller_name, string $function_name, string $message, array $extra_param = [], $user = null, ?string $channel = null): void
    {
        try {
            // Format the log message
            $loggerMessage = "$controller_name: $function_name: $message";

            // Prepare data for logging
            $dataArray = [
                "\nExtraParam" => $extra_param,
            ];

            // Log the informational message
            logger()->channel($channel)->info($loggerMessage, $dataArray);
        } catch (Throwable $th) {
            // Log exception details if logging fails
            logger()->channel()->error(static::class . ': ' . __FUNCTION__ . ': Throwable', [
                'Message' => $th->getMessage(),
                'TraceAsString' => $th->getTraceAsString(),
                'controller_name' => $controller_name,
                'function_name' => $function_name,
                'message' => $message,
                'extra_param' => $extra_param,
                'channel' => $channel,
            ]);
        }
    }

    /**
     * Log general informational messages with additional context.
     *
     * @param string $controller_name Name of the controller.
     * @param string $function_name Name of the function.
     * @param string $message Informational message to log.
     * @param array $extra_param Optional additional parameters.
     * @param string|null $channel Optional log channel (default: null).
     */
    public static function logInfo(string $controller_name, string $function_name, string $message, array $extra_param = [], $user = null, ?string $channel = null): void
    {
        try {
            // Format the log message
            $loggerMessage = "$controller_name: $function_name: $message";

            // Prepare data for logging
            $dataArray = [
                "\nExtraParam" => $extra_param,
                "\nall_request" => request()->all(),
                "\ndefault_auth_detail" => $user,
                "\nall_headers" => request()->headers->all(),
                "\nip_address" => self::getIp(),
            ];

            // Log the informational message
            logger()->channel($channel)->info($loggerMessage, $dataArray);
        } catch (Throwable $th) {
            // Log exception details if logging fails
            logger()->channel()->error(static::class . ': ' . __FUNCTION__ . ': Throwable', [
                'Message' => $th->getMessage(),
                'TraceAsString' => $th->getTraceAsString(),
                'controller_name' => $controller_name,
                'function_name' => $function_name,
                'message' => $message,
                'extra_param' => $extra_param,
                'channel' => $channel,
            ]);
        }
    }


}
