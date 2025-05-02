<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student1 extends Model
{
    use HasFactory;
    protected $table = 'students';
    protected $primaryKey = 'id';

    protected $fillable = [
        'username',
        'firstname',
        'name',
        'age',
        'email',
        'password'
    ];
}
