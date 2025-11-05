<?php

namespace App\Filament\Resources\MembershipUserResource\Pages;

use App\Filament\Resources\MembershipUserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMembershipUser extends EditRecord
{
    protected static string $resource = MembershipUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
