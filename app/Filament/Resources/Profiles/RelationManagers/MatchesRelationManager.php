<?php

namespace App\Filament\Resources\Profiles\RelationManagers;

use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class MatchesRelationManager extends RelationManager
{
    protected static string $relationship = 'userMatches';

    protected static ?string $title = 'Correspondances';

    protected static ?string $modelLabel = 'Correspondance';

    protected static ?string $pluralModelLabel = 'Correspondances';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Select::make('matched_user_id')
                    ->label('Utilisateur correspondant')
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),

                Forms\Components\NumberInput::make('compatibility_score')
                    ->label('Score de compatibilité')
                    ->minValue(0)
                    ->maxValue(100)
                    ->default(50)
                    ->required(),

                Forms\Components\Toggle::make('is_mutual')
                    ->label('Correspondance mutuelle')
                    ->default(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('matchedUser.name')
                    ->label('Utilisateur correspondant')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('matchedUser.email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('compatibility_score')
                    ->label('Score de compatibilité')
                    ->sortable()
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state >= 80 => 'success',
                        $state >= 60 => 'warning',
                        default => 'danger',
                    }),

                Tables\Columns\IconColumn::make('is_mutual')
                    ->label('Mutuel')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Modifié le')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_mutual')
                    ->label('Correspondance mutuelle')
                    ->placeholder('Toutes les correspondances')
                    ->trueLabel('Correspondances mutuelles')
                    ->falseLabel('Correspondances non mutuelles'),

                Tables\Filters\Filter::make('high_compatibility')
                    ->label('Haute compatibilité')
                    ->query(fn ($query) => $query->where('compatibility_score', '>=', 80)),

                Tables\Filters\Filter::make('medium_compatibility')
                    ->label('Compatibilité moyenne')
                    ->query(fn ($query) => $query->whereBetween('compatibility_score', [60, 79])),

                Tables\Filters\Filter::make('low_compatibility')
                    ->label('Faible compatibilité')
                    ->query(fn ($query) => $query->where('compatibility_score', '<', 60)),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Nouvelle correspondance'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
