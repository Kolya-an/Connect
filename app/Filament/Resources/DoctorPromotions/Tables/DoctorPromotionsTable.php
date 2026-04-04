<?php

namespace App\Filament\Resources\DoctorPromotions\Tables;

use App\Models\Doctor;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DoctorPromotionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('doctor_full_name')
                    ->label('Лікар')
                    ->state(function ($record): ?string {
                        $name = $record->doctor?->user?->name;
                        $secondName = $record->doctor?->second_name;

                        if ($name || $secondName) {
                            return trim("{$name} {$secondName}");
                        }
                        return null;
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        // Используем whereHas для поиска по фамилии через цепочку связей:
                        // reviews -> appointment -> doctor
                        return $query->whereHas('doctor', function (Builder $q) use ($search) {
                            $q->where('second_name', 'like', "%{$search}%");
                        });
                    })
                    ->sortable(false),
                TextColumn::make('title')
                    ->label('Назва')
                    ->searchable(),
                TextColumn::make('old_price')
                    ->label('Стара ціна')
                    ->numeric(),
                TextColumn::make('new_price')
                    ->label('Нова ціна')
                    ->numeric(),
                TextColumn::make('date_from')
                    ->label('Початок')
                    ->date()
                    ->sortable(),
                TextColumn::make('date_to')
                    ->label('Кінець')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('doctor')
                    ->relationship('doctor', 'second_name', modifyQueryUsing: fn (Builder $query) => $query->with(['user']))
                    ->label('Лікар')
                    ->getOptionLabelFromRecordUsing(fn ($record) => trim(($record->user?->name ?? '') . ' ' . ($record->second_name ?? '')))
                    ->searchable()
                    ->preload(),
                Filter::make('title')
                    ->form([
                        \Filament\Forms\Components\TextInput::make('title')
                            ->label('Назва')
                            ->placeholder('Фільтр за назвою...'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['title'],
                                fn (Builder $query, $title): Builder => $query->where('title', 'like', "%{$title}%"),
                            );
                    }),
                Filter::make('date_from')
                    ->form([
                        DatePicker::make('date_from')
                            ->label('Початок від'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['date_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date_from', '>=', $date),
                            );
                    }),
                Filter::make('date_to')
                    ->form([
                        DatePicker::make('date_to')
                            ->label('Кінець до'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['date_to'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date_to', '<=', $date),
                            );
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
