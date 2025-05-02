<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'courrier_id',
        'title',
        'content',
        'type',
        'user_id',
    ];

    public function courrier()
    {
        return $this->belongsTo(Courrier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}