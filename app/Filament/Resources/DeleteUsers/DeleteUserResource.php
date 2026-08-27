<?php

namespace App\Filament\Resources\DeleteUsers;

use App\Filament\Resources\DeleteUsers\Pages\ListDeleteUsers;
use App\Filament\Resources\DeleteUsers\Tables\DeleteUsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class DeleteUserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $label = "видалений користувач";
    protected static ?string $pluralLabel = "видалені користувачі";

    protected static string | UnitEnum | null $navigationGroup = 'Користувачі';
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-trash';
    protected static string | BackedEnum | null $activeNavigationIcon = 'heroicon-s-trash';
    protected static ?int $navigationSort = 10;

    // 🛑 Фільтрація: беремо тільки юзерів зі статусом active = 2
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('active', 2);
    }

    public static function table(Table $table): Table
    {
        return DeleteUsersTable::configure($table);
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
            'index' => ListDeleteUsers::route('/'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()->count();
    }
}