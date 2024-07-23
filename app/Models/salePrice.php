<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salePrice extends Model
{
    use HasFactory;
    protected $table = 'set_sale_price';
    protected $fillable =[
        'carId',
        'setSalePrice',
        'authorId',
        'effectiveDate',
        'created_at',
        'updated_at'
    ];
}
