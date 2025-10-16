<?php

namespace App\Filament\Resources\AdminResource\Pages;

use App\Filament\Resources\AdminResource;
use Filament\Forms;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

    class CreateAdmin extends CreateRecord
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
                    ->unique('users', 'email')
                    ->maxLength(255)
                    ->label('Email'),
                Forms\Components\TextInput::make('phone_number')
                    ->label('Numéro de téléphone')
                    ->regex('/^[0-9]{10}$/')
                    ->helperText('Le numéro doit contenir exactement 10 chiffres')
                    ->placeholder('0123456789'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->minLength(8)
                    ->label('Mot de passe')
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                Forms\Components\Hidden::make('is_admin')
                    ->default(true),
            ];
        }

        protected function mutateFormDataBeforeCreate(array $data): array
        {
            $data['is_admin'] = true;
            return $data;
        }

        protected function getRedirectUrl(): string
        {
            return $this->getResource()::getUrl('index');
        }
    }