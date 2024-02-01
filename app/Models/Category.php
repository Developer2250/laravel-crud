<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    public function logHistory($productID, $fieldName, $oldValue, $newValue, $categoryID)
    {
        ProductHistory::create([
            'product_id' => $productID,
            'field_name' => $fieldName,
            'old_value' => $oldValue,
            'new_value' => $newValue,
            'category_id' => $categoryID
        ]);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function productsHistory()
    {
        return $this->hasMany(ProductHistory::class);
    }
}
