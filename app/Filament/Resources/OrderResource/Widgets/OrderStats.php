<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class OrderStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Orders', Order::count()),
            Stat::make("New Orders", Order::query()->where('status', 'new')->count()),
            Stat::make("Orders shipped", Order::query()->where('status', 'shipped')->count()),
            Stat::make("Orders Processing", Order::query()->where('status', 'processing')->count()),
            // Stat::make("Average price", Number::currency(Order::query()->avg('grand_total'), 'BDT')),
        ];
    }
}
