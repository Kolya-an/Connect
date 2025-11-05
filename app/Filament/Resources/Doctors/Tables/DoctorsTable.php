<?php

namespace App\Filament\Resources\Doctors\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\ImageEntry;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DoctorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label("Ім'я")
                    ->searchable()
                    ->sortable(),
                TextColumn::make('second_name')
                    ->label('Прізвище')
                    ->searchable()
                    ->sortable(),
                ImageColumn::make('photo')
                    ->label('Фото')
                    ->disk('public_uploads')
                    ->visibility('public')
                    ->imageSize(40),
                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('birthday')
                    ->label('Дата народження')
                    ->date()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('Телефон')
                    ->searchable(),
                TextColumn::make('city')
                    ->label('Місто')
                    ->searchable(),
                TextColumn::make('area')
                    ->label('Район/Метро')
                    ->searchable(),
                TextColumn::make('address')
                    ->label('Адреса')
                    ->searchable(),
                TextColumn::make('experience')
                    ->label('Досвід')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('rating')
                    ->label('Рейтинг')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('sex')
                    ->label('Стать')
                    ->sortable(),
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
