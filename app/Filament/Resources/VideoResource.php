<?php
namespace App\Filament\Resources;

use App\Filament\Resources\VideoResource\Pages;
use App\Models\Video;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
class VideoResource extends Resource
{
    protected static ?string $model = Video::class;
    protected static ?string $navigationIcon = 'heroicon-o-video-camera';

    protected static ?string $navigationGroup = 'Media boshqaruvi';
    protected static ?string $navigationLabel = 'Videolar';
    protected static ?int $navigationSort = 2; // Tartib (ixtiyoriy)

    public static function getPluralModelLabel(): string
    {
        return 'Videolar'; // Default "Videos" o‘rniga chiqadigan nom
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('video')
                    ->label('Video yuklash')
                    ->directory('videos') // Fayllarni 'storage/app/public/videos' ga yuklaydi
                    ->acceptedFileTypes(['video/mp4', 'video/mov', 'video/avi'])
                    ->maxSize(102400) // Maksimal 100MB
                    ->disk('public') // 'public' diskiga yuklash
                    ->preserveFilenames(false) // Asl fayl nomini o‘zgartirish
                    ->getUploadedFileNameForStorageUsing(fn ($file) => (string) md5(rand(1111,9999).microtime()).'.'. $file->getClientOriginalExtension())
                    ->required(),
                FileUpload::make('thumbnail')
                    ->label('Thumbnail yuklash')
                    ->directory('thumbnails')
                    ->image()
                    ->maxSize(2048), // Maksimal 2MB
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
                            TextInput::make('text.uz')
                                ->label('Tavsifi (Uzbek)')
                                ->required(),
                        ]),
                        Tab::make('Русский')->schema([
                            TextInput::make('text.ru')
                                ->label('Tavsifi (Russian)')
                                ->required(),
                        ]),
                        Tab::make('English')->schema([
                            TextInput::make('text.en')
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
                ImageColumn::make('thumbnail')
                    ->label('Rasmi')
                    ->size(100),
                TextColumn::make('title')
                    ->label('Nomi')
                    ->limit(50),
                TextColumn::make('text')
                    ->label('Tavsifi')
                    ->limit(50),

                TextColumn::make('created_at')
                    ->label('Yaratilgan sana')
                    ->dateTime(),
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Tahrirlash'),
                Tables\Actions\DeleteAction::make()->label('O\'chirish'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVideos::route('/'),
            'create' => Pages\CreateVideo::route('/create'),
            'edit' => Pages\EditVideo::route('/{record}/edit'),
        ];
    }
}
