<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\Personas;
use App\Models\Imagenes;

class AgendaController extends Controller
{
    public function getAdd(){
        $personas=new Personas;
        $imagenes=new Imagenes;
        $personas= Personas::all();
        $imagenes= Imagenes::all();
        return view('agenda.add',compact('personas','imagenes'));
    }
    public function postAdd(Request $request){

       // dd($request->all());

        $agenda= new Agenda;
        $agenda->fecha=$request->fecha;
        $agenda->hora=$request->hora;
        $agenda->idpersona=$request->idpersona;
        $agenda->idimagen=$request->idimagen;
        $agenda->save();
        return redirect()->route('agenda.add')->with('info','Agenda añadida correctamente');
    }
    public function getBuscar(){
        $personas= Personas::all();
        return view('agenda.buscar',compact('personas'));
    }
    public function postMostrar(Request $request){
        // Verifica si la variable 'id' está siendo enviada correctamente
        //dd($request->all()); // Esto te mostrará si 'id' tiene un valor, o si es null
    
        // Realiza el JOIN utilizando el nombre de las columnas correctas
        $agenda = Agenda::select(
                'imagenes.imagen', 
                'agenda.fecha', 
                'agenda.hora', 
                'personas.nombre', 
                'personas.apellidos'
            )
            ->join('imagenes', 'imagenes.idimagen', '=', 'agenda.idimagen')
            ->join('personas', 'personas.idpersona', '=', 'agenda.idpersona') // Usa 'idpersona' aquí
            ->where('agenda.idpersona', $request->idpersona)  // Verifica que 'id' esté llegando correctamente
            ->where('agenda.fecha', $request->fecha)
            ->get();
            
        // Si hay resultados, los pasa a la vista, si no, muestra un mensaje
        if($agenda->isEmpty()) {
            return back()->with('error', 'No hay registros para la fecha seleccionada.');
        }
        
        return view('agenda.mostrar', compact('agenda'));
    }
    
    
}
