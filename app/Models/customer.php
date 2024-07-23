<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    use HasFactory;
    protected $table = 'customer';
    protected $fillable =[
        'name',
        'gender',
        'contact_number',
        'address',
        'idCard',
        'authorId',
        'created_at',
        'updated_at'
    ];
}
