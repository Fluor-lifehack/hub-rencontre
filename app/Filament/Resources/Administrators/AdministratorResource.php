<?php

namespace App\Filament\Resources\Administrators;

use App\Filament\Resources\Administrators\Pages\CreateAdministrator;
use App\Filament\Resources\Administrators\Pages\EditAdministrator;
use App\Filament\Resources\Administrators\Pages\ListAdministrators;
use App\Filament\Resources\Administrators\Schemas\AdministratorForm;
use App\Filament\Resources\Administrators\Tables\AdministratorsTable;
use App\Models\Administrator;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AdministratorResource extends Resource
{
    protected static ?string $model = Administrator::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserCircle;

    protected static string | UnitEnum | null $navigationGroup = 'Settings';

    public static function form(Schema $schema): Schema
    {
        return AdministratorForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AdministratorsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAdministrators::route('/'),
            'create' => CreateAdministrator::route('/create'),
            'edit' => EditAdministrator::route('/{record}/edit'),
        ];
    }
}
