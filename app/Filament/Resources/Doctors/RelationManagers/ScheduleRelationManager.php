<?php

namespace App\Filament\Resources\Doctors\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
//use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class ScheduleRelationManager extends RelationManager
{
    // Определение отношения, которое менеджер будет использовать.
    // Предполагаем, что в модели Doctor есть метод public function schedules()
    protected static string $relationship = 'schedules';

    // Заголовок менеджера отношений, который будет отображаться во вкладке
    protected static ?string $title = 'Расписание на 15 дней';
    protected static ?string $label = 'Запись';
    protected static ?string $pluralLabel = 'Расписание';

    // Обновленный метод form, использующий Schema (Filament 4+ style)
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Поля для редактирования расписания при клике на дату
                Grid::make(2)
                    ->schema([
                        // Дата и Время не редактируются, чтобы не нарушать уникальный ключ,
                        // но выводятся для контекста.
                        DatePicker::make('date')
                            ->label('Дата')
                            ->disabled(fn($operation) => $operation === 'edit')
                            ->default(today())              // ← ставим сегодняшнюю дату автоматически
                            ->minDate(today())
                            ->columnSpan(1),
                        Select::make('hour')
                            ->label('Время')
                            ->required()
                            ->options(fn () => collect(range(9, 18))
                                ->mapWithKeys(fn ($h) => [
                                    sprintf('%02d:00', $h) => sprintf('%02d:00', $h)
                                ])
                                ->toArray()
                            )
                            ->rule(function ($get) {
                                return function (string $attribute, $value, \Closure $fail) use ($get) {
                                    $exists = \App\Models\DoctorSchedule::where('doctor_id', $this->ownerRecord->id)
                                        ->where('date', $get('date'))
                                        ->where('hour', $value)
                                        ->exists();

                                    if ($exists) {
                                        $fail("Цей час вже записаний");
                                    }
                                };
                            }),
                    ]),

                Select::make('status')
                    ->label('Статус')
                    ->options([
                        'non_working' => 'Не працює',
                        'available' => 'Вільно',
                        'busy' => 'Зайнято',
                    ])
                    ->required(),
            ]);
    }

    // Метод getScheduleFormSchema удален, так как его логика перенесена в form(Schema $schema): Schema

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) =>
            $query->where('date', '>=', now()->toDateString())
            )
            ->recordTitleAttribute('date')
            ->columns([
                TextColumn::make('date')
                    ->label('Дата')
                    ->date('d.m.Y (D)') // Формат даты с днем недели
                    ->sortable(),

                TextColumn::make('hour')
                    ->label('Час')
                    ->time('H:i')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Статус')
                    ->badge() // Превращаем TextColumn в бейдж
                    ->colors([
                        'danger' => 'non_working', // Красный для "Не працює"
                        'success' => 'available',   // Зеленый для "Вільно"
                        'warning' => 'busy',      // Желтый/Оранжевый для "Зайнято"
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'non_working' => 'Не працює',
                        'available' => 'Вільно',
                        'busy' => 'Зайнято',
                        default => $state,
                    })
                    ->sortable(),
            ])
            ->filters([
                //
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


    // Отключение создания и удаления
    protected function canCreate(): bool
    {
        // Возможно, лучше создавать записи через отдельную функцию генерации
        return false;
    }

    protected function canDeleteAny(): bool
    {
        return false;
    }
}
