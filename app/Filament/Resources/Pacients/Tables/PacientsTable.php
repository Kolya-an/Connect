<?php

namespace App\Filament\Resources\Pacients\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PacientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => 
                $query->whereHas('user', fn (Builder $q) => $q->where('active', '!=', 2))
            )
            ->columns([
                TextColumn::make('user.name')
                    ->label("Ім'я")
                    ->searchable()
                    ->sortable(),
                TextColumn::make('second_name')
                    ->label('Прізвище')
                    ->searchable(),
                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('birthday')
                    ->label('Дата народження')
                    ->date()
                    ->sortable(),
                ImageColumn::make('photo')
                    ->label('Фото')
                    ->disk('public_uploads')
                    ->visibility('public')
                    ->imageSize(40),
                TextColumn::make('phone')
                    ->label('Телефон')
                    ->searchable(),
                TextColumn::make('city')
                    ->label('Місто')
                    ->searchable(),
                TextColumn::make('sex')
                    ->label('Стать'),
                IconColumn::make('notification')
                    ->label('Підписаний?')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Зареєстровано')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
