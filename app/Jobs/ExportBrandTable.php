<?php

namespace App\Jobs;

use App\Helper;
use App\Models\Brand;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ExportBrandTable implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $index;

    public $itemCountBatching;

    public $file;

    public $filters;

    public $checkboxValues;

    public $search;

    public $extraParam;

    /**
     * Create a new job instance.
     */
    public function __construct($index, $itemCountBatching, $file, $filters, $checkboxValues, $search, $extraParam)
    {
        $this->index = $index;
        $this->itemCountBatching = $itemCountBatching;
        $this->file = $file;
        $this->filters = $filters;
        $this->checkboxValues = $checkboxValues;
        $this->search = $search;
        $this->extraParam = $extraParam;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Extract parameters
        $index = $this->index;
        $itemCountBatching = $this->itemCountBatching;
        $sr_no = $offset = ($index - 1) * $itemCountBatching;
        $file = $this->file;
        $search = $this->search;

        // Initialize query builder
        $query = Brand::query();

        $query
            ->select([
                'brands.id','brands.name','brands.remark',
                            DB::raw(
                            '(CASE
                                    WHEN brands.status = "'.config("constants.brand.status.key.active").'" THEN  "'.config("constants.brand.status.value.active").'"
                                    WHEN brands.status = "'.config("constants.brand.status.key.inactive").'" THEN  "'.config("constants.brand.status.value.inactive").'"
                            ELSE " "
                            END) AS status')
            ]);

        

                    // Apply name filters
                $where_name = $this->filters['input_text']['brands']['name'] ?? null;
                if ($where_name) {
                    $query->where('brands.name', 'like', "%$where_name%");
                }
                

                    // Apply remark filters
                $where_remark = $this->filters['input_text']['brands']['remark'] ?? null;
                if ($where_remark) {
                    $query->where('brands.remark', 'like', "%$where_remark%");
                }
                

                    // Apply status filters
                $where_status = $this->filters['select']['brands']['status'] ?? null;
                if ($where_status) {
                    $query->where('brands.status', $where_status);
                }
                

        // Apply checkbox filter: If brand select checkbox then only that result will be exported
        if ($this->checkboxValues) {
            $query->whereIn('brands.id', $this->checkboxValues);
        }

        // Apply search filter
        //if ($search) {
            //$query->where(function ($query) use ($search, $exportableColumns) {
              //  foreach ($exportableColumns as $column) {
               //     $query->orWhere($column, 'like', '%' . $search . '%');
              //  }
          //  });
      //  }

        // Execute query and fetch data
        $query_data = $query
            ->whereNull('brands.deleted_at')
            ->orderByDesc('brands.id')
            ->groupBy('brands.id')
            ->skip($offset)->take($itemCountBatching)->get()->toArray();

        // Convert query result to array
       // $final_data = json_decode(json_encode($query_data), true);

        $final_data = $query_data;

        // Call Helper method to put data into export file
        Helper::putExportData('ExportBrandTable', $final_data, $file, $sr_no);
    }
}
