<?php

namespace App\Filament\Resources\Doctors\Schemas;

use App\Models\Doctor;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DoctorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('user.name')
                            ->label('User Name')
                            ->required()
                            ->maxLength(255)
                            ->afterStateHydrated(function (TextInput $component, $record) {
                                if ($record && $record->user) {
                                    $component->state($record->user->name);
                                } else {
                                    $component->state('');
                                }
                            }),
                        TextInput::make('second_name'),
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
                        TextInput::make('phone')
                            ->tel()
                        ->mask('+38 099 999 99 99'),
                        TextInput::make('user.password')
                            ->password()
                            ->required()
                            ->maxLength(255)
                            ->dehydrated(fn ($state) => filled($state))
                            ->hidden(fn ($operation) => $operation === 'edit')
                        ,
                    ]),
                Section::make()
                    ->schema([
                        DatePicker::make('birthday')
                            ->native(false)
                            ->closeOnDateSelection(),
                        FileUpload::make('photo')
                            ->directory('doctor/' . date('Y') . '/' . date('m'))
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
                    ]),
                Section::make()
                    ->schema([
                        TextInput::make('city'),
                        TextInput::make('area'),
                        TextInput::make('address'),
                        TextInput::make('experience')
                            ->numeric(),
                        Textarea::make('desc')
                            ->columnSpanFull(),
                        //TextInput::make('location'),
                        Select::make('sex')
                            ->options(['male' => 'Male', 'female' => 'Female', 'nonbinary' => 'Nonbinary'])
                            ->default('female')
                            ->required(),
                    ]),
                Section::make()
                    ->schema([
                        Repeater::make('services')
                            ->label('Спеціалізації')
                            ->simple(
                                TextInput::make('value')
                                    ->label('Tag')
                                    ->required(),

                            )
                            ->defaultItems(1)
                            ->addActionLabel('Додати')
                            ->reorderableWithButtons()
                            ->columnSpanFull(),

                    ]),
            ]);
    }

}
