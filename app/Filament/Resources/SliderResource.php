<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SliderResource\Pages;
use App\Models\Slider;
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

class SliderResource extends Resource
{
    protected static ?string $model = Slider::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo'; // Heroicon ishlatganda

    protected static ?string $navigationLabel = 'Bannerlar';
    protected static ?int $navigationSort = 3; // Tartib (ixtiyoriy)

    public static function getPluralModelLabel(): string
    {
        return 'Bannerlar'; // Default "Videos" o‘rniga chiqadigan nom
    }

    public static function getModelLabel(): string
    {
        return 'Banner';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Translations')
                    ->tabs([
                        Tab::make('O‘zbekcha')->schema([
                            TextInput::make('title.uz')
                                ->label('Sarlavha (Uzbek)')
                                ->required(),
                        ]),
                        Tab::make('Русский')->schema([
                            TextInput::make('title.ru')
                                ->label('Sarlavha (Russian)')
                                ->required(),
                        ]),
                        Tab::make('English')->schema([
                            TextInput::make('title.en')
                                ->label('Sarlavha (English)')
                                ->required(),
                        ]),
                    ])->columnSpanFull(),
                Tabs::make('Translations')
                    ->tabs([
                        Tab::make('O‘zbekcha')->schema([
                            TextInput::make('description.uz')
                                ->label('Tavsifi (Uzbek)')
                                ->required(),
                        ]),
                        Tab::make('Русский')->schema([
                            TextInput::make('description.ru')
                                ->label('Tavsifi (Russian)')
                                ->required(),
                        ]),
                        Tab::make('English')->schema([
                            TextInput::make('description.en')
                                ->label('Tavsifi (English)')
                                ->required(),
                        ]),
                    ])->columnSpanFull(),
                FileUpload::make('image')
                ->directory('sliders')
                ->image()
                ->maxSize(2048)
                ->label('Rasmi')
                ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                ->label('Rasmi')
                ->size(100),
                TextColumn::make('title')
                ->label('Sarlavha (Uzbek)')
                ->limit(50),
                TextColumn::make('description')
                ->label('Tavsifi (Uzbek)')
                ->limit(50),
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
            'index' => Pages\ListSliders::route('/'),
            'create' => Pages\CreateSlider::route('/create'),
            'edit' => Pages\EditSlider::route('/{record}/edit'),
        ];
    }
}
