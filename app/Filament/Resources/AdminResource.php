<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;


class AdminResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?string $navigationLabel = 'Administrateurs';
    protected static ?string $pluralModelLabel = 'Administrateurs';

    public static function canAccess(): bool
    {
        return Auth::check() && Auth::user()->isSuperAdmin();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nom'),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->label('Email'),
                Forms\Components\TextInput::make('phone_number')
                    ->tel()
                    ->maxLength(255)
                    ->label('Numéro de téléphone'),
                Forms\Components\Hidden::make('is_admin')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Nom'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->label('Email'),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label('Téléphone'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Ajouté le'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->visible(fn ($record) => !$record->isSuperAdmin()),
                Tables\Actions\DeleteAction::make()->visible(fn ($record) => !$record->isSuperAdmin()) 
                    ->requiresConfirmation()
                    ->modalHeading('Supprimer cet administrateur')
                    ->modalDescription('Êtes-vous sûr de vouloir supprimer cet administrateur ? '),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->requiresConfirmation()
                        ->modalHeading('Supprimer les administrateurs sélectionnés')
                        ->modalDescription('Êtes-vous sûr de vouloir supprimer ces administrateurs ?')
                        ->action(function ($records) {
                            $records->filter(fn ($record) => !$record->isSuperAdmin())->each->delete();
                        }),
                ]),
            ])
            ->paginated(false);
    }


    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('is_admin', true);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }
}