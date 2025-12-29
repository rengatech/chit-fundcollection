<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email Address')
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->maxLength(255),
                TextInput::make('mobile')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->length(10)
                    ->numeric(),
                TextInput::make('password')
                    ->password()
                    ->required(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                    ->dehydrated(fn ($state) => filled($state))
                    ->maxLength(255),
                Select::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'member' => 'Member',
                    ])
                    ->default('member')
                    ->required(),
                Textarea::make('address')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('city')
                    ->required()
                    ->maxLength(255),
                TextInput::make('pincode')
                    ->required()
                    ->length(6)
                    ->numeric(),
                Toggle::make('is_active')
                    ->label('Active Status')
                    ->default(true)
                    ->required(),
            ]);
    }
}
