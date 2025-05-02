<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'courrier_id',
        'service_id',
        'user_id',
        'commentaire',
        'read_status',
        'deadline',
        'created_by',
    ];
    protected $casts = [
        'deadline' => 'datetime',  
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'user_id');
    }

    public function courrier()
    {
        return $this->belongsTo(Courrier::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function creator() 
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }
}