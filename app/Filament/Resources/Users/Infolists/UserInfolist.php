<?php

namespace App\Filament\Resources\Users\Infolists;

use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\BadgeEntry;
use Filament\Infolists\Components\IconEntry;

class UserInfolist
{
    public static function configure(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informations de compte')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Nom complet')
                                    ->icon('heroicon-o-user'),

                                TextEntry::make('email')
                                    ->label('Email')
                                    ->icon('heroicon-o-envelope')
                                    ->copyable(),

                                TextEntry::make('phone')
                                    ->label('Téléphone')
                                    ->icon('heroicon-o-phone')
                                    ->copyable(),

                                IconEntry::make('email_verified_at')
                                    ->label('Email vérifié')
                                    ->icon('heroicon-o-check-circle')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('danger'),
                            ]),
                    ])
                    ->columns(1),

                Section::make('Profil associé')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('profile.age')
                                    ->label('Âge')
                                    ->icon('heroicon-o-cake')
                                    ->suffix(' ans'),

                                TextEntry::make('profile.gender')
                                    ->label('Genre')
                                    ->icon('heroicon-o-user-group')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'male' => 'blue',
                                        'female' => 'pink',
                                        default => 'gray',
                                    }),

                                TextEntry::make('profile.height')
                                    ->label('Taille')
                                    ->icon('heroicon-o-arrows-up-down')
                                    ->suffix(' cm'),

                                TextEntry::make('profile.country.name')
                                    ->label('Pays')
                                    ->icon('heroicon-o-globe-alt'),

                                TextEntry::make('profile.city.name')
                                    ->label('Ville')
                                    ->icon('heroicon-o-map-pin'),

                                ImageEntry::make('profile.avatar')
                                    ->label('Avatar')
                                    ->disk('public')
                                    ->height(150)
                                    ->width(150)
                                    ->circular(),
                            ]),

                        TextEntry::make('profile.bio')
                            ->label('Biographie')
                            ->icon('heroicon-o-document-text')
                            ->columnSpanFull()
                            ->markdown(),

                        TextEntry::make('profile.hobbies')
                            ->label('Centres d\'intérêt')
                            ->icon('heroicon-o-heart')
                            ->badge()
                            ->separator(',')
                            ->color('success')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Statistiques d\'activité')
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                TextEntry::make('matchesAsUser_count')
                                    ->label('Correspondances initiées')
                                    ->icon('heroicon-o-heart')
                                    ->badge()
                                    ->color('success'),

                                TextEntry::make('matchesAsMatched_count')
                                    ->label('Correspondances reçues')
                                    ->icon('heroicon-o-heart')
                                    ->badge()
                                    ->color('info'),

                                TextEntry::make('photos_count')
                                    ->label('Photos')
                                    ->icon('heroicon-o-photo')
                                    ->badge()
                                    ->color('warning'),

                                TextEntry::make('conversations_count')
                                    ->label('Conversations')
                                    ->icon('heroicon-o-chat-bubble-left-right')
                                    ->badge()
                                    ->color('primary'),
                            ]),
                    ])
                    ->columns(1),

                Section::make('Informations système')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Compte créé le')
                                    ->icon('heroicon-o-calendar')
                                    ->dateTime('d/m/Y H:i'),

                                TextEntry::make('updated_at')
                                    ->label('Dernière modification')
                                    ->icon('heroicon-o-clock')
                                    ->dateTime('d/m/Y H:i'),
                            ]),
                    ])
                    ->columns(1),
            ]);
    }
}
