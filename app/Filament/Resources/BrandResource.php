<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrandResource\Pages;
use App\Filament\Resources\BrandResource\RelationManagers;
use App\Models\Brand;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;
    protected static ?string $navigationGroup = 'Vehicle Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                    
                Forms\Components\FileUpload::make('logo')
                    ->image()
                    ->directory('brands')
                    ->disk('public')
                    ->visibility('public')
                    ->maxSize(2048) // 2MB max
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->helperText('Accepted formats: JPG, PNG, WebP. Max size: 2MB')
                    ->deleteUploadedFileUsing(fn ($file) => Storage::disk('public')->delete($file))
                    ->getUploadedFileNameForStorageUsing(
                        fn (TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                            ->prepend('brand-logo-'),
                    ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->label('Logo')
                    ->height(60)
                    ->width(60)
                    ->circular()
                    ->getStateUsing(fn ($record) => 
                        $record->logo 
                            ? asset('storage/' . $record->logo)
                            : asset('images/default-brand.png')
                    ),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()    
                    ->searchable(),
                Tables\Columns\TextColumn::make('cars_count')
                    ->counts('cars')
                    ->sortable()
                    ->label('Number of Cars'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])     
            ->paginated(false)
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function ($records) {
                            foreach ($records as $record) {
                                if ($record->logo) {
                                    Storage::disk('public')->delete($record->logo);
                                }
                            }
                        }),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ModelsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBrands::route('/'),
            'view' => Pages\ViewBrand::route('/{record}'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Brand Information')
                    ->schema([
                        Infolists\Components\Split::make([
                            Infolists\Components\Grid::make(2)
                                ->schema([
                                    Infolists\Components\Group::make([
                                        Infolists\Components\TextEntry::make('name')
                                            ->label('Brand Name')
                                            ->size(Infolists\Components\TextEntry\TextEntrySize::Large)
                                            ->weight('bold')
                                            ->color('primary'),
                                            
                                        Infolists\Components\TextEntry::make('models_count')
                                            ->label('Number of Models')
                                            ->getStateUsing(fn ($record) => $record->models()->count())
                                            ->badge()
                                            ->color('info'),
                                            
                                        Infolists\Components\TextEntry::make('cars_count')
                                            ->label('Number of Cars')
                                            ->getStateUsing(fn ($record) => $record->cars()->count())
                                            ->badge()
                                            ->color('success'),
                                            
                                        Infolists\Components\TextEntry::make('created_at')
                                            ->label('Created At')
                                            ->dateTime('d/m/Y at H:i'),
                                    ]),
                                ]),
                                Infolists\Components\Group::make([
                                        Infolists\Components\ImageEntry::make('logo')
                                            ->label('Logo')
                                            ->height(180)
                                            ->width(180)
                                            ->getStateUsing(function ($record) {
                                                if ($record->logo && file_exists(public_path('storage/' . $record->logo))) {
                                                    return asset('storage/' . $record->logo);
                                                }
                                                return asset('images/default-brand.svg');
                                            })
                                            ->hiddenLabel(),
                            ])
                            ->grow(false),
                        ]),
                    ])
                    ->collapsible(),
            ]);
    }
}
