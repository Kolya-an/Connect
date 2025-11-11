<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                    TextInput::make('name')
                        ->label('Назва')
                        ->required(),
                ]),
                Section::make()
                    ->schema([
                    Toggle::make('header')
                        ->label('Верхнє меню?'),
                    Toggle::make('footer')
                        ->label('Нижнє меню?'),
                ]),
            ]);
    }
}
