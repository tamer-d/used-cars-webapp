<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrandResource\Pages;
use App\Models\Brand;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
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
                    ->helperText('Formats acceptés: JPG, PNG, WebP. Taille max: 2MB')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
        ];
    }
}