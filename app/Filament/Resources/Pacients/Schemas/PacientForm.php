<?php

namespace App\Filament\Resources\Pacients\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class PacientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User Information')
                    ->schema([
                        TextInput::make('user.name')
                            ->required()
                            ->maxLength(255)
                            ->afterStateHydrated(function (TextInput $component, $record) {
                                if ($record && $record->user) {
                                    $component->state($record->user->name);
                                } else {
                                    $component->state('');
                                }
                            }),
                        TextInput::make('user.email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->afterStateHydrated(function (TextInput $component, $record) {
                                if ($record && $record->user) {
                                    $component->state($record->user->email);
                                } else {
                                    $component->state('');
                                }
                            }),
                        TextInput::make('user.password')
                            ->password()
                            ->required()
                            ->maxLength(255)
                            ->hidden(fn ($operation) => $operation === 'edit')
                            ->dehydrated(fn ($state) => filled($state)),
                    ]),
                Section::make('doctor Information')
                    ->schema([
                        TextInput::make('second_name'),
                        DatePicker::make('birthday')
                            ->native(false)
                            ->closeOnDateSelection(),
                        FileUpload::make('photo')
                            ->directory('patient/' . date('Y') . '/' . date('m'))
                            ->visibility('public')
                            ->image()
                            ->imageEditor()
                            ->acceptedFileTypes(['image/png','image/jpeg'])
                            ->imageEditorAspectRatios([
                                null,
                                '16:9',
                                '4:3',
                                '1:1',
                            ]),
                        TextInput::make('phone')
                            ->tel()
                            ->mask('+38 099 999 99 99'),
                        TextInput::make('city'),
                        Select::make('sex')
                            ->options(['male' => 'Male', 'female' => 'Female', 'nonbinary' => 'Nonbinary'])
                            ->default('female')
                            ->required(),
                        Toggle::make('notification')
                            ->required(),
                    ]),
            ]);
    }
}
