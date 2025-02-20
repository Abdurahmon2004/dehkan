<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutResource\Pages;
use App\Filament\Resources\AboutResource\RelationManagers;
use App\Models\About;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AboutResource extends Resource
{
    protected static ?string $model = About::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Biz haqimizda';
    protected static ?int $navigationSort = 2;
    public static function canCreate(): bool
    {
        return About::count() === 0; // Faqat jadval bo'sh bo‘lsa, yaratish mumkin
    }

    public static function getModelLabel(): string
    {
        return 'Biz haqimizda';
    }
    public static function getPluralModelLabel(): string
    {
        return 'Biz haqimizda'; // Default "Videos" o‘rniga chiqadigan nom
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('image')
                ->label('Rasmi')
                ->directory('about')
                ->image()
                ->maxSize(2048)
                ->required(),
                Tabs::make('Translations')
                    ->tabs([
                        Tab::make('O‘zbekcha')->schema([
                           RichEditor::make('description.uz')
                                ->label('Tavsifi (Uzbek)')
                                ->required(),
                        ]),
                        Tab::make('Русский')->schema([
                            RichEditor::make('description.ru')
                                ->label('Tavsifi (Russian)')
                                ->required(),
                        ]),
                        Tab::make('English')->schema([
                            RichEditor::make('description.en')
                                ->label('Tavsifi (English)')
                                ->required(),
                        ]),
                    ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                ->label('Rasmi')
                ->size(100),
                TextColumn::make('description')
                ->label('Tavsifi (Uzbek)')
                    ->html()
                ->limit(100),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAbouts::route('/'),
            'create' => Pages\CreateAbout::route('/create'),
            'edit' => Pages\EditAbout::route('/{record}/edit'),
        ];
    }
}
