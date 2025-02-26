<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable=['Supplier','Date','Total'];

    public function products()
    {
        return $this->belongsToMany(Product::class,'purchasedetails',"purchaseId","productId");
    }    

}
