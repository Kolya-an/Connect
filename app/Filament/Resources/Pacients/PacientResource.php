<?php

namespace App\Filament\Resources\Pacients;

use App\Filament\Resources\Pacients\Pages\CreatePacient;
use App\Filament\Resources\Pacients\Pages\EditPacient;
use App\Filament\Resources\Pacients\Pages\ListPacients;
use App\Filament\Resources\Pacients\Schemas\PacientForm;
use App\Filament\Resources\Pacients\Tables\PacientsTable;
use App\Models\Pacient;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PacientResource extends Resource
{
    protected static ?string $model = Pacient::class;

    //protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $label = "пацієнт";
    protected static ?string $pluralLabel = "пацієнти";

    protected static string | UnitEnum | null $navigationGroup = 'Користувачі';
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-user';
    protected static string | BackedEnum | null $activeNavigationIcon = 'heroicon-s-user';

    public static function form(Schema $schema): Schema
    {
        return PacientForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PacientsTable::configure($table);
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
            'index' => ListPacients::route('/'),
            'create' => CreatePacient::route('/create'),
            'edit' => EditPacient::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
