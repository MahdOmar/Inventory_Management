<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotedetails extends Model
{
    protected $fillable=['productId','quoteId','quantity','price'];
}
