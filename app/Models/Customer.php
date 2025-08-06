<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Customer extends Model
{
    protected $table = "customers";
    protected $primaryKey = "id";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = false;

    public function wallet():HasOne
    {
        return $this->hasOne(wallet::class, "customer_id", "id");
    }

    // membuat relasi melewati satu relasi : virtual_account --> wallet --> customer
    public function virtualAccount(): HasOneThrough
    {
        return $this->hasOneThrough(
            VirtualAccount::class, wallet::class,
            "customer_id", // FK on Wallets table
            "wallet_id", // FK on virtual_account table
            "id", // PK on customers table
            "id" // PK on wallets table
        );
    }
}
