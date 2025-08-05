<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Scopes\isActiveScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    protected static function booted():void
    {
        parent::booted();
        self::addGlobalScope(new isActiveScope());
    }

}
