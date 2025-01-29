<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Companies;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;

class CompaniesTableRa extends DataTableComponent
{
    protected $model = Companies::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setFilterLayout('slide-down')
            ->setFilterLayoutPopover()
            ->setTableAttributes([
                'class' => 'table table-striped table-hover table-bordered',
                'id' => 'companies-table'
            ])
            ->setTableWrapperAttributes([
                'class' => 'table-responsive shadow-sm rounded bg-white p-3',
            ])
            ->setFilterPillsStatus(true)
            ->setFiltersVisibilityStatus(true)
            ->setFiltersStatus(true)
            ->setFilterPillsEnabled()
            ->setFilterPillsEnabled()
            ->setTheadAttributes([
                'class' => 'thead-light',
                'style' => 'background-color: #f8f9fa;'
            ])
            ->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
                return [
                    'class' => 'align-middle',
                    'style' => 'vertical-align: middle;'
                ];
            })
            ->setSearchEnabled()
            ->setSearchStatus(true);
    }

    public function filters(): array
    {
        return [
            DateFilter::make('Created From')
                ->setFilterPillTitle('Fecha Desde')
                ->setFilterPillValues([
                    'yesterday' => 'Ayer',
                    'today' => 'Hoy',
                    'last_week' => 'Última Semana',
                    'last_month' => 'Último Mes',
                ])
                ->config([
                    'class' => 'form-control form-control-sm',
                    'placeholder' => 'Select start date...'
                ])
                ->filter(function (Builder $builder, string $value) {
                    $builder->whereDate('created_at', '>=', $value);
                }),

            DateFilter::make('Created To')
                ->setFilterPillTitle('Fecha Hasta')
                ->setFilterPillValues([
                    'yesterday' => 'Ayer',
                    'today' => 'Hoy',
                    'last_week' => 'Última Semana',
                    'last_month' => 'Último Mes',
                ])
                ->config([
                    'class' => 'form-control form-control-sm',
                    'placeholder' => 'Select end date...'
                ])
                ->filter(function (Builder $builder, string $value) {
                    $builder->whereDate('created_at', '<=', $value);
                }),

            SelectFilter::make('Status')
                ->setFilterPillTitle('Estado')
                ->setFilterPillValues([
                    '1' => 'Active',
                    '0' => 'Inactive',
                    '2' => 'Pending'
                ])
                ->options([
                    '' => 'All Status',
                    '1' => 'Active',
                    '0' => 'Inactive',
                    '2' => 'Pending'
                ])
                ->filter(function (Builder $builder, string $value) {
                    if ($value !== '') {
                        $builder->where('status', $value);
                    }
                }),

            TextFilter::make('City')
                ->setFilterPillTitle('Ciudad')
                ->config([
                    'placeholder' => 'Search by city...',
                    'maxlength' => '25',
                    'class' => 'form-control form-control-sm'
                ])
                ->filter(function (Builder $builder, string $value) {
                    $builder->where('city', 'like', '%' . $value . '%');
                }),
        ];
    }

    public function builder(): Builder
    {
        return Companies::query()
            ->when($this->getAppliedFilterWithValue('Created From'),
                fn($query, $date) => $query->whereDate('created_at', '>=', $date)
            )
            ->when($this->getAppliedFilterWithValue('Created To'),
                fn($query, $date) => $query->whereDate('created_at', '<=', $date)
            );
    }

    #[On('success_messages_changes')]
    public function refresh()
    {
        // La tabla se refrescará cuando cambie el estado
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable()
                ->attributes(fn($row) => [
                    'class' => 'font-weight-bold',
                ]),

            Column::make('Legal Name', 'legal_name')
                ->sortable()
                ->searchable()
                ->attributes(fn($row) => [
                    'class' => 'text-wrap',
                ]),

            Column::make('Email', 'email')
                ->sortable()
                ->searchable()
                ->attributes(fn($row) => [
                    'class' => 'text-center',
                ]),

            Column::make('Phone', 'phone')
                ->sortable()
                ->searchable()
                ->attributes(fn($row) => [
                    'class' => 'text-center',
                ]),

            Column::make('Status', 'status')
                ->sortable()
                ->format(function ($value) {
                    // Agregamos un log para ver qué valor está llegando
                    \Log::info('Status value:', ['value' => $value]);

                    $class = match ((string)$value) {  // Convertimos a string para asegurar la comparación
                        '1', 1 => 'badge badge-success',
                        '0', 0 => 'badge badge-danger',
                        '2', 2 => 'badge badge-warning',
                        default => 'badge badge-secondary'
                    };

                    $text = match ((string)$value) {
                        '1', 1 => 'Active',
                        '0', 0 => 'Inactive',
                        '2', 2 => 'Pending',
                        default => 'Unknown (' . $value . ')'  // Agregamos el valor para debug
                    };

                    return "<span class='{$class}'>{$text}</span>";
                })
                ->html()
                ->attributes(fn($row) => [
                    'class' => 'text-center',
                ]),
            Column::make('Type', 'type_company')
                ->sortable()
                ->format(fn($value) => ucfirst($value))
                ->attributes(fn($row) => [
                    'class' => 'text-center',
                ]),

            Column::make('Created At', 'created_at')
                ->sortable()
                ->format(function ($value) {
                    return $value ? Carbon::parse($value)->format('d/m/Y H:i') : '';
                })
                ->attributes(fn($row) => [
                    'class' => 'text-center',
                ]),
            Column::make('Documents', 'id')
                ->format(function ($value) {
                    return '<button type="button"
                        wire:click="$dispatch(\'detailCompany\', { id: ' . $value . ' })"
                        class="btn btn-secondary btn-sm"
                        title="Ver Documentos">
                    <i class="fas fa-file"></i> Ver Documentos
                </button>';
                })
                ->html()
                ->attributes(fn($row) => [
                    'class' => 'text-center',
                ]),
            Column::make('Ver Más', 'id')
                ->format(function ($value) {
                    return '<a href="/companie/info/' . $value . '"
                  class="btn btn-primary btn-sm"
                  title="Ver Más">
                <i class="fas fa-external-link-alt"></i> Ver Más
              </a>';
                })
                ->html()
                ->attributes(fn($row) => [
                    'class' => 'text-center',
                ]),
            Column::make('Aceptar', 'id')
                ->format(function ($value) {
                    return '<button type="button"
                        wire:click="$dispatch(\'changeStateCompany\', { id: ' . $value . ', stateChanges: 1 })"
                        class="btn btn-success btn-sm"
                        title="Aceptar">
                    <i class="fas fa-check"></i> Aceptar
                </button>';
                })
                ->html()
                ->attributes(fn($row) => [
                    'class' => 'text-center',
                ]),

// Columna para Rechazar
            Column::make('Rechazar', 'id')
                ->format(function ($value) {
                    return '<button type="button"
                        wire:click="$dispatch(\'changeStateCompany\', { id: ' . $value . ', stateChanges: 0 })"
                        class="btn btn-danger btn-sm"
                        title="Rechazar">
                    <i class="fas fa-times"></i> Rechazar
                </button>';
                })
                ->html()
                ->attributes(fn($row) => [
                    'class' => 'text-center',
                ])
            ,

//            Column::make('Actions', 'id')
//                ->format(function ($value) {
//                    return view('components.table-actions', ['id' => $value])->render();
//                })
//                ->html()
//                ->attributes(fn($row) => [
//                    'class' => 'text-center',
//                ]),
        ];
    }

    public function customView(): string
    {
        return 'components.custom-table-wrapper';
    }
}
