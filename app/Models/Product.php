<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'is_active',
        'category_id',
        'price',
        'quantity',
    ];

    public function logHistory($fieldName, $oldValue, $newValue, $categoryId)
    {
        ProductHistory::create([
            'product_id' => $this->id,
            'field_name' => $fieldName,
            'old_value' => $oldValue,
            'new_value' => $newValue,
            'category_id' => $categoryId
        ]);
    }

    public function histories()
    {
        return $this->hasMany(ProductHistory::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
