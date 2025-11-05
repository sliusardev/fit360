<?php

namespace App\Filament\Resources\MembershipUserResource\Pages;

use App\Filament\Resources\MembershipUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMembershipUsers extends ListRecords
{
    protected static string $resource = MembershipUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(trans('dashboard.assign_user_to_membership') ?: 'Assign user to membership')
                ->icon('heroicon-o-plus'),
        ];
    }
}
