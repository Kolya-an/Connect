<?php

namespace App\Filament\Resources\PhotoConsents\Schemas;

use App\Models\PhotoConsent;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\Placeholder;

class PhotoConsentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Учасники згоди')
                    ->schema([
                        // ПІБ Пацієнта
                      

                    Placeholder::make('patient_info')
                        ->label('ПІБ Пацієнта / Користувача')
                        ->content(function ($record) {
                            if (!$record) {
                                return '—';
                            }

                            // 1. Отримуємо модель Pacient
                            $pacient = $record->patient ?? $record->doctorPhoto?->patient;

                            if ($pacient) {
                                // Отримуємо ім'я з таблиці users або з самої моделі Pacient
                                $userName = $pacient->user?->name ?? $pacient->name ?? '';
                                
                                // Отримуємо прізвище та по батькові з таблиці pacients
                                $lastName = $pacient->last_name ?? '';
                                $secondName = $pacient->second_name ?? $pacient->middle_name ?? '';

                                // Якщо у pacients є окреме прізвище або по батькові
                                if (!empty($lastName) || !empty($secondName)) {
                                    $fullName = trim("{$lastName} {$userName} {$secondName}");
                                    if (!empty(trim($fullName))) {
                                        return $fullName;
                                    }
                                }

                                // Якщо є тільки name із таблиці users
                                if (!empty($userName)) {
                                    return $userName;
                                }
                            }

                            // 2. Резервний варіант: якщо є дані з Дії в signer_info
                            if (is_array($record->signer_info)) {
                                $info = $record->signer_info;
                                $lastName   = $info['last_name'] ?? $info['lastName'] ?? '';
                                $firstName  = $info['first_name'] ?? $info['firstName'] ?? $info['name'] ?? '';
                                $secondName = $info['middle_name'] ?? $info['second_name'] ?? $info['middleName'] ?? '';

                                $result = trim("{$lastName} {$firstName} {$secondName}");

                                return $result ?: '—';
                            }

                            return '—';
                        }),
                        

                        // ПІБ Лікаря
                        TextInput::make('doctor_name')
                            ->label('ПІБ Лікаря')
                            ->formatStateUsing(function (?PhotoConsent $record) {
                                if (!$record) return '—';
                                $doctor = $record->doctorPhoto?->doctor;
                                if (!$doctor) return '—';

                                return trim(($doctor->user?->name ?? $doctor->name ?? '') . ' ' . ($doctor->second_name ?? ''));
                            })
                            ->disabled(),

                        
                    ])->columns(1),

                Section::make('Деталі згоди')
                    ->schema([
                        TextInput::make('token')
                            ->label('Токен')
                            ->disabled(),

                        Select::make('status')
                            ->label('Статус')
                            ->options([
                                'pending' => 'Очікує',
                                'signed' => 'Підписано',
                                'declined' => 'Активний',
                            ])
                            ->required(),

                        DateTimePicker::make('signed_at')
                            ->label('Дата підписання')
                            ->disabled(),

                        TextInput::make('pdf_path')
                            ->label('Шлях до PDF')
                            ->disabled()
                            ->suffixAction(
                                Action::make('open_pdf')
                                    ->label('Відкрити PDF')
                                    ->icon('heroicon-o-arrow-top-right-on-square')
                                    ->visible(fn (?PhotoConsent $record) => !empty($record?->pdf_path))
                                    ->url(fn (?PhotoConsent $record) => $record?->pdf_path ? Storage::disk('public')->url($record->pdf_path) : '#')
                                    ->openUrlInNewTab()
                            ),
                    ])->columns(2),

                Section::make('Дані підпису / Payload')
                    ->schema([
                        KeyValue::make('signer_info')
                            ->label('Метадані Дія.Підпис')
                            ->addable(false) // 👈 Прибирає кнопку "Додати рядок"
                            ->deletable(false) // Прибирає можливість видаляти рядки (за потреби)
                            ->editableKeys(false) // Забороняє редагувати ключі (за потреби)
                            ->formatStateUsing(function ($state) {
                                    if (!is_array($state)) {
                                        return $state;
                                    }

                                    // 1. Видаляємо непотрібні ключі термінів дії сертифіката
                                    unset($state['certificate_valid_from'], $state['certificate_valid_to'], 
                                    $state['first_name'], $state['last_name']);

                                    // 2. Карта перейменування ключів
                                    $labels = [
                                        'drfo'               => 'РНОКПП / ІПН',
                                        'name'               => 'ПІБ',
                                        'signed_at'          => 'Дата та час підписання',
                                        'certificate_issuer' => 'ЦСК (Видавник сертифіката)',
                                        'certificate_serial' => 'Серійний номер сертифіката',
                                    ];

                                    $formatted = [];
                                    foreach ($state as $key => $value) {
                                        $newKey = $labels[$key] ?? $key;
                                        $formatted[$newKey] = $value;
                                    }

                                    return $formatted;
                                })
                            ->columnSpanFull(),
                            Section::make('Порівняння фото До / Після ')
                    ->schema([
                        ViewField::make('before_after_comparison')
                            ->label('Фото До / Після')
                            ->view('filament.forms.components.photo-preview'), 
                    ])
                    ]),
                    Section::make('Документ згоди')
                    ->schema([
                        ViewField::make('file_document')
                            ->label('Фото / файл згоди')
                            ->view('filament.forms.components.file-document-preview')
                            ->columnSpanFull(),
                    ]),

                
            ]);
    }
}