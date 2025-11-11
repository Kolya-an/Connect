<?php

namespace App\Filament\Resources\Abouts\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AboutForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Налаштування')
                    ->schema([
                     TextInput::make('title')
                        ->label('Назва'),
                     TextInput::make('slug')
                        ->label('Slug'),
                     TextInput::make('meta_name')
                        ->label('Meta name'),
                     TextInput::make('meta_description')
                        ->label('Meta description'),
                ]),

                Section::make('Перший блок')
                    ->schema([
                     TextInput::make('first_name')
                        ->label('Назва компанії'),
                     TextInput::make('first_sentience')
                        ->label('Перше речення'),
                     TextInput::make('second_sentience')
                        ->label('Друге речення'),
                    RichEditor::make('second_text')
                        ->label('Текст')
                        ->toolbarButtons([
                            'bold',
                            'italic',
                            'underline',
                            'strike',
                            'h1',
                            'h2',
                            'h3',
                            'bulletList',
                            'orderedList',
                            'link',
                            'blockquote',
                            'table',
                        ])
                        ->extraInputAttributes([
                            'class' => 'color-rich-editor'
                        ])
                ]),

                Section::make('Сірий блок')
                    ->schema([
                     TextInput::make('grey_name')
                        ->label('Назва компанії'),
                     TextInput::make('grey_title')
                        ->label('Друга частина назви'),
                    RichEditor::make('grey_text')
                        ->label('Текст')
                        ->toolbarButtons([
                            'bold',
                            'italic',
                            'underline',
                            'strike',
                            'h1',
                            'h2',
                            'h3',
                            'bulletList',
                            'orderedList',
                            'link',
                            'blockquote',
                            'table',
                        ])
                ]),

                Section::make('Акції, рейтинг та фотобанк')
                    ->schema([
                    RichEditor::make('action_text')
                        ->label('Текст в Акції')
                        ->toolbarButtons([
                            'bold',
                            'italic',
                            'underline',
                            'strike',
                            'h1',
                            'h2',
                            'h3',
                            'bulletList',
                            'orderedList',
                            'link',
                            'blockquote',
                            'table',
                        ]),
                    RichEditor::make('rating_text')
                        ->label('Текст в Рейтинг')
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
                            ]
                    ]),
                   RichEditor::make('photobank_text')
                        ->label('Текст в Фотобанк')
                       ->toolbarButtons([
                           'bold',
                           'italic',
                           'underline',
                           'strike',
                           'h1',
                           'h2',
                           'h3',
                           'bulletList',
                           'orderedList',
                           'link',
                           'blockquote',
                           'table',
                       ])

                ]),

                Section::make('Ваша сторінка')
                    ->schema([
                        RichEditor::make('our_text')
                            ->label('Текст')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'h1',
                                'h2',
                                'h3',
                                'bulletList',
                                'orderedList',
                                'link',
                                'blockquote',
                                'table',
                            ]),
                        TextInput::make('our_rose_text')
                            ->label('Текст в рожевому блоці'),
                    ]),




            ]);
    }
}
