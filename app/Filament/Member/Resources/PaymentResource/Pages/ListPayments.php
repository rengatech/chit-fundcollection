<?php

namespace App\Filament\Member\Resources\PaymentResource\Pages;

use App\Filament\Member\Resources\PaymentResource;
use Filament\Resources\Pages\ListRecords;

class ListPayments extends ListRecords
{
    protected static string $resource = PaymentResource::class;
}
