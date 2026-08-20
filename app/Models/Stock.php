<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    //registrasi nama table stocks
    protected $table = "stocks";

    // registrasi nama field table stocks
    protected $fillable = ['quantity', 'status', 'created_by', 'product_id'];

    // registrasi nama relasi table stocks ketable products
    public function product() {
        return $this->belongsTo(Product::class);
    }
}
