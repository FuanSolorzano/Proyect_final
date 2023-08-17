<?php

namespace App\Http\Controllers;

use App\Models\puesto;
use Illuminate\Http\Request;

class PuestoController extends Controller
{
    public function obtenerPuestos()
    {
        $puestos = Puesto::all();
        return response()->json(['puestos' => $puestos], 200);
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
    public function show(puesto $puesto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(puesto $puesto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, puesto $puesto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(puesto $puesto)
    {
        //
    }
}
