<?php

namespace App\Filament\Resources\DoctorPromotions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DoctorPromotionForm
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
                TextInput::make('title')
                    ->label('Назва')
                    ->required(),
                Textarea::make('description')
                    ->label('Опис')
                    ->columnSpanFull(),
                TextInput::make('old_price')
                    ->label('Стара ціна')
                    ->numeric(),
                TextInput::make('new_price')
                    ->label('Нова ціна')
                    ->numeric(),
                DatePicker::make('date_from')
                    ->label('Початок'),
                DatePicker::make('date_to')
                    ->label('Кінець'),
            ]);
    }
}
