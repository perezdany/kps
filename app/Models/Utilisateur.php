<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Utilisateur extends Authenticatable
{
    use HasFactory;

     public $timestamps = false;

      protected $fillable = [
        'nom_prenoms_users',
        'email_users',
        'tel_users',
        'password',
        'login',
        'id_departement',
        'libele_poste'
        
    ];
}
