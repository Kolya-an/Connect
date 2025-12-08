<?php

namespace App\Filament\Resources\News\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\RichEditor\RichContentRenderer;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()



                            ->schema([



                TextInput::make('title')
                    ->label("Назва")
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set) =>
                    $set('slug', Str::slug($state))
                    ),
                TextInput::make('slug')
                    //->disabled()
                    ->dehydrated()
                    ->unique(ignoreRecord: true),
                Select::make('categories')
                    ->label('Категорії')
                    ->multiple()
                    ->relationship('categories', 'title')
                    ->preload(),
                TextInput::make('meta_title'),
                FileUpload::make('images')
                    ->label('Зображення зверху')
                    ->directory('news/' . date('Y') . '/' . date('m'))
                    ->disk('public_uploads')
                    ->visibility('public')
                    ->image()
                    ->imageEditor()
                    //->acceptedFileTypes(['images/png','images/jpeg'])
                    /*->imageEditorAspectRatios([
                        null,
                        '16:9',
                        '4:3',
                        '1:1',
                    ])*/
                                ,
                Textarea::make('meta_description')
                    ->columnSpanFull(),

                Textarea::make('preview')
                    ->label("Текст прев'ю")
                    ->columnSpanFull(),
                Toggle::make('status')
                    ->label('Опубліковано?')
                    ->required(),

                ])->columns(2),






                Section::make('Основная информация')
                    ->schema([
                        Builder::make('content')
                            ->blocks([
                                Block::make('heading')
                                    ->label('Заголовок')
                                    ->schema([
                                        TextInput::make('heading_text')
                                            ->label('Текст')
                                            ->required(),
                                        Select::make('level')
                                            ->label('Рівень')
                                            ->options([
                                                'h1' => 'Heading 1',
                                                'h2' => 'Heading 2',
                                                'h3' => 'Heading 3',
                                                'h4' => 'Heading 4',
                                                'h5' => 'Heading 5',
                                                'h6' => 'Heading 6',
                                            ])
                                            ->required(),
                                    ])
                                    ->columns(2),
                                Block::make('paragraph')
                                    ->label('Текст')
                                    ->schema([
                                        RichEditor::make('content')
                                            ->label('Текст')
                                            ->floatingToolbars([
                                                'paragraph' => [
                                                    'bold', 'italic', 'underline', 'strike', 'subscript', 'superscript',
                                                ],
                                                'heading' => [
                                                    'h1', 'h2', 'h3'
                                                ],
                                                'table' => [
                                                    'tableAddColumnBefore', 'tableAddColumnAfter', 'tableDeleteColumn',
                                                    'tableAddRowBefore', 'tableAddRowAfter', 'tableDeleteRow',
                                                    'tableMergeCells', 'tableSplitCell',
                                                    'tableToggleHeaderRow',
                                                    'tableDelete',
                                                ],
                                            ])
                                    ]),
                                Block::make('image_text')
                                    ->label('Фото + текст')
                                    ->schema([
                                        FileUpload::make('images')
                                            ->label('Фото')
                                            ->image()
                                            ->required(),
                                        RichEditor::make('content')
                                            ->label('Текст'),


                                    ]),

                                Block::make('important')
                                    ->label('Блок Важливо')
                                    ->schema([
                                        Textarea::make('text')
                                            ->label("Текст")
                                            ->columnSpanFull(),
                                    ]),

                            ])
                    ])
        ])->columns(1);
    }
}
