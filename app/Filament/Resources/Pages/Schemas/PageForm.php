<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Назва')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) =>
                    $set('slug', Str::slug($state))
                    ),

                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('meta_name')
                    ->label('Meta Title'),

                Textarea::make('meta_desc')
                    ->label('Meta Description')
                    ->rows(3),

                RichEditor::make('content')
                    ->required()
                    ->columnSpanFull(),

                Toggle::make('is_published')
                    ->label('Опубликована')
                    ->default(true),
            ]);
    }
}
