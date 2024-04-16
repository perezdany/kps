<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    use HasFactory;

    public $timestamps = false;

      protected $fillable = [
        'libele_depense',
        'id_appart',
        'date', 
        'montant_depenses',
        
    ];
}
