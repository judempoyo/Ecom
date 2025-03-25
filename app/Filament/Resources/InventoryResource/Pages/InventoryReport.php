<?php

namespace App\Filament\Resources\InventoryResource\Pages;

use App\Filament\Resources\InventoryResource;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\PageRegistration;

use App\Models\Inventory;
use Filament\Forms;
use Illuminate\Support\Facades\Blade;
use Barryvdh\DomPDF\Facade\Pdf;


class InventoryReport extends Page  implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static string $resource = InventoryResource::class;

    protected static string $view = 'filament.resources.inventory-resource.pages.inventory-report';



    public $start_date;
    public $end_date;
    public $movement_type;

      
    protected static string $route = 'report'; 


    protected function getFormSchema(): array
    {
        return [
            Forms\Components\DatePicker::make('start_date')
                ->label('Date de début')
                ->required(),
            Forms\Components\DatePicker::make('end_date')
                ->label('Date de fin')
                ->required(),
            Forms\Components\Select::make('movement_type')
                ->label('Type de mouvement')
                ->options([
                    'all' => 'Tous',
                    'in' => 'Entrées',
                    'out' => 'Sorties',
                ]),
        ];
    }

    public function generateReport()
    {
        $query = Inventory::query()
            ->whereBetween('created_at', [$this->start_date, $this->end_date])
            ->with('product');

        if ($this->movement_type && $this->movement_type !== 'all') {
            $query->where('movement_type', $this->movement_type);
        }

        $inventories = $query->get();

        return $inventories;
    }

    public function printReport()
    {
        $inventories = $this->generateReport();
        
        $pdf = Pdf::loadView('pdf.inventory-report', [
            'inventories' => $inventories,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);

        return $pdf->stream('inventory-report.pdf');
    }

}
