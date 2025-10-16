<?php

namespace App\Filament\Resources\AdminResource\Pages;

use App\Filament\Resources\AdminResource;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Pages\EditRecord;

class EditAdmin extends EditRecord
{
    protected static string $resource = AdminResource::class;

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->label('Nom'),
            Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->unique('users', 'email', ignoreRecord: true)
                ->maxLength(255)
                ->label('Email'),
            Forms\Components\TextInput::make('phone_number')
                ->tel()
                ->label('Numéro de téléphone')
                ->regex('/^[0-9]{10}$/')
                ->helperText('Le numéro doit contenir exactement 10 chiffres')
                ->placeholder('0123456789')
                ->validationMessages([
                    'regex' => 'Le numéro de téléphone doit contenir exactement 10 chiffres.',
                ]),
            Forms\Components\Hidden::make('is_admin')
                ->default(true),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['is_admin'] = true;
        return $data;
    }
    
    protected function getRedirectUrl(): string
    {
            return $this->getResource()::getUrl('index');
    }
}