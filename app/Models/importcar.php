<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class importcar extends Model
{
    use HasFactory;
    protected $table = 'importcar';
    protected $fillable =[
        'carId',
        'importDate',
        'importPrice',
        'authorId',
        'created_at',
        'updated_at'
    ];
}
