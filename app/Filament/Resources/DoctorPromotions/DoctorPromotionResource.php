<?php

namespace App\Filament\Resources\DoctorPromotions;

use App\Filament\Resources\DoctorPromotions\Pages\CreateDoctorPromotion;
use App\Filament\Resources\DoctorPromotions\Pages\EditDoctorPromotion;
use App\Filament\Resources\DoctorPromotions\Pages\ListDoctorPromotions;
use App\Filament\Resources\DoctorPromotions\Pages\ViewDoctorPromotion;
use App\Filament\Resources\DoctorPromotions\Schemas\DoctorPromotionForm;
use App\Filament\Resources\DoctorPromotions\Schemas\DoctorPromotionInfolist;
use App\Filament\Resources\DoctorPromotions\Tables\DoctorPromotionsTable;
use App\Models\DoctorPromotion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DoctorPromotionResource extends Resource
{
    protected static ?string $model = DoctorPromotion::class;
    protected static ?string $label = 'Акція';
    protected static ?string $pluralLabel = 'акції';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return DoctorPromotionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DoctorPromotionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DoctorPromotionsTable::configure($table);
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
            'index' => ListDoctorPromotions::route('/'),
            'create' => CreateDoctorPromotion::route('/create'),
            'view' => ViewDoctorPromotion::route('/{record}'),
            'edit' => EditDoctorPromotion::route('/{record}/edit'),
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['doctor.user']);
    }

}
