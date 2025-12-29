<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use App\Models\Payment;
use Carbon\Carbon;

class CollectionReport extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|\UnitEnum|null $navigationGroup = 'Reports';
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-chart-bar';
    protected string $view = 'filament.pages.collection-report';

    protected function getFormSchema(): array
    {
        return [
            \Filament\Schemas\Components\Grid::make(3)
                ->schema([
                    DatePicker::make('start_date')->required()->default(now()->startOfMonth()),
                    DatePicker::make('end_date')->required()->default(now()->endOfMonth()),
                    \Filament\Schemas\Components\Actions::make([
                        \Filament\Actions\Action::make('generate')
                            ->label('Generate Report')
                            ->action('generateReport'),
                    ])->alignCenter(),
                ]),
        ];
    }

    public $payments = [];
    public $total = 0;

    public function generateReport()
    {
        $data = $this->form->getState();
        
        $this->payments = Payment::whereBetween('payment_date', [
                Carbon::parse($data['start_date']),
                Carbon::parse($data['end_date']),
            ])
            ->with(['user', 'enrollment'])
            ->get();

        $this->total = $this->payments->sum('amount');
    }
}
