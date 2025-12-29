<?php

namespace App\Filament\Resources\Schemes\Pages;

use App\Filament\Resources\Schemes\SchemeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditScheme extends EditRecord
{
    protected static string $resource = SchemeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
