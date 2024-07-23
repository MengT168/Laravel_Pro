<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class car extends Model
{
    use HasFactory;
    protected $table = 'car';
    protected $fillable =[
        'modelId',
        'colorId',
        'categoryId',
        'year',
        'vin',
        'mile',
        'condition',
        'status',
        'price',
        'authorId',
        'image',
        'created_at',
        'updated_at'
    ];
}
