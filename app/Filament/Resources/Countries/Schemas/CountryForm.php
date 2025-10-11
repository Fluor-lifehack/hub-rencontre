<?php

namespace App\Filament\Resources\Countries\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CountryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nom du pays')
                    ->required()
                    ->placeholder('Ex: Côte d\'Ivoire'),
                TextInput::make('code')
                    ->label('Code ISO')
                    ->required()
                    ->length(3)
                    ->placeholder('Ex: CIV'),
                Toggle::make('is_active')
                    ->label('Pays actif')
                    ->default(true)
                    ->helperText('Activer ou désactiver ce pays'),
            ]);
    }
}
