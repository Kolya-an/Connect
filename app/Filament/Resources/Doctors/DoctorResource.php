<?php

namespace App\Filament\Resources\Doctors;


use App\Filament\Resources\Doctors\Pages\CreateDoctor;
use App\Filament\Resources\Doctors\Pages\EditDoctor;
use App\Filament\Resources\Doctors\Pages\ListDoctors;
use App\Filament\Resources\Doctors\Schemas\DoctorForm;
use App\Filament\Resources\Doctors\Tables\DoctorsTable;
use App\Models\Doctor;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;
use App\Services\GeocodingService;

class DoctorResource extends Resource
{
    protected static ?string $model = Doctor::class;

    //protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $label = 'лікар';
    protected static ?string $pluralLabel = 'лікарі';
    protected static string | UnitEnum | null $navigationGroup = 'Користувачі';
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-user-plus';
    protected static string | BackedEnum | null $activeNavigationIcon = 'heroicon-s-user-plus';

    public static function form(Schema $schema): Schema
    {
        return DoctorForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DoctorsTable::configure($table);
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
            'index' => ListDoctors::route('/'),
            'create' => CreateDoctor::route('/create'),
            'edit' => EditDoctor::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function beforeSave($record, array $data): void
    {
        if (!empty($data['city']) && !empty($data['address'])) {

            $full = $data['address'] . ', ' . $data['city'];

            $coords = GeocodingService::geocode($full);

            // якщо координати знайдені — оновлюємо
            if ($coords) {
                $record->latitude = $coords['lat'];
                $record->longitude = $coords['lng'];
            }
        }
    }

    public static function beforeCreate($record, array $data): void
    {
        self::beforeSave($record, $data);
    }

}
