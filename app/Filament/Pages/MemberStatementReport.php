<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use App\Models\User;
use App\Models\Payment;

class MemberStatementReport extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|\UnitEnum|null $navigationGroup = 'Reports';
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user-circle';
    protected string $view = 'filament.pages.member-statement-report';

    public $member_id;
    public $payments = [];
    public $user = null;

    protected function getFormSchema(): array
    {
        return [
            \Filament\Forms\Components\Select::make('member_id')
                ->label('Select Member')
                ->options(User::where('role', 'member')->pluck('name', 'id'))
                ->searchable()
                ->required()
                ->live()
                ->afterStateUpdated(fn () => $this->generateReport()),
        ];
    }

    public function generateReport()
    {
        $data = $this->form->getState();
        if (empty($data['member_id'])) return;

        $this->user = User::find($data['member_id']);
        $this->payments = Payment::where('user_id', $data['member_id'])
            ->with('enrollment')
            ->orderBy('payment_date', 'asc')
            ->get();
    }
}
