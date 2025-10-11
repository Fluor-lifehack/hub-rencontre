<?php

namespace App\Filament\Resources\Profiles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProfilesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('user.name')
                    ->label('Nom')
                    ->searchable(),
                TextColumn::make('gender')
                    ->label('Genre')
                    ->badge(),
                TextColumn::make('age')
                    ->numeric()
                    ->label('Âge')
                    ->sortable(),
                TextColumn::make('country.name')
                    ->label('Pays')
                    ->searchable(),
                TextColumn::make('city.name')
                    ->label('Ville')
                    ->searchable(),
                TextColumn::make('height')
                    ->numeric()
                    ->label('Taille')
                    ->sortable(),
                // TextColumn::make('avatar')
                //     ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
