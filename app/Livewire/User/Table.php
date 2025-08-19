<?php
namespace App\Livewire\User;

use App\Helper;
use App\Jobs\ExportUserTable;
use App\Models\User;
use App\Traits\RefreshDataTable;
use Illuminate\Database\Eloquent\Builder;
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

    public string $sortField = 'users.id';

    public string $sortDirection = 'desc';

    //Custom per page
    public int $perPage;

    //Custom per page values
    public array $perPageValues;

    public $currentUser;

    public function __construct()
    {
        if (! Gate::allows('view-user')) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->tableName     = __("messages.user.listing.tableName");
        $this->perPage       = config('constants.webPerPage');
        $this->perPageValues = config('constants.webPerPageValues');
    }

    public function exportData()
    {
        try {
            // Define export parameters
            $exportClass            = ExportUserTable::class;
            $headingColumn          = 'Id,Name,Email,Role,Dob,Profile,Country,State,City,Gender,Status,SortOrder';
            $batchName              = 'Export User Table';
            $downloadPrefixFileName = 'UserReports_';
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
            logger()->error('App\Livewire\UserTable: exportData: Throwable', ['Message' => $e->getMessage(), 'TraceAsString' => $e->getTraceAsString()]);
            session()->flash('error', __('messages.user.messages.common_error_message'));
            return false;
        }
    }

    /**
     * header
     */
    public function header(): array
    {
        $headerArray = [];
        if (Gate::allows('add-user')) {

            // $headerArray[] = Button::add('add-user')
            //     ->render(function () {
            //         return Blade::render(
            //             <<<'HTML'
            //               <a href="/user/create" title="Add new" class="btn btn-dark btn-custom-class sp-p" wire:navigate><i class="las la-plus fs-1"></i></a>
            //         HTML
            //         );
            //     });

            $headerArray[] = Button::add('add-user')
                ->render(function () {
                    return Blade::render(
                        <<<'HTML'
            <button
                type="button"
                class="btn btn-dark btn-custom-class sp-p"
                @click="$dispatch('open-slide', { title: 'Add User', component: 'user.create', params: {} })"
            >
                <i class="las la-plus fs-1"></i>
            </button>
        HTML
                    );
                });
        }
        if (Gate::allows('export-user')) {
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

        if (Gate::allows('bulkDelete-user')) {
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
        return User::query()->select([
            'users.id',
            'users.name',
            'users.email',
            'users.password',
            'users.dob',
            DB::raw(
                '(CASE
                            WHEN users.gender = "' . config("constants.user.gender.key.female") . '" THEN  "' . config("constants.user.gender.value.female") . '"
                            WHEN users.gender = "' . config("constants.user.gender.key.male") . '" THEN  "' . config("constants.user.gender.value.male") . '"
                    ELSE " "
                    END) AS gender'),
            DB::raw(
                '(CASE
                            WHEN users.status = "' . config("constants.user.status.key.active") . '" THEN  "' . config("constants.user.status.value.active") . '"
                            WHEN users.status = "' . config("constants.user.status.key.inactive") . '" THEN  "' . config("constants.user.status.value.inactive") . '"
                    ELSE " "
                    END) AS status'),
            'users.sort_order',
        ])->groupBy('users.id');
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
            Column::make(__('messages.user.listing.id'), 'id')->sortable(),

            Column::make(__('messages.user.listing.name'), 'name')
                ->sortable()
                ->searchable(),

            Column::make(__('messages.user.listing.email'), 'email')
                ->sortable()
                ->searchable(),

            Column::make(__('messages.user.listing.dob'), 'dob')
                ->sortable()
                ->searchable(),

            Column::make(__('messages.user.listing.gender'), 'gender')
                ->sortable()
                ->searchable(),

            Column::make(__('messages.user.listing.status'), 'status')
                ->sortable()
                ->searchable(),

            Column::make(__('messages.user.listing.sort_order'), 'sort_order')
                ->sortable()
                ->searchable(),
            Column::action(__('messages.user.listing.actions')),
        ];
    }

    /**
     * filters
     */
    public function filters(): array
    {
        return [
            Filter::inputText('name', 'users.name')->operators(['contains']),
            Filter::inputText('email', 'users.email')->operators(['contains']),
            Filter::datepicker('dob'),
            Filter::select('gender', 'gender')
                ->dataSource(User::gender())
                ->optionLabel('label')
                ->optionValue('key'),
            Filter::select('status', 'status')
                ->dataSource(User::status())
                ->optionLabel('label')
                ->optionValue('key'),
            Filter::inputText('sort_order', 'users.sort_order')->operators(['contains']),
        ];
    }

    public function actions(\App\Models\User $row): array
    {
        $actions = [];
        if (Gate::allows('show-user')) {
            $actions[] = Button::add('view')
                ->slot('<i class="las la-eye fs-2 me-2"></i>')
                ->class('btn btn-icon btn-light-secondary')
                ->tooltip(__('messages.tooltip.view'))
                ->dispatch('open-slide', ['title' => 'User Details', 'component' => 'user.show', 'params' => [ 'id' => $row->id]]);
        }

        if (Gate::allows('edit-user')) {
            $actions[] = Button::add('edit')
                ->slot('<i class="las la-edit fs-2 me-2"></i>')
                ->class('btn btn-icon btn-light-secondary')
                ->tooltip(__('messages.tooltip.click_edit'))
                ->dispatch('open-slide', ['title' => 'Edit User', 'component' => 'user.edit', 'params' => [ 'id' => $row->id]]);
        }

        if (Gate::allows('delete-user')) {
            $actions[] = Button::add('delete-user')
                ->slot('<i class="las la-trash fs-2 me-2"></i>')
                ->class('btn btn-icon btn-light-secondary block-unblock-modal btn-color-danger')
                ->tooltip(__('messages.tooltip.click_delete'))
                ->dispatchTo('user.delete', 'delete-confirmation', ['ids' => [$row->id], 'tableName' => $this->tableName]);
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
                session()->flash('error', __('messages.user.messages.no_record_selected'));
            }
        } catch (Throwable $e) {
            logger()->error('App\Livewire\User\Table: bulkDelete: Throwable', ['Message' => $e->getMessage(), 'TraceAsString' => $e->getTraceAsString()]);
            session()->flash('error', __('messages.user.messages.bulk_delete_fail_text'));
        }
    }
}
