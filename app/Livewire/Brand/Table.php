<?php

namespace App\Livewire\Brand;

use App\Helper;
use App\Jobs\ExportBrandTable;
use App\Models\Brand;
use App\Traits\RefreshDataTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Responsive;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class Table extends PowerGridComponent
{
    use RefreshDataTable;

    public bool $deferLoading = true; // default false

    public string $tableName;

    public string $loadingComponent = 'components.my-custom-loading';

    public string $sortField = 'brands.id';

    public string $sortDirection = 'desc';

    //Custom per page
    public int $perPage;

    //Custom per page values
    public array $perPageValues;

    public $currentUser;

    public function __construct()
    {
        if (!Gate::allows('view-brand')) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->tableName = __("messages.brand.listing.tableName");
        $this->perPage = config('constants.webPerPage');
        $this->perPageValues = config('constants.webPerPageValues');
    }

    
            public function exportData()
            {
                try {
                    // Define export parameters
                    $exportClass = ExportBrandTable::class;
                    $headingColumn = 'Id,Name,Remark,Status';
                    $batchName = 'Export Brand Table';
                    $downloadPrefixFileName = 'BrandReports_';
                    $extraParam = [];

                    // Run export job and handle result
                    $result = Helper::runExportJob($this->total, $this->filters, $this->checkboxValues, $this->search, $headingColumn, $downloadPrefixFileName, $exportClass, $batchName, $extraParam);
                    if (!$result['status']) {
                        // Dispatch error alert if export fails
                        session()->flash('error', $result['message']);
                        return false;
                    }

                    // Dispatch event to show export progress
                    $this->dispatch('showExportProgressEvent', json_encode($result['data']))->to('common-code');
                } catch (Throwable $e) {
                    // Log and dispatch error alert if exception occurs
                    logger()->error('App\Livewire\BrandTable: exportData: Throwable', ['Message' => $e->getMessage(), 'TraceAsString' => $e->getTraceAsString()]);
                    session()->flash('error', __('messages.brand.messages.common_error_message'));
                    return false;
                }
            }
        

    /**
     * header
     */
    public function header(): array
    {
        $headerArray = [];
        if (Gate::allows('add-brand')) {

            $headerArray[] = Button::add('add-brand')
                ->render(function () {
                    return Blade::render(
                        <<<'HTML'
                          <a href="/brand/create" title="Add new" class="btn btn-dark btn-custom-class sp-p" wire:navigate><i class="las la-plus fs-1"></i></a>
                    HTML
                    );
                });
        }
        if (Gate::allows('export-brand')) {
            $headerArray[] = Button::add('export-data')
                ->render(function () {
                    return Blade::render(
                        <<<'HTML'
                          <a href="javascript:void(0);" title="Export Data" class="btn btn-success btn-custom-class sp-p" wire:click="exportData"><i class="las la-download fs-1"></i>
                            <span wire:loading wire:target="exportData"></span>
                          </a>
                        HTML
                    );
                });
        }

        if (Gate::allows('bulkDelete-brand')) {
            $headerArray[] = Button::add('bulk-delete')
                ->render(function () {
                    return Blade::render(
                        <<<'HTML'
                        <a href="javascript:void(0);" title="Bulk Delete" class="btn btn-danger btn-custom-class sp-p" wire:click="bulkDelete">
                            <i class="las la-trash fs-1"></i>
                            <span wire:loading wire:target="bulkDelete"></span>
                        </a>
                        HTML
                    );
                });
        }

        return $headerArray;
    }

    /**
     * setUp
     */
    public function setUp(): array
    {
        $this->showCheckBox();
        Responsive::make();

        return [
            Header::make(),

            Footer::make()
                ->showPerPage($this->perPage, $this->perPageValues)
                ->showRecordCount(),
        ];
    }

    /**
     * datasource
     */
    public function datasource(): Builder
    {
        // Main query
        return Brand::query()
            
            ->select([
                'brands.id','brands.name','brands.remark',
                                DB::raw(
                                '(CASE
                                        WHEN brands.status = "'.config("constants.brand.status.key.active").'" THEN  "'.config("constants.brand.status.value.active").'"
                                        WHEN brands.status = "'.config("constants.brand.status.key.inactive").'" THEN  "'.config("constants.brand.status.value.inactive").'"
                                ELSE " "
                                END) AS status')
            ]);
    }

    public function relationSearch(): array
    {
        return [];
    }

    /**
     * fields
     */
    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id');

    }

    /**
     * columns
     */
    public function columns(): array
    {
        return [
            Column::make(__('messages.brand.listing.id'), 'id')->sortable(),
                
                                    Column::make(__('messages.brand.listing.name'), 'name')
                                    ->sortable()
                                    ->searchable(),

                                    Column::make(__('messages.brand.listing.remark'), 'remark')
                                    ->sortable()
                                    ->searchable(),

                                    Column::make(__('messages.brand.listing.status'), 'status')
                                    ->sortable()
                                    ->searchable(),
            Column::action(__('messages.brand.listing.actions')),
        ];
    }

    /**
     * filters
     */
    public function filters(): array
    {
        return [
            Filter::inputText('name', 'brands.name')->operators(['contains']),
Filter::inputText('remark', 'brands.remark')->operators(['contains']),
Filter::select('status', 'status')
                    ->dataSource(Brand::status())
                    ->optionLabel('label')
                    ->optionValue('key'),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    /**
     * edit
     *
     * @param  mixed  $rowId
     * @return void
     */
    public function edit($id)
    {
        return $this->redirect('brand/'.$id.'/edit', navigate: true); // redirect to edit component
    }

    public function actions(\App\Models\Brand $row): array
    {
        $actions = [];
        if (Gate::allows('show-brand')) {
            $actions[] = Button::add('view')
                ->slot('<i class="las la-eye fs-2 me-2"></i>')
                ->class('btn btn-icon btn-light-secondary')
                ->tooltip(__('messages.tooltip.view'))
                ->dispatchTo('brand.show', 'show-brand-info', ['id' => $row->id, 'tableName' => $this->tableName]);
        }
        if (Gate::allows('edit-brand')) {
            $actions[] = Button::add('edit')
                ->bladeComponent('table-edit-action', ['idValue' => $row->id]);
        }
        if (Gate::allows('delete-brand')) {
            $actions[] = Button::add('delete-brand')
                ->slot('<i class="las la-trash fs-2 me-2"></i>')
                ->class('btn btn-icon btn-light-secondary block-unblock-modal btn-color-danger')
                ->tooltip(__('messages.tooltip.click_delete'))
                ->dispatchTo('brand.delete', 'delete-confirmation', ['ids' => array($row->id), 'tableName' => $this->tableName]);
        }

        return $actions;
    }

    /**
     * actionRules
     *
     * @param  mixed  $row
     */
    public function actionRules($row): array
    {
        return [];
    }

    /**
     * handlePageChange
     *
     * @return void
     */
    public function handlePageChange()
    {
        $this->checkboxAll = false;
        $this->checkboxValues = [];
    }

    #[\Livewire\Attributes\On('deSelectCheckBoxEvent')]
    public function deSelectCheckBox(): bool
    {
        $this->checkboxAll = false;
        $this->checkboxValues = [];

        return true;
    }

    public function bulkDelete(): void
    {
        try {
            $this->dispatch('multiple-delete-confirmation', $this->checkboxValues);

            if (!empty($this->checkboxValues)) {
                $this->dispatch('delete-confirmation', ids: $this->checkboxValues, tableName: $this->tableName);
            } else {
                session()->flash('error',  __('messages.brand.messages.no_record_selected'));
            }
        } catch (Throwable $e) {
            logger()->error('App\Livewire\Brand\Table: bulkDelete: Throwable', ['Message' => $e->getMessage(), 'TraceAsString' => $e->getTraceAsString()]);
            session()->flash('error',__('messages.brand.messages.bulk_delete_fail_text'));
        }
    }
}
