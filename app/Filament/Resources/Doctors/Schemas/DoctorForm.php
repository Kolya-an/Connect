<?php

namespace App\Filament\Resources\Doctors\Schemas;

use App\Models\Doctor;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use App\Models\Service;


class DoctorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('user.name')
                            ->label("Ім'я")
                            ->required()
                            ->maxLength(255)
                            ->afterStateHydrated(function (TextInput $component, $record) {
                                if ($record && $record->user) {
                                    $component->state($record->user->name);
                                } else {
                                    $component->state('');
                                }
                            }),
                        TextInput::make('second_name')
                            ->label('Прізвище'),
                        TextInput::make('user.email')
                            ->label('Email')
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
                            ->label('Телефон')
                            ->tel()
                            ->mask('+38 099 999 99 99'),
                        TextInput::make('user.password')
                            ->label('Пароль')
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
                            ->label('Дата народження')
                            ->native(false)
                            ->closeOnDateSelection(),
                        FileUpload::make('photo')
                            ->label('Фото')
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
                        TextInput::make('city')
                            ->label('Місто'),
                        TextInput::make('area')
                            ->label('Район/Метро'),
                        TextInput::make('address')
                            ->label('Адреса'),
                        /*TextInput::make('latitude')->readOnly(),
                        TextInput::make('longitude')->readOnly(),*/
                        TextInput::make('experience')
                            ->label('Досвід')
                            ->numeric(),
                        TextInput::make('rating')
                            ->label('Рейтинг')
                            ->numeric()
                            ->step(0.1)
                            ->minValue(0)
                            ->maxValue(5),
                        Textarea::make('desc')
                            ->label('Опис')
                            ->columnSpanFull(),
                        //TextInput::make('location'),
                        Select::make('sex')
                            ->label('Стать')
                            ->options(['male' => 'Male', 'female' => 'Female', 'nonbinary' => 'Nonbinary'])
                            ->default('female')
                            ->required(),
                    ]),
                Section::make()
                    ->schema([
                        Repeater::make('types')
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
                        Select::make('services_sync')
                            ->label('Послуги')
                            ->multiple()
                            ->relationship('services', 'name')
                            ->options(Service::pluck('name', 'id'))
                            ->preload()
                            ->searchable()
                            ->columnSpanFull()
                            ->afterStateUpdated(function ($state, $record) {
                                if ($record && $record->exists) {
                                    $record->services()->sync($state);
                                }
                            }),
                        Toggle::make('active')
                            ->label('Активна?'),
                        TextInput::make('plate')
                            ->label('Плашка'),
                    ]),
                Section::make('Фото до/після')
                    ->schema([
                        Grid::make()
                            ->columns(1)
                            ->schema([
                        Repeater::make('photos')
                            ->columnSpan(1)
                            ->label('Фото до/після')
                            ->relationship('photos')
                            ->collapsed()
                            ->addActionLabel('Додати фото')
                            ->reorderableWithButtons()
                            ->itemLabel(function (array $state): ?string {
                                $hasPhoto = false;
                                $photoValue = $state['photo'] ?? null;

                                // Проверяем разные форматы FileUpload
                                if ($photoValue) {
                                    if (is_array($photoValue) && !empty($photoValue)) {
                                        $hasPhoto = true;
                                    } elseif (is_string($photoValue) && $photoValue !== '') {
                                        $hasPhoto = true;
                                    }
                                }

                                if ($hasPhoto) {
                                    $label = '📷';
                                    if (!empty($state['procedure'] ?? '')) {
                                        $label .= ' • ' . $state['procedure'];
                                    }
                                    return $label;
                                }

                                if (!empty($state['procedure'] ?? '')) {
                                    return '🔧 ' . $state['procedure'];
                                }

                                if (!empty($state['product'] ?? '')) {
                                    return '💊 ' . $state['product'];
                                }

                                return '🆕 Новий елемент';

                            })
                            ->schema([
                                Grid::make(1) // обёртка для карточки
                                ->columnSpan(2) // важный момент: занимает половину родителя
                                ->schema([
                                    Grid::make(3)->schema([
                                        // Превью фото
                                        FileUpload::make('photo')
                                            ->label('Фото')
                                            ->image()
                                            ->directory('doctor/' . date('Y') . '/' . date('m'))
                                            ->required()
                                            ->columnSpan(1),

                                        // Поля справа
                                        Grid::make(2)->schema([
                                            TextInput::make('procedure')
                                                ->label('Процедура')
                                                ->columnSpan(2),
                                            TextInput::make('product')
                                                ->label('Продукт')
                                                ->columnSpan(2),
                                            Toggle::make('list')
                                                ->label('Показувати')
                                                ->default(false)
                                                ->columnSpan(2),
                                        ])->columnSpan(2),
                                    ])
                                ]),
                            ])
                            ]),
                    ])
                    ->columnSpanFull()
                ->collapsed()
            ]);
    }

}
