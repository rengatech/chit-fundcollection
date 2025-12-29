<?php

namespace App\Filament\Member\Pages\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Schemas\Schema;

class Register extends BaseRegister
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                TextInput::make('mobile')
                    ->required()
                    ->unique('users', 'mobile')
                    ->numeric()
                    ->length(10),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
                Textarea::make('address')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('city')
                    ->required(),
                TextInput::make('pincode')
                    ->required()
                    ->numeric()
                    ->length(6),
            ])
            ->statePath('data');
    }
}
