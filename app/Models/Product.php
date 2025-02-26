<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable=['designation','quantity','category','price_a','price_v'];

    public function purchases()
    {
        return $this->belongsToMany(Purchase::class,'purchasedetails',"productId","purchaseId");

    }    

    public function quotes()
    {
        return $this->belongsToMany(Quote::class,'quotedetails',"productId","quoteId");

    }    






}
