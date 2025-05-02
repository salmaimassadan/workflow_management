<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;
    protected $fillable = ['courrier_id', 'content', 'created_by'];
    public function courrier()
{
    return $this->belongsTo(Courrier::class);
}
public function creator()
{
    return $this->belongsTo(Employee::class, 'created_by');
    
}

}

