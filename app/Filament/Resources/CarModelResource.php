<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarModelResource\Pages;
use App\Models\CarModel;
use App\Models\Brand;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CarModelResource extends Resource
{
    protected static ?string $model = CarModel::class;

    protected static ?string $navigationGroup = 'Vehicle Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('brand_id')
                    ->label('Brand') 
                    ->relationship('brand', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->label('Brand Name') 
                            ->maxLength(255)
                            ->unique(Brand::class, 'name'),
                    ])
                    ->createOptionUsing(function (array $data): int {
                        return Brand::create($data)->getKey();
                    }),
                    
                Forms\Components\TextInput::make('name')
                    ->label('Model Name') 
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true, modifyRuleUsing: function ($rule, callable $get) {
                        return $rule->where('brand_id', $get('brand_id'));
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('brand.name')
                    ->label('Brand') 
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),
                    
                Tables\Columns\TextColumn::make('name')
                    ->label('Model') 
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                    
                Tables\Columns\TextColumn::make('cars_count')
                    ->label('Number of Cars') 
                    ->counts('cars')
                    ->sortable()
                    ->badge()
                    ->color('success'),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At') 
                    ->dateTime('d/m/Y')
                    ->sortable(),
                
            ])
            ->paginated(false)
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalSubmitActionLabel('Delete'), 
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Delete Selected Models') 
                        ->modalDescription('Are you sure you want to delete these models? This action will also delete all associated cars.') // Traduction de 'Êtes-vous sûr de vouloir supprimer ces modèles ? Cette action supprimera également toutes les voitures associées.'
                        ->modalSubmitActionLabel('Delete'), 
                ]),
            ])
            ->defaultSort('brand.name')
            ->striped();
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
            'index' => Pages\ListCarModels::route('/'),
            'create' => Pages\CreateCarModel::route('/create'),
            'view' => Pages\ViewCarModel::route('/{record}'),
            'edit' => Pages\EditCarModel::route('/{record}/edit'),
        ];
    }
}
