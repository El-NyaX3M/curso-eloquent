<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
    //protected $table = "list_destinations";       Cambia la tabla que administrará este modelo.

    //protected $primaryKey = "identificador";      Cambia la llave primaria.

    //protected $incrementing = false;              Anula el incremento de la llave primaria.

    //protected $keyType = "string";                Cambia el tipo de dato de la llave primaria.

    //public $timeStamps = false;                   Anula el registro de estos campos en la tabla.

    //protected $dateFormat = "U";                  Cambia el formato de los timeStamps.

    //const CREATED_AT = "creation_date";           Cambia el campo que administra 'created_at'.
    //const UPDATED_AT = "updated_date";            Cambia el campo que administra 'updated_at'.

    //protected $connection = "sqlite";             Cambia el tipo de conexión del modelo.

    /*protected $attributes = [                     Define los valores predeterminados al crear
        'name' => 'La Paz'                          una nueva instancia del objeto.
    ];*/
}
