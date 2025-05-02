<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourrierDossier extends Model
{
    use HasFactory;

    protected $table = 'courrier_dossier';
    public $timestamps = false;

    protected $fillable = [
        'courrier_id',
        'dossier_id',
    ];
}
