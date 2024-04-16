<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appart extends Model
{
    use HasFactory;

    public $timestamps = false;

      protected $fillable = [
        'designation_appart',
        'id_type_appart',
        'prix',
        'nb_lit',
        'nb_douche',
        'path',
        'path_descript1',
        'path_descript2',
        'path_descript3',
        'note',
        'internet_wifi',
        'description'
    ];
}
