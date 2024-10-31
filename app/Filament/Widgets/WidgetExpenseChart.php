<?php

namespace App\Filament\Widgets;

use Flowframe\Trend\Trend;
use App\Models\Transaction;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class WidgetExpenseChart extends ChartWidget
{
    protected static ?string $heading = 'Expense';
    protected static string $color = 'danger';

    protected function getData(): array
    {
        $data = Trend::query(Transaction::expenses())
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perDay()
        ->sum('amount');
 
 
    return [
        'datasets' => [
            [
                'label' => 'Expense/day',
                'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
            ],
        ],
        'labels' => $data->map(fn (TrendValue $value) => $value->date),
    ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
