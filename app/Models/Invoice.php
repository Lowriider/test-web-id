<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Invoice extends Model
{
    use HasFactory;

    protected $appends = ['total'];
    protected $hidden = ['content', 'created_at', 'updated_at'];
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class,'invoice_products');
    }

    public function getTotalAttribute()
    {
        return $this->products()->sum('price');
    }
}
