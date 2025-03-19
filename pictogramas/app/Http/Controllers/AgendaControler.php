<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Persona;
use App\Models\Pictogram;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function create()
    {
        $personas = Persona::all();
        $pictograms = Pictogram::all();
        return view('agenda.create', compact('personas', 'pictograms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fecha' => 'required|date',
            'hora' => 'required',
            'persona_id' => 'required|exists:personas,id',
            'pictogram_id' => 'required|exists:pictograms,id',
        ]);

        $agenda = new Agenda();
        $agenda->fecha = $request->fecha;
        $agenda->hora = $request->hora;
        $agenda->persona_id = $request->persona_id;
        $agenda->pictogram_id = $request->pictogram_id;
        $agenda->save();

        return redirect()->route('agenda.create')
            ->with('success', 'Entrada creada correctamente');
    }
}
