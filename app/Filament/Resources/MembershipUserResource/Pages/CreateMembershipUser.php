<?php

namespace App\Filament\Resources\MembershipUserResource\Pages;

use App\Filament\Resources\MembershipUserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMembershipUser extends CreateRecord
{
    protected static string $resource = MembershipUserResource::class;

    protected function getCreateFormActionLabel(): ?string
    {
        return trans('dashboard.assign') ?: 'Assign';
    }
}
