<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Для генерации фикстур
use Illuminate\Database\Eloquent\Model;

class OrderStat extends Model
{
    use HasFactory;
    protected $fillable = ['customer_name', 'service_category', 'order_date', 'revenue', 'status'];
}