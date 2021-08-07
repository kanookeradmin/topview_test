<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPackage extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'package_id', 'tickets_purchased'];
    public function getOrder()
    {
        return $this->belongsTo(Order::class);
    }
    public function getPackage()
    {
        return $this->hasOne(Package::class, 'id', 'package_id');
    }

}
