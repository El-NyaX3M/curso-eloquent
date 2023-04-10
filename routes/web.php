<?php

use App\Models\Flight;
use App\Models\Destination;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/prueba', function(){
    $flights = Flight::all(); //obtiene todos los registros de la tabla Flight.
    $flights = Flight::where('active', 1)
                    ->where('legs', '>', 2)
                    ->orderBy('name'/*, 'desc' */) //ordena los registros de acuerdo a la propiedad name.           
                    ->take(10) //trae la cantidad de registros indicada.
                    ->get(); //obtiene todos los registros que cumplan con los filtros where.
                             //el método all() se sustituye por get().

    foreach($flights as $flight){
        echo $flight -> name . '<br>'; //muestra la propiedad name de cada registro obtenido.
        $flight->number = 'a'.$flight->number; //modifica la propiedad number de cada registro obtenido.
        $flight->save(); //guarda los cambios del registro.
    } 

    Flight::chunk(20, function($flights){
        foreach($flights as $flight){}
    }); //ejecuta varias consultas con la cantidad de registros indicada en cada una. (Muy útil para procesar enormes cantidades de datos)
    $numbers = range(1, 100); //crea un arreglo con los números del 1 al 100.
    
    Flight::where('departed', true)->chunkById(20, function($flights){
        foreach($flights as $flight){
            $flight->departed = false;
        }
    }, 'id'); //se recomienda cuando se modifica una propiedad la cual también es filtro (where).

    foreach(Flight::cursor() as $flight){
        $flight->active = true;
        $flight->save();
    } //hace una sola consulta usando generadores php, donde se guarda modelo por modelo.


    $destinations = Destination::addSelect([
        'last_flight' => Flight::select('number') //define un nuevo atributo last_flight usando una consulta cruzada con Flights
                                    ->whereColumn('destination_id', 'destinations.id') //el filtro checa la columna de Flights y que coincida con el campo id de la tabla Destinations.
                                    ->orderBy('arrived_at', 'desc')
                                    ->limit(1)
    ])->get();
});

Route::get('/prueba2', function(){
    $flight = Flight::find(6); //trae un registro individual a través del id.
    $flight = Flight::firstWhere('departed', true); //obtiene el primer registro que cumpla con el filtro.
    $flight = Flight::findOr(6, function(){
        return 'No existe el vuelo.';
    }); //obtiene un registro que cumpla con el id indicado, en caso de no encontrarlo se ejecuta la función.
    $flight = Flight::where('legs', '>', 5)->firstOr(function(){
        return "No se encontró el vuelo.";
    }); //obtiene el primer registro que cumpla con el filtro, en caso de no encontrarlo se ejecuta la función.
    //También es posible agregar una excepción con firstOrFail() y findOrFail(), donde si no existe entonces falla.

    $destination = Destination::firstOrCreate([
        'name' => 'lmao'
    ]);//encuentra un registro que cumpla con la propiedad y valor indicada, en caso contrario crea un nuevo registro.

    $flight = Flight::firstOrCreate([
        'name' => 'Nombre' //este es el filtro.
    ], [
        //aquí van las demás propiedades que servirán para crear un nuevo registro en caso de no encontrar uno que cumpla con el filtro. 
    ]);

    $flight = Flight::firstOrNew([
        'name' => 'Nombre' //este es el filtro.
    ], [
        //aquí van las demás propiedades que servirán para crear una nueva instancia del modelo si no se encuentra un registro que cumpla con el filtro.
    ]);
    $flight->save(); //a diferencia del firstOrCreate(), el firstOrNew() crea una instancia la cual puede modificarse antes de subirse a la base de datos.

    $flight = Flight::where('departed', true)->count(); //cuenta la cantidad de registros que cumplen con el filtro.
    $flight = Flight::where('departed', true)->sum('legs'); //verifica los registros que cumplan con el filtro y con ellos hace una sumatoria con los valores de la propiedad indicada.
    $flight = Flight::where('departed', true)->max('legs'); //verifica los registros que cumplan con el filtro y con ellos obtiene el valor más alto de acuerdo a la propiedad indicada.
    $flight = Flight::where('departed', true)->avg('legs'); //verifica los registros que cumplan con el filtro y con ellos obtiene el promedio de los valores de la propiedad indicada.
});
