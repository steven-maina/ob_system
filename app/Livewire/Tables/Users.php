<?php

namespace App\Livewire\Tables;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class Users extends PowerGridComponent
{
    use WithExport;
  public int $perPage = 10;
  public string $tableName="Users List";

  public array $perPageValues = [0, 5, 10, 15, 20, 30, 50];

  public function setUp(): array
  {
    $this->showCheckBox();

    return [
      Exportable::make('export')
        ->striped()
        ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
      Header::make()->showSearchInput()
        ->showToggleColumns()
        ->includeViewOnBottom('components.datatable.header-bottom')
        ->includeViewOnTop('components.datatable.header-top'),
      Footer::make()
        ->showPerPage()
//                ->showRecordCount()
        ->showPerPage($this->perPage, $this->perPageValues)
        ->showRecordCount(mode: 'full')
        ->pagination('vendor.livewire.bootstrap'),
    ];
  }

    public function datasource(): Builder
    {
        return User::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('email')
            ->add('phone_number')
            ->add('phone_number_verified_at')
            ->add('email_verified_at')
            ->add('ward_id')
            ->add('subcounty_id')
            ->add('last_login_at')
            ->add('dob_formatted', fn (User $model) => Carbon::parse($model->dob)->format('d/m/Y'))
            ->add('gender')
            ->add('county_id')
            ->add('address')
            ->add('nationality')
            ->add('user_code')
            ->add('last_login_at')
            ->add('status')
            ->add('created_at');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Email', 'email')
                ->sortable()
                ->searchable(),

            Column::make('Phone number', 'phone_number')
                ->sortable()
                ->searchable(),

            Column::make('Phone number verified at', 'phone_number_verified_at_formatted', 'phone_number_verified_at')
                ->sortable(),

            Column::make('Phone number verified at', 'phone_number_verified_at')
                ->sortable()
                ->searchable(),

            Column::make('Email verified at', 'email_verified_at_formatted', 'email_verified_at')
                ->sortable(),

            Column::make('Email verified at', 'email_verified_at')
                ->sortable()
                ->searchable(),

            Column::make('Ward id', 'ward_id'),
            Column::make('Subcounty id', 'subcounty_id'),
            Column::make('Last login at', 'last_login_at_formatted', 'last_login_at')
                ->sortable(),

            Column::make('Last login at', 'last_login_at')
                ->sortable()
                ->searchable(),

            Column::make('Dob', 'dob_formatted', 'dob')
                ->sortable(),

            Column::make('Gender', 'gender')
                ->sortable()
                ->searchable(),

            Column::make('County id', 'county_id'),
            Column::make('Address', 'address')
                ->sortable()
                ->searchable(),

            Column::make('Nationality', 'nationality'),
            Column::make('User code', 'user_code')
                ->sortable()
                ->searchable(),

            Column::make('Last login at', 'last_login_at_formatted', 'last_login_at')
                ->sortable(),

            Column::make('Last login at', 'last_login_at')
                ->sortable()
                ->searchable(),

            Column::make('Status', 'status')
                ->sortable()
                ->searchable(),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::make('Created at', 'created_at')
                ->sortable()
                ->searchable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::datepicker('dob'),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }

    public function actions(User $row): array
    {
        return [
            Button::add('edit')
                ->slot('Edit: '.$row->id)
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('edit', ['rowId' => $row->id])
        ];
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
