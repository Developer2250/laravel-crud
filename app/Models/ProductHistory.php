<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductHistory extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'field_name', 'old_value', 'new_value', 'category_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
