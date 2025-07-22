<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price'];

    public function customers()
{
    return $this->belongsToMany(Customer::class);
}
}
