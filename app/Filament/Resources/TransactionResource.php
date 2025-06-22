<?php

namespace App\Filament\Resources;

use App\Enums\TransactionStatus;
use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'email')
                    ->disabled()
                    ->preload()
                    ->required(),
                DateTimePicker::make('date')
                    ->format('Y-m-d H:i:s')
                    ->displayFormat('d/m/Y H:i:s')
                    ->native(false)
                    ->disabled()
                    ->required(),
                TextInput::make('code')
                    ->label('Code')
                    ->required()
                    ->disabled()
                    ->maxLength(100),
                TextInput::make('total')
                    ->label('Total')
                    ->integer()
                    ->minValue(0)
                    ->disabled()
                    ->required(),
                Select::make('status')
                    ->label('Status')
                    ->options(collect(TransactionStatus::cases())->mapWithKeys(fn($status) => [
                        $status->value => $status->label(),
                    ]))
                    ->default(TransactionStatus::PENDING->value)
                    ->searchable()
                    ->disabled()
                    ->preload()
                    ->required(),
                Repeater::make('items')
                    ->relationship('items')
                    ->label('Transaction Items')
                    ->disabled()
                    ->columns(3)
                    ->schema([
                        Select::make('product_id')
                            ->label('Product')
                            ->relationship('product', 'name')
                            ->searchable()
                            ->preload()
                            ->disabled()
                            ->required(),
                        TextInput::make('qty')->label('Qty')->disabled(),
                        TextInput::make('price')->label('Price')->disabled(),
                    ])
                    ->visible(fn($livewire) => filled($livewire->record))
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.email')->searchable(),
                TextColumn::make('date')->searchable(),
                TextColumn::make('code')->searchable(),
                TextColumn::make('total')->searchable(),
                TextColumn::make('status')->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('Cancel')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn(Transaction $record) => ($record->status == TransactionStatus::PENDING->value || $record->status == TransactionStatus::DONE->value))
                    ->action(function (Transaction $record) {
                        $record->update(['status' => TransactionStatus::CANCEL->value]);
                        Notification::make()
                            ->title('Transaction Canceled')
                            ->success()
                            ->send();
                    }),

                Action::make('Done')
                    ->color('success')
                    ->visible(fn(Transaction $record) => $record->status == TransactionStatus::PENDING->value)
                    ->action(function (Transaction $record) {
                        $record->update(['status' => TransactionStatus::DONE->value]);
                        Notification::make()
                            ->title('Transaction marked as done')
                            ->success()
                            ->send();
                    }),

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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
