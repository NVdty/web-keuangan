<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $income = Transaction::incomes()->get()->sum('amount');
        $expense = Transaction::expenses()->get()->sum('amount');
        $difference = $income - $expense;

        return [
            Stat::make('Income', $this->formatToIdr($income)),
            Stat::make('Expense', $this->formatToIdr($expense)),
            Stat::make('Difference', $this->formatToIdr($difference)),
        ];
    }

    protected function formatToIdr($value)
    {
        return 'Rp ' . number_format($value, 0, ',', '.');
    }
    
}
