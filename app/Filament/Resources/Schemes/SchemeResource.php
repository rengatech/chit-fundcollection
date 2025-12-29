<?php

namespace App\Filament\Resources\Schemes;

use App\Filament\Resources\Schemes\Pages\CreateScheme;
use App\Filament\Resources\Schemes\Pages\EditScheme;
use App\Filament\Resources\Schemes\Pages\ListSchemes;
use App\Filament\Resources\Schemes\Schemas\SchemeForm;
use App\Filament\Resources\Schemes\Tables\SchemesTable;
use App\Models\Scheme;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SchemeResource extends Resource
{
    protected static ?string $model = Scheme::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return SchemeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SchemesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSchemes::route('/'),
            'create' => CreateScheme::route('/create'),
            'edit' => EditScheme::route('/{record}/edit'),
        ];
    }
}
