<?php

namespace App\Filament\Resources\DoctorPromotions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DoctorPromotionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('doctor_full_name')
                    ->label('Лікар')
                    ->state(function ($record): ?string {
                        $name = $record->doctor?->user?->name;
                        $secondName = $record->doctor?->second_name;

                        if ($name || $secondName) {
                            return trim("{$name} {$secondName}");
                        }
                        return null;
                    }),
                TextEntry::make('title')
                    ->label('Назва'),
                TextEntry::make('description')
                    ->label('Опис')
                    ->columnSpanFull(),
                TextEntry::make('old_price')
                    ->label('Стара ціна')
                    ->numeric(),
                TextEntry::make('new_price')
                    ->label('Нова ціна')
                    ->numeric(),
                TextEntry::make('date_from')
                    ->label('Початок')
                    ->date(),
                TextEntry::make('date_to')
                    ->label('Кінець')
                    ->date(),
            ]);
    }
}
