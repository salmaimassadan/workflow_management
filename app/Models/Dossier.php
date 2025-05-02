<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dossier extends Model
{
    use HasFactory;

    
        protected $fillable = [
            'reference',
            'title',
            'description',
            'courrier_id', 
            'created_by',  
        ];
    
        public function courriers()
        {
            return $this->belongsToMany(Courrier::class, 'courrier_dossier');
        }
    
        public function courrier()
        {
            return $this->belongsTo(Courrier::class, 'courrier_id');
        }
        public function creator()
    {
        return $this->belongsTo(Employee::class, 'created_by'); // Adjust the User model if necessary
    }
} 