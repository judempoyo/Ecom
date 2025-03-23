<?php
namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LowStockProductsList extends BaseWidget
{
    protected int | string | array $columnSpan = '1/2'; 

    protected function getTableQuery(): Builder
    {
        return Product::where('stock', '<', 10)->orderBy('stock', 'asc');
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->label('Nom')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('stock')
                ->label('Stock')
                ->sortable(),
            Tables\Columns\TextColumn::make('category.name')
                ->label('Catégorie')
                ->sortable(),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\EditAction::make(), // Optionnel : Ajouter une action pour éditer le produit
        ];
    }

    protected function isTablePaginationEnabled(): bool
    {
        return true; // Activer la pagination
    }
}