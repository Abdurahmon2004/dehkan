<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteInfoResource\Pages;
use App\Filament\Resources\SiteInfoResource\RelationManagers;
use App\Models\SiteInfo;
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

class SiteInfoResource extends Resource
{
    protected static ?string $model = SiteInfo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Sayt ma\'lumotlari';
    protected static ?int $navigationSort = 2;

    public static function getPluralModelLabel(): string
    {
        return 'Sayt ma\'lumotlari'; // Default "Videos" o‘rniga chiqadigan nom
    }
    public static function getModelLabel(): string
    {
        return 'Ma\'lumot';
    }

    public static function canCreate(): bool
    {
        return SiteInfo::count() === 0;
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('phone')
                ->label('Telefon raqam')
                ->required()
                ->type('text'),
                TextInput::make('email')
                ->label('Email')
                ->required()
                ->type('email'),
                Tabs::make('Translations')
                    ->tabs([
                        Tab::make('O‘zbekcha')->schema([
                            TextInput::make('address.uz')
                                ->label('Manzil (Uzbek)')
                                ->required(),
                        ]),
                        Tab::make('Русский')->schema([
                            TextInput::make('address.ru')
                                ->label('Manzil (Russian)')
                                ->required(),
                        ]),
                        Tab::make('English')->schema([
                            TextInput::make('address.en')
                                ->label('Manzil (English)')
                                ->required(),
                        ]),
                    ])->columnSpanFull(),
                FileUpload::make('logo')
                ->label('Logo')
                ->image()
                ->directory('logo')
                ->maxSize(2048)
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                ->label('Logo')
                ->size(100),
                TextColumn::make('phone')
                ->label('Telefon raqam'),
                TextColumn::make('email')
                ->label('Email'),
                TextColumn::make('address')
                ->label('Manzil'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListSiteInfos::route('/'),
            'create' => Pages\CreateSiteInfo::route('/create'),
            'edit' => Pages\EditSiteInfo::route('/{record}/edit'),
        ];
    }
}
