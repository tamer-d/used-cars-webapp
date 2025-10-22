<?php

namespace App\Filament\Resources\AdminResource\Pages;

use App\Filament\Resources\AdminResource;
use Filament\Forms;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class CreateAdmin extends CreateRecord
{
    protected static string $resource = AdminResource::class;

    public function mount(): void
    {
        // Vérifier que seul le super admin peut créer des admins
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Seul le super administrateur peut créer des administrateurs.');
        }
        
        parent::mount();
    }

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
                ->label('Email')
                ->helperText('Cet email ne pourra pas être celui du super administrateur'),
            Forms\Components\TextInput::make('phone_number')
                ->label('Numéro de téléphone')
                ->regex('/^[0-9]{10}$/')
                ->helperText('Le numéro doit contenir exactement 10 chiffres')
                ->placeholder('0123456789'),
            Forms\Components\TextInput::make('password')
                ->password()
                ->required()
                ->minLength(8)
                ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
            Forms\Components\Hidden::make('is_admin')
                ->default(true),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if ($data['email'] === \App\Models\User::SUPER_ADMIN_EMAIL) {
            $this->halt();
            $this->addError('email', 'Impossible de créer un administrateur avec cet email.');
            return $data;
        }
        
        $data['is_admin'] = true;
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}