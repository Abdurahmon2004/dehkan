<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Filament\Resources\ContactResource\RelationManagers;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Kontaktlar';
    protected static ?int $navigationSort = 4;

    public static function getPluralModelLabel(): string
    {
        return 'Kontaktlar '; // Default "Videos" o‘rniga chiqadigan nom
    }
    public static function canCreate(): bool
    {
        return false;
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Toggle::make('status')
                    ->label('O‘qilgan / O‘qilmagan')
                    ->onColor('danger')
                    ->offColor('success')
                    ->inline(false)
            ]);
    }

    public static function getNavigationLabel(): string
    {
        // Statusi 1 bo'lgan kontaktlarni hisoblash
        $unreadCount = Contact::where('status', 1)->count();

        // Navigation labelga son qo'shish
        return parent::getNavigationLabel() . " ($unreadCount)";
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->label('F.I.O')
                ->limit(50),
                TextColumn::make('email')
                ->label('Email')
                ->limit(50),
                TextColumn::make('message')
                ->label('Message')
                ->limit(50),
                TextColumn::make('created_at')
                ->label('Qo\'shilgan sanasi')
                ->dateTime(),
                TextColumn::make('status')
                    ->label('Holat')
                    ->formatStateUsing(fn ($state) => $state == 1 ? 'O‘qilmagan' : 'O‘qilgan')
                    ->badge()
                    ->color(fn ($state) => $state == 1 ? 'danger' : 'success'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                BulkAction::make('deactivate')
                    ->label("O'qilgan deb belgilash")
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation()
                    ->action(function (Collection $records) { // To‘g‘ri namespace ishlatilgan
                        $records->each(fn ($record) => $record->update(['status' => 0])); // Bulk update

                        Notification::make()
                            ->title('Muvaffaqiyatli!')
                            ->body('Tanlangan kontaktlarning o\'qilgan deb belgilandi.')
                            ->success()
                            ->send();
                        return redirect(request()->header('Referer'));
                    })->requiresConfirmation(),

            ])->headerActions([])
            ->defaultSort('status', 'desc');
    }

    public static function navigation(array $navigation): array
    {
        // Navigationdan "Yangi yaratish" tugmasini olib tashlash
        return array_filter($navigation, fn ($item) => $item->getName() !== 'new');
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
            'index' => Pages\ListContacts::route('/'),
//            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
