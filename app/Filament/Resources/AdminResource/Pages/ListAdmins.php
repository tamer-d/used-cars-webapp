<?php

namespace App\Filament\Resources\AdminResource\Pages;

use App\Filament\Resources\AdminResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdmins extends ListRecords
{
    protected static string $resource = AdminResource::class;

    protected function getHeaderActions(): array
    {
        if (!Auth::user()->isSuperAdmin()) {
            return [];
        }

        return [
            Actions\CreateAction::make()
            ->label('Add new admin'),
        ];
    }

    public function mount(): void
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Seul le super administrateur peut gérer les administrateurs.');
        }
        
        parent::mount();
    }
}
