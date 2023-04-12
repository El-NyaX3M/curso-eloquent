<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Support\Facades\Storage;

class Flight extends Model
{
    use HasFactory;
    use SoftDeletes; //permite borrar registros y queden en una papelera.
    use Prunable; //programa 

    protected $fillable = [ // se especifícan las propiedades que pueden ser afectadas por la asignación masiva.
        'name',
        'number',
        'legs',
        'active',
        'departed',
        'arrived_at',
        'destination_id'
    ];
    // la asignación masiva se refiere a cuando estos son parte de algún método que puede crear varios objetos repetidamente.

    protected $guarded = [ // se especifican las propiedades que no pueden ser afectados por asignación masiva.
        'is_admin',
    ];

    public function prunable(){
        return static::where('departed', true);
    }

    public function pruning(){
        Storage::delete($this->image_url); //elimina los recursos.
    }//se ejecuta antes que prunable
}
