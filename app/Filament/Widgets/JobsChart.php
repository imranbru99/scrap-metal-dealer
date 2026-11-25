<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class JobsChart extends ChartWidget
{
    protected static ?string $heading = 'Rentals by Status';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $rows = Project::query()
            ->select('status', DB::raw('count(*) as aggregate'))
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        return [
            'datasets' => [
                [
                    'label' => 'Rentals',
                    'data' => $rows->values()->all(),
                    'backgroundColor' => ['#f07a1a', '#2a6f6b', '#3b82f6', '#22c55e', '#64748b', '#ef4444'],
                ],
            ],
            'labels' => $rows->keys()->map(fn ($s) => str_replace('_', ' ', ucfirst($s)))->all(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
