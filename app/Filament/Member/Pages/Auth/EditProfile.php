<?php

namespace App\Filament\Member\Pages\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Schemas\Schema;

class EditProfile extends BaseEditProfile
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                TextInput::make('mobile')
                    ->disabled() // Typically mobile stays fixed or requires verification
                    ->dehydrated(),
                Textarea::make('address')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('city')
                    ->required(),
                TextInput::make('pincode')
                    ->required()
                    ->numeric()
                    ->length(6),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ])
            ->statePath('data');
    }
}
