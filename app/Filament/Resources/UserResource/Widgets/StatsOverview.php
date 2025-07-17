<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Enums\Role;
use App\Enums\TransactionStatus;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Customers', User::query()
                ->where('role', Role::USER->value)
                ->count())
                ->description('All Registered Customers')
                ->color('danger')
                ->url(route('filament.admin.resources.users.index')),
            Stat::make('Total Products', Product::query()
                ->count())
                ->description('All Products')
                ->color('primary')
                ->url(route('filament.admin.resources.products.index')),

            Stat::make('Total Success Orders', Transaction::query()
                ->where('status', TransactionStatus::DONE->value)
                ->count())
                ->description('All customer orders')
                ->color('success')
                ->url(route('filament.admin.resources.transactions.index')),
            Stat::make('Total Pending Orders', Transaction::query()
                ->where('status', TransactionStatus::PENDING->value)
                ->count())
                ->description('All pending orders')
                ->color('warning')
                ->url(route('filament.admin.resources.transactions.index')),
        ];
    }
}
