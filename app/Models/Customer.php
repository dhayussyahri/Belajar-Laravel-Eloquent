<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Date;

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

    public function reviews():HasMany
    {
        return $this->hasMany(Review::class, "customer_id", "id");
    }

    public function likesProducts():BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            "customers_likes_products",
            "customer_id",
            "product_id"
        )->withPivot("created_at")
        ->using(Like::class);
    }

    public function likesProductsLastWeek():BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            "customers_likes_products",
            "customer_id",
            "product_id"
        )->withPivot("created_at")
        ->wherePivot("created_at", ">=", Date::now()->addDays(-7)
        ->using(Like::class));
    }

    public function image():MorphOne
    {
        return $this->morphOne(Image::class, "imageable");
    }
}
