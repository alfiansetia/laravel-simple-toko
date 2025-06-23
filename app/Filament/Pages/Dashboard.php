<?php

namespace App\Filament\Pages;

use App\Filament\Resources\UserResource\Widgets\StatsOverview;
use App\Filament\Widgets\TransactionChart;
use Filament\Pages\Dashboard as PagesDashboard;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;

class Dashboard extends PagesDashboard
{
    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }

    public function getWidgets(): array
    {
        return [
            AccountWidget::class,
            FilamentInfoWidget::class,
            TransactionChart::class,
        ];
    }
}
