<?php
namespace App\Livewire\Role;

use App\Helper;
use App\Jobs\ExportRoleTable;
use App\Models\Role;
use App\Traits\RefreshDataTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
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

    public string $sortField = 'roles.id';

    public string $sortDirection = 'desc';

    //Custom per page
    public int $perPage;

    //Custom per page values
    public array $perPageValues;

    public $currentUser;

    public function __construct()
    {
        if (! Gate::allows('view-role')) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->tableName     = __("messages.role.listing.tableName");
        $this->perPage       = config('constants.webPerPage');
        $this->perPageValues = config('constants.webPerPageValues');
    }

    public function exportData()
    {
        try {
            // Define export parameters
            $exportClass            = ExportRoleTable::class;
            $headingColumn          = 'Name,BgColor';
            $batchName              = 'Export Role Table';
            $downloadPrefixFileName = 'RoleReports_';
            $extraParam             = [];

            // Run export job and handle result
            $result = Helper::runExportJob($this->total, $this->filters, $this->checkboxValues, $this->search, $headingColumn, $downloadPrefixFileName, $exportClass, $batchName, $extraParam);
            if (! $result['status']) {
                // Dispatch error alert if export fails
                session()->flash('error', $result['message']);
                return false;
            }

            // Dispatch event to show export progress
            $this->dispatch('showExportProgressEvent', json_encode($result['data']))->to('common-code');
        } catch (Throwable $e) {
            // Log and dispatch error alert if exception occurs
            logger()->error('App\Livewire\RoleTable: exportData: Throwable', ['Message' => $e->getMessage(), 'TraceAsString' => $e->getTraceAsString()]);
            session()->flash('error', __('messages.role.messages.common_error_message'));
            return false;
        }
    }

    /**
     * header
     */
    public function header(): array
    {
        $headerArray[] = Button::add('add-role')
            ->render(function () {
                return Blade::render(
                    <<<'HTML'
                        <button
                            type="button"
                            class="btn btn-dark btn-custom-class sp-p"
                            @click="$dispatch('open-slide', { title: 'Add Role', component: 'role.create', params: {} })"
                        >
                            <i class="las la-plus fs-1"></i>
                        </button>
                    HTML
                );
            });

        if (Gate::allows('export-role')) {
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

        if (Gate::allows('bulkDelete-role')) {
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
        return Role::query()

            ->select([
                'roles.id', 'roles.name', 'roles.bg_color',
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
            Column::make(__('messages.role.listing.id'), 'id')->sortable(),

            Column::make(__('messages.role.listing.name'), 'name')
                ->sortable()
                ->searchable(),

            Column::make(__('messages.role.listing.bg_color'), 'bg_color')
                ->sortable()
                ->searchable(),
            Column::action(__('messages.role.listing.actions')),
        ];
    }

    /**
     * filters
     */
    public function filters(): array
    {
        return [
            Filter::inputText('name', 'roles.name')->operators(['contains']),

        ];
    }

    public function actions(\App\Models\Role $row): array
    {
        $actions = [];
        if (Gate::allows('show-role')) {
            $actions[] = Button::add('view')
                ->slot('<i class="las la-eye fs-2 me-2"></i>')
                ->class('btn btn-icon btn-light-secondary')
                ->tooltip(__('messages.tooltip.view'))
                ->dispatch('open-slide', ['title' => 'Role Details', 'component' => 'role.show', 'params' => [ 'id' => $row->id]]);
        }

        
        if (Gate::allows('edit-role')) {
            $actions[] = Button::add('edit')
                ->slot('<i class="las la-edit fs-2 me-2"></i>')
                ->class('btn btn-icon btn-light-secondary')
                ->tooltip(__('messages.tooltip.click_edit'))
                ->dispatch('open-slide', ['title' => 'Edit Role', 'component' => 'role.edit', 'params' => [ 'id' => $row->id]]);
        }
        
        if (Gate::allows('delete-role')) {
            $actions[] = Button::add('delete-role')
                ->slot('<i class="las la-trash fs-2 me-2"></i>')
                ->class('btn btn-icon btn-light-secondary block-unblock-modal btn-color-danger')
                ->tooltip(__('messages.tooltip.click_delete'))
                ->dispatchTo('role.delete', 'delete-confirmation', ['ids' => [$row->id], 'tableName' => $this->tableName]);
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
        $this->checkboxAll    = false;
        $this->checkboxValues = [];
    }

    #[\Livewire\Attributes\On('deSelectCheckBoxEvent')]
    public function deSelectCheckBox(): bool
    {
        $this->checkboxAll    = false;
        $this->checkboxValues = [];

        return true;
    }

    public function bulkDelete(): void
    {
        try {
            $this->dispatch('multiple-delete-confirmation', $this->checkboxValues);

            if (! empty($this->checkboxValues)) {
                $this->dispatch('delete-confirmation', ids: $this->checkboxValues, tableName: $this->tableName);
            } else {
                session()->flash('error', __('messages.role.messages.no_record_selected'));
            }
        } catch (Throwable $e) {
            logger()->error('App\Livewire\Role\Table: bulkDelete: Throwable', ['Message' => $e->getMessage(), 'TraceAsString' => $e->getTraceAsString()]);
            session()->flash('error', __('messages.role.messages.bulk_delete_fail_text'));
        }
    }
}
