<?php

namespace App\Filament\Resources\Profiles\Schemas;

use App\Models\Country;
use App\Models\City;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Textarea::make('bio')
                    ->default(null)
                    ->columnSpanFull(),
                Select::make('gender')
                    ->options([
                        'male' => 'Homme',
                        'female' => 'Femme',
                        'other' => 'Autre'
                    ])
                    ->placeholder('Sélectionner le genre'),
                TextInput::make('age')
                    ->label('Âge')
                    ->numeric()
                    ->minValue(18)
                    ->maxValue(100)
                    ->placeholder('Âge'),
                Select::make('country_id')
                    ->label('Pays')
                    ->relationship('country', 'name')
                    ->placeholder('Sélectionner un pays')
                    ->searchable()
                    ->preload(),
                Select::make('city_id')
                    ->label('Ville')
                    ->relationship('city', 'name')
                    ->placeholder('Sélectionner une ville')
                    ->searchable()
                    ->preload(),
                TextInput::make('height')
                    ->label('Taille (cm)')
                    ->numeric()
                    ->minValue(100)
                    ->maxValue(250)
                    ->placeholder('Taille en centimètres'),
                Textarea::make('hobbies')
                    ->label('Centres d\'intérêt')
                    ->placeholder('Décrivez vos centres d\'intérêt...')
                    ->columnSpanFull(),
                FileUpload::make('avatar')
                    ->label('Photo de profil')
                    ->image()
                    ->directory('avatars')
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '1:1',
                    ])
                    ->maxSize(2048),
            ]);
    }
}
