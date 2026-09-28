<?php

namespace App\Filament\Resources\PhotoConsents; 

use App\Filament\Resources\PhotoConsents\Pages\CreatePhotoConsent;
use App\Filament\Resources\PhotoConsents\Pages\EditPhotoConsent;
use App\Filament\Resources\PhotoConsents\Pages\ListPhotoConsents;
use App\Filament\Resources\PhotoConsents\Schemas\PhotoConsentForm;
use App\Filament\Resources\PhotoConsents\Tables\PhotoConsentsTable;
use App\Models\PhotoConsent;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class PhotoConsentResource extends Resource
{
    protected static ?string $model = PhotoConsent::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-document-check';

    protected static string|UnitEnum|null $navigationGroup = 'Користувачі';

    protected static ?string $label = 'Згода на фото';

    protected static ?string $pluralLabel = 'Згоди на фото';

    public static function form(Schema $schema): Schema
    {
        return PhotoConsentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PhotoConsentsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with([
                'doctorPhoto.doctor', 
                'userSignature.user'
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPhotoConsents::route('/'),
            'create' => CreatePhotoConsent::route('/create'),
            'edit' => EditPhotoConsent::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}