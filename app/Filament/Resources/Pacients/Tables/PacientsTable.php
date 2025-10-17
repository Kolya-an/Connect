<?php

namespace App\Filament\Resources\Pacients\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PacientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('second_name')
                    ->searchable(),
                TextColumn::make('user.email')
                    ->searchable(),
                TextColumn::make('birthday')
                    ->date()
                    ->sortable(),
                ImageColumn::make('photo')
                    ->disk('public_uploads')
                    ->visibility('public')
                    ->imageSize(40),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('city')
                    ->searchable(),
                TextColumn::make('sex'),
                IconColumn::make('notification')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                //
            ])
            ->recordActions([
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
