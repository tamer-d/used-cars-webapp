<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?string $navigationLabel = 'Utilisateurs';
    protected static ?string $pluralModelLabel = 'Utilisateurs';

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            
            Split::make([
                    Tables\Columns\TextColumn::make('name')
                        ->weight(FontWeight::Bold)
                        ->searchable()
                        ->sortable(),
            Stack::make([
                TextColumn::make('email')
                        ->color('gray')
                        ->icon('heroicon-o-envelope')
                        ->copyable()
                        ->searchable(),

                TextColumn::make('phone_number')
                        ->icon('heroicon-o-phone')
                        ->color('gray')
                        ->copyable()
                        ->searchable(),
                ])->grow(),

                TextColumn::make('cars_count')
                        ->counts('cars')
                        ->label('Annonces')
                        ->alignRight()
                        ->badge(),

                TextColumn::make('created_at')
                        ->since()
                        ->label('Membre depuis')
                        ->alignRight()
                        ->color('gray'),
                ]),
            ])

        ->defaultSort('created_at', 'desc')
        ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
}


    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('is_admin', false);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
        ];
    }
}