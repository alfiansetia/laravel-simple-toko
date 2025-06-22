<?php

namespace App\Enums;

enum TransactionStatus: string
{
    case DONE = "done";
    case PENDING = "pending";
    case CANCEL = "cancel";

    public function label(): string
    {
        return match ($this) {
            self::DONE => 'Done',
            self::PENDING => 'Pending',
            self::CANCEL => 'Cancel',
        };
    }
}
