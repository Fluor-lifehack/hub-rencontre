<?php

namespace App\Filament\Resources\Profiles\Infolists;

use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\BadgeEntry;
use Filament\Infolists\Components\IconEntry;

class ProfileInfolist
{
    public static function configure(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informations personnelles')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('user.name')
                                    ->label('Nom d\'utilisateur')
                                    ->icon('heroicon-o-user'),

                                TextEntry::make('user.email')
                                    ->label('Email')
                                    ->icon('heroicon-o-envelope')
                                    ->copyable(),

                                TextEntry::make('user.phone')
                                    ->label('Téléphone')
                                    ->icon('heroicon-o-phone')
                                    ->copyable(),

                                TextEntry::make('age')
                                    ->label('Âge')
                                    ->icon('heroicon-o-cake')
                                    ->suffix(' ans'),

                                TextEntry::make('gender')
                                    ->label('Genre')
                                    ->icon('heroicon-o-user-group')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'male' => 'blue',
                                        'female' => 'pink',
                                        default => 'gray',
                                    }),

                                TextEntry::make('height')
                                    ->label('Taille')
                                    ->icon('heroicon-o-arrows-up-down')
                                    ->suffix(' cm'),
                            ]),
                    ])
                    ->columns(1),

                Section::make('Localisation')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('country.name')
                                    ->label('Pays')
                                    ->icon('heroicon-o-globe-alt'),

                                TextEntry::make('city.name')
                                    ->label('Ville')
                                    ->icon('heroicon-o-map-pin'),
                            ]),
                    ])
                    ->columns(1),

                Section::make('Profil')
                    ->schema([
                        TextEntry::make('bio')
                            ->label('Biographie')
                            ->icon('heroicon-o-document-text')
                            ->columnSpanFull()
                            ->markdown(),

                        ImageEntry::make('avatar')
                            ->label('Avatar')
                            ->disk('public')
                            ->height(200)
                            ->width(200)
                            ->circular(),

                        TextEntry::make('hobbies')
                            ->label('Centres d\'intérêt')
                            ->icon('heroicon-o-heart')
                            ->badge()
                            ->separator(',')
                            ->color('success'),
                    ])
                    ->columns(2),

                Section::make('Statistiques')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('userMatches_count')
                                    ->label('Correspondances')
                                    ->icon('heroicon-o-heart')
                                    ->badge()
                                    ->color('success'),

                                TextEntry::make('user.photos_count')
                                    ->label('Photos')
                                    ->icon('heroicon-o-photo')
                                    ->badge()
                                    ->color('info'),

                                TextEntry::make('created_at')
                                    ->label('Membre depuis')
                                    ->icon('heroicon-o-calendar')
                                    ->dateTime('d/m/Y'),
                            ]),
                    ])
                    ->columns(1),
            ]);
    }
}
