<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sell extends Model
{
    use HasFactory;
    protected $table = 'sale_detail';
    protected $fillable =[
        'carId',
        'customerId',
        'price',
        'authorId',
        'saleDate',
        'created_at',
        'updated_at'
    ];
}
