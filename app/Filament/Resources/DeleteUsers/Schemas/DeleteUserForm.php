<?php

namespace App\Filament\Resources\DeleteUsers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DeleteUserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Інформація про користувача')
                    ->schema([
                        TextInput::make('name')
                            ->label("Ім'я")
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255),

                        Select::make('role')
                            ->label('Роль')
                            ->options([
                                'admin' => 'Адміністратор',
                                'doctor' => 'Лікар',
                                'patient' => 'Пацієнт',
                            ])
                            ->required(),

                        ToggleButtons::make('active')
                            ->label('Статус акаунта')
                            ->options([
                                1 => 'Активний',
                                0 => 'Неактивний',
                                2 => 'Видалений',
                            ])
                            ->colors([
                                1 => 'success',
                                0 => 'warning',
                                2 => 'danger',
                            ])
                            ->inline()
                            ->required(),
                    ]),
            ]);
    }
}