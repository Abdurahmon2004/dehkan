<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
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

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench';

    public static function getModelLabel(): string
    {
        return 'Hizmat';
    }
    public static function getPluralModelLabel(): string
    {
        return 'Hizmatlar'; // Default "Videos" o‘rniga chiqadigan nom
    }

    protected static ?string $navigationLabel = 'Hizmatlar';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('image')
                    ->directory('services')
                    ->image()
                    ->maxSize(2048)
                    ->label('Rasmi')
                    ->required(),
                Tabs::make('Translations')
                    ->tabs([
                        Tab::make('O‘zbekcha')->schema([
                            TextInput::make('title.uz')
                                ->label('Nomi (Uzbek)')
                                ->required(),
                        ]),
                        Tab::make('Русский')->schema([
                            TextInput::make('title.ru')
                                ->label('Nomi (Russian)')
                                ->required(),
                        ]),
                        Tab::make('English')->schema([
                            TextInput::make('title.en')
                                ->label('Nomi (English)')
                                ->required(),
                        ]),
                    ])->columnSpanFull(),
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
                TextColumn::make('title')
                    ->label('Nomi (Uzbek)')
                    ->html()
                    ->limit(100),
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
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
