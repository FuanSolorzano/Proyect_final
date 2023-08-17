<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Hora;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class AsistenciaController extends Controller
{
    public function registrarAsistencia(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'empleado_id' => 'required|exists:empleados,id',
            'hora_entrada' => 'required|date_format:H:i',
            'hora_salida' => 'required|date_format:H:i',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
    
        $empleadoId = $request->input('empleado_id');
        $horaEntrada = $request->input('hora_entrada');
        $horaSalida = $request->input('hora_salida');
    
        // Verifica si el empleado existe
        $empleado = Empleado::find($empleadoId);
        if (!$empleado) {
            return response()->json(['message' => 'El empleado no existe'], 404);
        }
    
        // Calcula las horas trabajadas y extras
        $horasTrabajadas = Carbon::parse($horaEntrada)->diffInHours(Carbon::parse($horaSalida));
        $horasExtras = max($horasTrabajadas - 8, 0);
    
        // Registra la asistencia
        $asistencia = Asistencia::create([
            'empleado_id' => $empleadoId,
            'hora_entrada' => $horaEntrada,
            'hora_salida' => $horaSalida,
        ]);
    
        // Registra las horas trabajadas
        Hora::create([
            'asistencia_id' => $asistencia->id,
            'horas_trabajadas' => $horasTrabajadas,
            'horas_extras' => $horasExtras,
        ]);
    
        // Prepara la respuesta con los detalles de asistencia
        $response = [
            'message' => 'Asistencia registrada correctamente',
            'horas_trabajadas' => $horasTrabajadas,
            'horas_extras' => $horasExtras,
        ];
    
        return response()->json($response, 201);
    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Asistencia $asistencia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asistencia $asistencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asistencia $asistencia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asistencia $asistencia)
    {
        //
    }
}
