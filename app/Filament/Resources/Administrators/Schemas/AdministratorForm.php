<?php

namespace App\Filament\Resources\Administrators\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Schema;

class AdministratorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nom complet')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Ex: Jean Dupont')
                    ->helperText('Le nom complet de l\'administrateur'),

                TextInput::make('email')
                    ->label('Adresse email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->placeholder('admin@rencontre-hub.com')
                    ->helperText('Adresse email unique pour la connexion'),


                Select::make('role')
                    ->label('Rôle')
                    ->required()
                    ->options([
                        'super_admin' => 'Super Administrateur',
                        'admin' => 'Administrateur',
                        'moderator' => 'Modérateur',
                    ])
                    ->default('admin')
                    ->helperText('Définit les permissions de l\'administrateur'),

                Toggle::make('is_active')
                    ->label('Compte actif')
                    ->default(true)
                    ->helperText('Désactiver pour empêcher la connexion'),

                DateTimePicker::make('email_verified_at')
                    ->label('Email vérifié le')
                    ->default(now())
                    ->helperText('Date de vérification de l\'email'),

                DateTimePicker::make('last_login_at')
                    ->label('Dernière connexion')
                    ->disabled()
                    ->dehydrated(false)
                    ->helperText('Dernière fois que l\'administrateur s\'est connecté'),
            ]);
    }
}
