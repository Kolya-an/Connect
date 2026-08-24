<?php

namespace App\Filament\Resources\Reviews\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;

class ReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Placeholder::make('doctor_full_name')
                    ->label('Доктор')
                    ->content(function ($record) {
                        if (!$record) return '—';

                        $name = $record->appointment?->doctor?->user?->name;
                        $secondName = $record->appointment?->doctor?->second_name;

                        return $name || $secondName ? trim("{$name} {$secondName}") : '—';
                    }),
                Textarea::make('text')
                    ->columnSpanFull(),
                TextInput::make('medical')
                    ->required()
                    ->numeric()
                    ->default(5),
                TextInput::make('service')
                    ->required()
                    ->numeric()
                    ->default(5),
                Toggle::make('active')
                    ->label('Активний (відображати на сайті)')
                    ->default(false)
                    ->required(),
            ]);
    }
}
