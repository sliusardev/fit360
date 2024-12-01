<?php

namespace App\Filament\Widgets;

use App\Enums\RoleEnum;
use App\Models\Activity;
use App\Models\User;
use App\Services\UserService;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ResourceCountsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(trans('dashboard.clients'), resolve(UserService::class)->getClientCount())
                ->icon('heroicon-o-users'),
            Stat::make(trans('dashboard.trainers'), resolve(UserService::class)->getTrainerCount())
                ->icon('heroicon-o-users'),
            Stat::make(trans('dashboard.activities'), Activity::query()->count())
                ->icon('heroicon-o-calendar-days'),
        ];
    }
}
