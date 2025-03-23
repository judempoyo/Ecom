<?php
namespace App\Filament\Exports;

use App\Models\Product;
use App\Models\Category;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class StockSheetExporter extends Exporter
{
    protected static ?string $model = Product::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('category_name')
                ->label('Catégorie')
                ->state(function (Product $record): string {
                    return $record->category->name;
                }),
            ExportColumn::make('id')
                ->label('ID du Produit'),
            ExportColumn::make('name')
                ->label('Nom du Produit'),
            ExportColumn::make('stock')
                ->label('Stock Actuel'),
        ];
    }

    protected function getRecords(): array
    {
        // Récupérer toutes les catégories avec leurs produits
        $categories = Category::with('products')->get();

        $records = [];

        foreach ($categories as $category) {
            // Ajouter une ligne pour le nom de la catégorie
            $records[] = [
                'category_name' => $category->name,
                'id' => '',
                'name' => '',
                'stock' => '',
            ];

            // Ajouter les produits de la catégorie
            foreach ($category->products as $product) {
                $records[] = [
                    'category_name' => '', // Laisser vide pour éviter la répétition
                    'id' => $product->id,
                    'name' => $product->name,
                    'stock' => $product->stock,
                ];
            }

            // Ajouter une ligne vide pour séparer les catégories
            $records[] = [
                'category_name' => '',
                'id' => '',
                'name' => '',
                'stock' => '',
            ];
        }

        return $records;
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Votre exportation de la fiche de stock est terminée. ' . number_format($export->successful_rows) . ' ' . str('ligne')->plural($export->successful_rows) . ' exportées.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('ligne')->plural($failedRowsCount) . ' ont échoué.';
        }

        return $body;
    }
}ta