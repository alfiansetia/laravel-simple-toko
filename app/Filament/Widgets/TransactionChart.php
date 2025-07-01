<?php

namespace App\Filament\Widgets;

use App\Enums\TransactionStatus;
use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class TransactionChart extends ChartWidget
{
    protected static ?string $heading = 'Transaksi per Hari';

    protected function getData(): array
    {
        $data = Transaction::selectRaw('DATE(date) as tanggal, SUM(total) as total')
            ->where('status', TransactionStatus::DONE->value)
            ->groupBy(DB::raw('DATE(date)'))
            ->orderBy('tanggal')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Total Transaksi',
                    'data' => $data->pluck('total'),
                    'backgroundColor' => '#10b981', // Tailwind emerald-500
                ],
            ],
            'labels' => $data->pluck('tanggal')->map(fn($tgl) => date('d M', strtotime($tgl))),
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // atau 'line'
    }

    public function getColumnSpan(): int
    {
        return 12;
    }
}
