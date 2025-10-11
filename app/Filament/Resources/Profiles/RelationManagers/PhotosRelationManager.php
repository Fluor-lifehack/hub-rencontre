<?php

namespace App\Filament\Resources\Profiles\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Schemas\Schema;

class PhotosRelationManager extends RelationManager
{
    protected static string $relationship = 'photos';

    protected static ?string $recordTitleAttribute = 'path';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('path')
                    ->label('Chemin du fichier')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Ex: photos/user123/avatar.jpg')
                    ->helperText('Chemin relatif vers le fichier image'),

                FileUpload::make('image')
                    ->label('Image')
                    ->image()
                    ->directory('photos')
                    ->visibility('public')
                    ->helperText('Télécharger une nouvelle image'),

                Toggle::make('is_profile')
                    ->label('Photo de profil')
                    ->default(false)
                    ->helperText('Marquer comme photo de profil principale'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('path')
                    ->label('Image')
                    ->size(60)
                    ->circular(),

                TextColumn::make('path')
                    ->label('Chemin')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 50 ? $state : null;
                    }),

                IconColumn::make('is_profile')
                    ->label('Photo de profil')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('gray'),

                TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Modifié le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Ajouter une photo'),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Modifier'),
                DeleteAction::make()
                    ->label('Supprimer'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Supprimer sélection'),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('Aucune photo')
            ->emptyStateDescription('Ce profil n\'a pas encore de photos.')
            ->emptyStateIcon('heroicon-o-photo');
    }
}
