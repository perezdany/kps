<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

     public $timestamps = false;

      protected $fillable = [
        'id_reservation',
        'id_client',
        'id',
        'id_mode_paie',
        'id_paiement',
        'validate',
        'date_debut',
        'date_fin',
        'jours',
        'mois',
        'montant',
        'solder',
        'date', 
        'heure'
    ];
}
