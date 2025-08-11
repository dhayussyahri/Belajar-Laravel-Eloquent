<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Scopes\isActiveScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Hash;

class Category extends Model
{
    protected $table = "categories";
    protected $primaryKey = "id";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = false;
    protected $casts = [
        'created_at' => 'datetime:U'
    ];

    protected $fillable = [
        // mengizinkan kolom kolom mana saja yg dapat diubah
        "id",
        "name",
        "description"
    ];
    public function products():HasMany
    {
        return $this->hasMany(Product::class, "category_id", "id");
    }

    // Product yg paling murah
    public function cheapestProduct():HasOne
    {
        return $this->hasOne(Product::class, "category_id", "id")->oldest("price");

    }
    // product yg paling mahal
    public function mostExpensiveProduct():HasOne
    {
        return $this->hasOne(Product::class, "category_id", "id")->latest("price");
    }
    protected static function booted():void
    {
        parent::booted();
        self::addGlobalScope(new isActiveScope());
    }

    public function reviews():HasManyThrough
    {
        return $this->hasManyThrough(
            Review::class,
            Product::class,
            "category_id", // FK on products table
            "product_id", // FK on reviews table
            "id", // PK on categories table
            "id" // PK on products table
        );

    }
}
