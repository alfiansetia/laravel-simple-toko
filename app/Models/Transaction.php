<?php

namespace App\Models;

use App\Enums\TransactionStatus;
use App\Services\WhatsappService;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = ['id'];

    public $timestamps = false;

    protected $casts = [
        'status' => TransactionStatus::class,
    ];

    // protected static function boot()
    // {
    //     parent::boot();
    //     static::created(function ($trx) {
    //         $trx->sendNotifOrderToAdmin();
    //         $trx->sendNotifOrderToUser();
    //     });
    // }

    public function sendNotifOrderToAdmin()
    {
        WhatsappService::sendNotifOrderToAdmin($this);
    }

    public function sendNotifOrderToUser()
    {
        WhatsappService::sendNotifOrderToUser($this);
    }

    public function sendNotifOrderDoneToUSer()
    {
        WhatsappService::sendNotifOrderDoneToUser($this);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function isDone()
    {
        return $this->status == TransactionStatus::DONE;
    }

    public function isPending()
    {
        return $this->status == TransactionStatus::PENDING;
    }

    public function isCancel()
    {
        return $this->status == TransactionStatus::CANCEL;
    }
}
