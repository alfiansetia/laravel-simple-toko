<?php

namespace App\Enums;

enum TransactionStatus: string
{
    case DONE = "done";
    case PENDING = "pending";
    case CANCEL = "cancel";
}
