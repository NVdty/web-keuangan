<?php

namespace App\Filament\Widgets;


use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    use InteractsWithPageFilters;
    protected function getStats(): array
    {
        $startDate = ! is_null($this->filters['startDate'] ?? null) ?
            Carbon::parse($this->filters['startDate']) :
            null;

        $endDate = ! is_null($this->filters['endDate'] ?? null) ?
            Carbon::parse($this->filters['endDate']) :
            now();
             

        $income = Transaction::incomes()->get()->whereBetween('date_transaction', [$startDate, $endDate])->sum('amount');
        $expense = Transaction::expenses()->get()->whereBetween('date_transaction', [$startDate, $endDate])->sum('amount');
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
