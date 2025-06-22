<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Enums\TransactionStatus;
use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditTransaction extends EditRecord
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [

            // Actions\DeleteAction::make(),
            Action::make('Cancel')
                ->color('danger')
                ->label('Cancel')
                ->requiresConfirmation()
                ->visible(fn() => ($this->record->status === TransactionStatus::PENDING->value || $this->record->status === TransactionStatus::DONE->value))
                ->action(function () {
                    $this->record->update(['status' => TransactionStatus::CANCEL->value]);
                    Notification::make()
                        ->title('Transaction Canceled')
                        ->success()
                        ->send();
                }),

            Action::make('Mark as Done')
                ->color('success')
                ->label('Mark as Done')
                ->visible(fn() => $this->record->status === TransactionStatus::PENDING->value)
                ->action(function () {
                    $this->record->update(['status' => TransactionStatus::DONE->value]);
                    Notification::make()
                        ->title('Transaction marked as done')
                        ->success()
                        ->send();
                }),
        ];
    }
}
