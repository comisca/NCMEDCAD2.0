<?php

namespace App\Livewire;

use App\Models\Companies;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class CompaniesTable extends PowerGridComponent
{
    public string $tableName = 'companies-table-p30pwq-table';

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Companies::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('legal_name')
            ->add('country')
            ->add('city')
            ->add('address')
            ->add('phone')
            ->add('facsimile')
            ->add('website')
            ->add('first_name')
            ->add('last_name')
            ->add('email')
            ->add('phone_contact')
            ->add('user_name')
            ->add('password')
            ->add('type_company')
            ->add('status')
            ->add('logo_companies')
            ->add('country_id')
            ->add('state_id')
            ->add('family_id')
            ->add('phone_whatsapp')
            ->add('created_at');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Legal name', 'legal_name')
                ->sortable()
                ->searchable(),

            Column::make('Country', 'country')
                ->sortable()
                ->searchable(),

            Column::make('City', 'city')
                ->sortable()
                ->searchable(),

            Column::make('Address', 'address')
                ->sortable()
                ->searchable(),

            Column::make('Phone', 'phone')
                ->sortable()
                ->searchable(),

            Column::make('Facsimile', 'facsimile')
                ->sortable()
                ->searchable(),

            Column::make('Website', 'website')
                ->sortable()
                ->searchable(),

            Column::make('First name', 'first_name')
                ->sortable()
                ->searchable(),

            Column::make('Last name', 'last_name')
                ->sortable()
                ->searchable(),

            Column::make('Email', 'email')
                ->sortable()
                ->searchable(),

            Column::make('Phone contact', 'phone_contact')
                ->sortable()
                ->searchable(),

            Column::make('User name', 'user_name')
                ->sortable()
                ->searchable(),

            Column::make('Password', 'password')
                ->sortable()
                ->searchable(),

            Column::make('Type company', 'type_company')
                ->sortable()
                ->searchable(),

            Column::make('Status', 'status')
                ->sortable()
                ->searchable(),

            Column::make('Logo companies', 'logo_companies')
                ->sortable()
                ->searchable(),

            Column::make('Country id', 'country_id'),
            Column::make('State id', 'state_id'),
            Column::make('Family id', 'family_id'),
            Column::make('Phone whatsapp', 'phone_whatsapp')
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
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert(' . $rowId . ')');
    }

    public function actions(Companies $row): array
    {
        return [
            Button::add('edit')
                ->slot('Edit: ' . $row->id)
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('edit', ['rowId' => $row->id])
        ];
    }

    public function bootstrap()
    {
        return config('livewire-powergrid.theme') === 'bootstrap';
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
