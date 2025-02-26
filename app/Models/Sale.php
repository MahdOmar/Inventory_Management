<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable=['total_amount','discount','status'];

    public function payments()
    {
        return $this->hasMany(Payment::class,'saleId');

    }  

    public function quote()
    {
        return $this->hasOne(Quote::class);

    }  

}
