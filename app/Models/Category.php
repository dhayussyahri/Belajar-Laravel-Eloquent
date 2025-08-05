<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Scopes\isActiveScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Hash;

class Category extends Model
{
    protected $table = "categories";
    protected $primaryKey = "id";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = false;

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
    public function mostExpensiveProducet():HasOne
    {
        return $this->hasOne(Product::class, "category_id", "id")->latest("price");
    }
    protected static function booted():void
    {
        parent::booted();
        self::addGlobalScope(new isActiveScope());
    }

}
