<?php

namespace App\Filament\Resources\Doctors\RelationManagers;

use App\Models\Appointment;
use App\Models\User;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Model; // Добавлен для afterCreate
use App\Models\DoctorSchedule; // <-- Добавлен импорт модели расписания
use Carbon\Carbon; // <-- Добавлен импорт Carbon

class AppointmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'appointments';
    protected static ?string $title = 'Записи'; // Заголовок вкладки
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Пацієнт')
                    ->options(function () {

                        return User::whereHas('patient')->with('patient')->get()->mapWithKeys(function ($user) {
                            return [$user->id => $user->name . ' ' . ($user->patient->second_name ?? '')];
                        })->toArray();
                    })
                    ->required()
                    ->searchable(),
                DatePicker::make('date')
                    ->label('Дата (УПРОЩЕНО)')
                    ->required()
                    ->live(),
                Select::make('hour')
                    ->label('Час')
                    ->required()
                    ->options(function (Get $get) {
                        $date = $get('date');
                        $doctorId = $this->ownerRecord->id;

                        // Пока дата не выбрана — не показываем ничего
                        if (!$date || !$doctorId) return [];

                        return \App\Models\DoctorSchedule::query()
                            ->where('doctor_id', $doctorId)
                            ->where('date', $date)
                            ->where('status', 'available')       // только свободные слоты
                            ->orderBy('hour')
                            ->get()
                            ->mapWithKeys(fn ($slot) => [
                                $slot->hour => Carbon::parse($slot->hour)->format('H:i'),
                            ]);
                    })
                    ->searchable()
                    ->preload()
                    ->reactive() // чтобы при выборе даты сразу обновлялся список часов
                    ->placeholder('Оберіть час')
                    ->dehydrateStateUsing(fn ($state) =>
                    $state ? Carbon::parse($state)->format('H:i:s') : null
                    )
                    ->afterStateUpdated(function ($state, callable $set) {
                        // если час сбросился при смене даты – чистим поле
                        if (!$state) $set('hour', null);
                    }),
                Select::make('status')
                    ->label('Статус')
                    ->options([
                        'booking' => 'Заброньовано',
                        'confirmed' => 'Підтверждено',
                        'completed' => 'Завершено',
                        'canceled' => 'Відмінено',
                    ])
                    ->required()
                    ->default('booking'),
                Textarea::make('cause')
                    ->label('Комент')
                    ->nullable()
                    ->columnSpanFull(),
            ])
            ;
    }


    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                /*TextEntry::make('patient_name')
                    ->label('Пациент')
                    ->getStateUsing(fn (Appointment $record) => $record->user->name . ' ' . ($record->user->patient->second_name ?? '')),
                TextEntry::make('date')
                    ->label('Дата')
                    ->date('d.m.Y'),
                TextEntry::make('hour')
                    ->label('Время')
                    ->time('H:i'),
                TextEntry::make('status')
                    ->label('Статус')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'booking' => 'Бронирование',
                        'confirmed' => 'Подтверждено',
                        'completed' => 'Завершено',
                        'canceled' => 'Отменено',
                        default => $state,
                    }),
                TextEntry::make('cause')
                    ->label('Причина обращения'),*/
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('patient_name')
            ->columns([
                TextColumn::make('patient_name')
                    ->label('Пацієнт')
                    ->getStateUsing(function (Appointment $record) {
                        $user = $record->user;
                        $patient = $user->patient;

                        // Проверка на наличие связанных моделей, чтобы избежать ошибок
                        if ($user && $patient) {
                            return $user->name . ' ' . $patient->second_name;
                        }
                        return $user ? $user->name : 'Невідомий користувач';
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        // Фильтрация по имени и фамилии
                        return $query->whereHas('user', function (Builder $query) use ($search) {
                            $query->where('name', 'like', "%{$search}%")
                                ->orWhereHas('patient', function (Builder $query) use ($search) {
                                    $query->where('second_name', 'like', "%{$search}%");
                                });
                        });
                    })
                    ->sortable(false), // Отключаем сортировку по этому полю для простоты
                TextColumn::make('date')
                    ->label('Дата')
                    ->date('d.m.Y')
                    ->sortable(),
                TextColumn::make('hour')
                    ->label('Время')
                    ->time('H:i')
                    ->sortable(),
                // Перевод статуса на русский
                TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'booking' => 'Заброньовано',
                        'confirmed' => 'Підтверждено',
                        'completed' => 'Завершено',
                        'canceled' => 'Відмінено',
                        default => $state,
                    })
                    // Устанавливаем цвета для статусов
                    ->color(fn (string $state): string => match ($state) {
                        'booking' => 'warning',
                        'confirmed' => 'primary',
                        'completed' => 'success',
                        'canceled' => 'danger',
                        default => 'secondary',
                    })
                    ->sortable(),
                TextColumn::make('cause')
                    ->label('Причина обращения')
                    ->limit(50)
                    ->tooltip(fn (Appointment $record): ?string => $record->cause),
            ])
            ->filters([
                Filter::make('date')
                    ->form([
                        DatePicker::make('appointment_date')
                            ->label('Дата приема'),
                    ])
                    // Явное указание FQCN для Builder в замыкании фильтра
                    ->query(function (\Illuminate\Database\Eloquent\Builder $query, array $data): \Illuminate\Database\Eloquent\Builder {
                        return $query
                            ->when(
                                $data['appointment_date'] ?? null,
                                fn (\Illuminate\Database\Eloquent\Builder $query, $dateValue): \Illuminate\Database\Eloquent\Builder => $query->whereDate('date', $dateValue),
                            );
                    })
                    ->label('Дата приема'),

                // Фильтр по статусу с русскими названиями
                SelectFilter::make('status')
                    ->label('Статус')
                    ->options([
                        'booking' => 'Бронирование',
                        'confirmed' => 'Подтверждено',
                        'completed' => 'Завершено',
                        'canceled' => 'Отменено',
                    ]),
            ])
            ->headerActions([
                CreateAction::make(),
               // AssociateAction::make(),
            ])
            ->recordActions([
                /*ViewAction::make()
                    ->modalWidth('lg'),*/
                EditAction::make()
                    ->modalWidth('lg')
                    ->successNotificationTitle('Запис оновлено'),
                //DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
