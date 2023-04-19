<?php

namespace App\Observers;

use App\Models\Flight;

class FlightObserver
{
    public function creating(Flight $flight){ //se ejecuta antes de que se cree un nuevo registro en la tabla del mismo modelo.
        $flight->number = '123';
    }

    public function created(Flight $flight){ //se ejecuta luego de que se crea e

    }

    public function retrieved(Flight $flight){ //se ejecuta luego de recuperar un modelo.
        $flight->prueba = 'prueba';
    }

    public function updating(Flight $flight){ //se ejecuta antes de realizarse una actualización.

    }

    public function updated(Flight $flight){ //se ejecuta después de que se actualiza el modelo.

    }

    public function saving(Flight $flight){

    }
    public function saved(Flight $flight){
        
    } 
}
