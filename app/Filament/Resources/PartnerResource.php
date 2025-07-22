<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartnerResource\Pages;
use App\Filament\Resources\PartnerResource\RelationManagers;
use App\Models\Partner;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Translations')
                    ->tabs([
                        Tab::make('O‘zbekcha')->schema([
                            TextInput::make('name.uz')
                                ->label('Nomi (Uzbek)')
                        ]),
                        Tab::make('Русский')->schema([
                            TextInput::make('name.ru')
                                ->label('Nomi (Russian)')
                        ]),
                        Tab::make('English')->schema([
                            TextInput::make('name.en')
                                ->label('Nomi (English)')
                        ]),
                    ])->columnSpanFull(),
                Tabs::make('Translations')
                    ->tabs([
                        Tab::make('O‘zbekcha')->schema([
                            TextInput::make('description.uz')
                                ->label('Tavsifi (Uzbek)')
                        ]),
                        Tab::make('Русский')->schema([
                            TextInput::make('description.ru')
                                ->label('Tavsifi (Russian)')
                        ]),
                        Tab::make('English')->schema([
                            TextInput::make('description.en')
                                ->label('Tavsifi (English)')
                        ]),
                        FileUpload::make('image')
                            ->directory('images')
                            ->label('Rasm')
                            ->image()
                            ->maxSize(4096)
                            ->required(),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListPartners::route('/'),
            'create' => Pages\CreatePartner::route('/create'),
            'edit' => Pages\EditPartner::route('/{record}/edit'),
        ];
    }
}
