<?php

namespace App\Filament\Resources\Plans\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TagsInput;


class PlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nom du plan')
                    ->required()
                    ->placeholder('Ex: Premium')
                    ->columnSpanFull(),
                MarkdownEditor::make('description')
                    ->label('Description')
                    ->placeholder('Description du plan...')
                    ->helperText('Description du plan...')
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->label('Prix')
                    ->required()
                    ->numeric()
                    ->prefix('XOF')
                    ->step(0.01),
                TextInput::make('duration_days')
                    ->label('Durée (jours)')
                    ->required()
                    ->numeric()
                    ->minValue(1),
                TagsInput::make('tag')
                    ->label('Tag')
                    ->columnSpanFull()
                    ->separator(',')
                    // ->helperText('Tag du plan (ex: premium, basic, etc.)')
                    ->placeholder('Ex: premium'),
                Toggle::make('status')
                    ->label('Plan actif')
                    ->default(true)
                    ->helperText('Activer ou désactiver ce plan'),
                Repeater::make('advantages')
                    ->label('Avantages')
                    ->schema([
                        TextInput::make('advantage')
                            ->label('Avantage')
                            ->required()
                            ->placeholder('Ex: Messages illimités')
                    ])
                    ->defaultItems(1)
                    ->addActionLabel('Ajouter un avantage')
                    ->columnSpanFull(),
            ]);
    }
}
