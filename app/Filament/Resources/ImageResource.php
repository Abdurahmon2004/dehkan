<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ImageResource\Pages;
use App\Filament\Resources\ImageResource\RelationManagers;
use App\Models\Gallery;
use App\Models\Image;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
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
use function Laravel\Prompts\text;

class ImageResource extends Resource
{
    protected static ?string $model = Gallery::class;

    public static function getModelLabel(): string
    {
        return 'Rasm';
    }
    public static function getPluralModelLabel(): string
    {
        return 'Rasmlar'; // Default "Videos" o‘rniga chiqadigan nom
    }
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Media boshqaruvi';
    protected static ?string $navigationLabel = 'Rasmlar';
    protected static ?int $navigationSort = 3;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Translations')
                    ->tabs([
                        Tab::make('O‘zbekcha')->schema([
                            TextInput::make('title.uz')
                                ->label('Tekst (Uzbek)')
                                ->required(),
                        ]),
                        Tab::make('Русский')->schema([
                            TextInput::make('title.ru')
                                ->label('Tekst (Russian)')
                                ->required(),
                        ]),
                        Tab::make('English')->schema([
                            TextInput::make('title.en')
                                ->label('Tekst (English)')
                                ->required(),
                        ]),
                    ])->columnSpanFull(),

                FileUpload::make('image')
                ->directory('images')
                ->label('Rasm')
                ->image()
                ->maxSize(4096)
                ->required(),
            ]);

    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                ->label('Rasm')
                ->size(100),
                TextColumn::make('title')
                ->label('Nomi')
                ->limit(50),
                TextColumn::make('created_at')
                ->label('Yaratilgan sanasi')
                ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Tahrirlash'),
                Tables\Actions\DeleteAction::make()->label('O\'chirish'),
            ])
            ->bulkActions([
                    Tables\Actions\DeleteBulkAction::make(),
            ])->defaultSort('created_at', 'DESC');
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListImages::route('/'),
            'create' => Pages\CreateImage::route('/create'),
            'edit' => Pages\EditImage::route('/{record}/edit'),
        ];
    }
}
