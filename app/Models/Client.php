<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable
{
    use HasFactory;

    public $timestamps = false;

      protected $fillable = [
        'nom_prenoms',
        'email',
        'tel',
        'adress_geo',
        'password',
        'accepted_terms',
        'confirmation_token',
        'count_login',
        'member_since'
    ];
}
