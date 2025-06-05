<?php
namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\HeaderAction; 
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Actions\ExportAction;

use Filament\Actions\Exports\Enums\ExportFormat;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Shop';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->required(),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('stock')
                    ->numeric()
                    ->required(),
                Forms\Components\FileUpload::make('image')
                ->directory('product-images')
                    ->image(),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock')
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                ExportAction::make('exportProducts') 
                ->label('Exporter la liste des produits')
                ->icon('heroicon-o-document-arrow-down')
                ->exporter(\App\Filament\Exports\ProductExporter::class)
                ->formats([
                    ExportFormat::Xlsx,
                    ExportFormat::Csv,
                ]), 
                ExportAction::make('exportStockSheet') 
                ->label('Exporter la fiche de stock')
                ->icon('heroicon-o-document-text')
                ->exporter(\App\Filament\Exports\StockSheetExporter::class)
                ->formats([
                    ExportFormat::Xlsx,
                    ExportFormat::Csv,
                ]), 
                /* // Exporter la liste des produits
                Action::make('exportProducts')
                    ->label('Exporter la liste des produits')
                    ->icon('heroicon-o-document-arrow-down')
                    ->action(function () {
                        return Excel::download(new ProductsExport, 'liste-produits.xlsx');
                    }),
                // Exporter une fiche de stock
                Action::make('exportStockSheet')
                    ->label('Exporter la fiche de stock')
                    ->icon('heroicon-o-document-text')
                    ->action(function () {
                        return Excel::download(new StockSheetExport, 'fiche-stock.xlsx');
                    }), */
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                ActionGroup::make([
                    Action::make('addStock')
                        ->label('Ajouter du stock')
                        ->icon('heroicon-o-plus')
                        ->form([
                            Forms\Components\TextInput::make('quantity')
                                ->numeric()
                                ->required()
                                ->label('Quantité à ajouter')
                                ->minValue(1)
                                ->rules(['integer', 'min:1']),
                            Forms\Components\Textarea::make('notes')
                                ->label('Notes')
                                ->nullable(),
                        ])
                        ->action(function (Product $record, array $data): void {
                            $record->addStock($data['quantity'], $data['notes']);
                            Notification::make()
                                ->title('Stock mis à jour')
                                ->body("Le stock a été augmenté de {$data['quantity']} unités.")
                                ->success()
                                ->send();
                        }),
                    Action::make('removeStock')
                        ->label('Réduire le stock')
                        ->icon('heroicon-o-minus')
                        ->form([
                            Forms\Components\TextInput::make('quantity')
                                ->numeric()
                                ->required()
                                ->label('Quantité à réduire')
                                ->minValue(1)
                                ->rules(['integer', 'min:1'])
                                ->maxValue(fn (Product $record) => $record->stock)
                                ->rules(['lte:stock']),
                            Forms\Components\Textarea::make('notes')
                                ->label('Notes')
                                ->nullable(),
                        ])
                        ->action(function (Product $record, array $data): void {
                            if ($data['quantity'] > $record->stock) {
                                Notification::make()
                                    ->title('Erreur')
                                    ->body('La quantité à réduire dépasse le stock disponible.')
                                    ->danger()
                                    ->send();
                                return;
                            }
                            $record->removeStock($data['quantity'], $data['notes']);
                            Notification::make()
                                ->title('Stock mis à jour')
                                ->body("Le stock a été réduit de {$data['quantity']} unités.")
                                ->success()
                                ->send();
                        }),
                ])
                    ->label('Gérer le stock')
                    ->icon('heroicon-o-ellipsis-vertical')
                    ->color('primary')
                    ->dropdown(true),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    BulkAction::make('addStockBulk')
                        ->label('Ajouter du stock à plusieurs produits')
                        ->icon('heroicon-o-plus')
                        ->form([
                            Forms\Components\TextInput::make('quantity')
                                ->numeric()
                                ->required()
                                ->label('Quantité à ajouter')
                                ->minValue(1)
                                ->rules(['integer', 'min:1']),
                            Forms\Components\Textarea::make('notes')
                                ->label('Notes')
                                ->nullable(),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            foreach ($records as $record) {
                                $record->addStock($data['quantity'], $data['notes']);
                            }
                            Notification::make()
                                ->title('Stock mis à jour')
                                ->body("Le stock a été augmenté de {$data['quantity']} unités pour les produits sélectionnés.")
                                ->success()
                                ->send();
                        }),
                    BulkAction::make('removeStockBulk')
                        ->label('Réduire le stock de plusieurs produits')
                        ->icon('heroicon-o-minus')
                        ->form([
                            Forms\Components\TextInput::make('quantity')
                                ->numeric()
                                ->required()
                                ->label('Quantité à réduire')
                                ->minValue(1)
                                ->rules(['integer', 'min:1']),
                            Forms\Components\Textarea::make('notes')
                                ->label('Notes')
                                ->nullable(),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            foreach ($records as $record) {
                                if ($data['quantity'] > $record->stock) {
                                    Notification::make()
                                        ->title('Erreur')
                                        ->body("La quantité à réduire dépasse le stock disponible pour le produit {$record->name}.")
                                        ->danger()
                                        ->send();
                                    continue;
                                }
                                $record->removeStock($data['quantity'], $data['notes']);
                            }
                            Notification::make()
                                ->title('Stock mis à jour')
                                ->body("Le stock a été réduit de {$data['quantity']} unités pour les produits sélectionnés.")
                                ->success()
                                ->send();
                        }),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}