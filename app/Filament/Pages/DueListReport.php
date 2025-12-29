<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use App\Models\Payment;
use Carbon\Carbon;

class DueListReport extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|\UnitEnum|null $navigationGroup = 'Reports';
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected string $view = 'filament.pages.due-list-report';

    protected function getFormSchema(): array
    {
        return [
            \Filament\Schemas\Components\Grid::make(3)
                ->schema([
                    \Filament\Forms\Components\Select::make('month')
                        ->options([
                            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                        ])
                        ->default(now()->month)
                        ->required(),
                    \Filament\Forms\Components\TextInput::make('year')
                        ->numeric()
                        ->default(now()->year)
                        ->required(),
                    \Filament\Schemas\Components\Actions::make([
                        \Filament\Actions\Action::make('generate')
                            ->label('Generate Report')
                            ->action('generateReport'),
                    ])->alignCenter(),
                ]),
        ];
    }

    public $dues = [];

    public function mount()
    {
        $this->generateReport();
    }

    public function generateReport()
    {
        $data = $this->form->getState() ?? ['month' => now()->month, 'year' => now()->year];
        
        $this->dues = \App\Models\Enrollment::where('status', 'active')
            ->whereDoesntHave('payments', function ($query) use ($data) {
                $query->whereMonth('payment_date', $data['month'])
                      ->whereYear('payment_date', $data['year']);
            })
            ->with(['user', 'scheme'])
            ->get();
    }
}
