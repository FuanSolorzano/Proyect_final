<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empleados = Empleado::with('user', 'puesto')->get();

    return response()->json(['empleados' => $empleados], 200);
    }

    public function getAllRoles()
    {
        $roles = Rol::all();
    
        return response()->json(['roles' => $roles], 200);
    }


    
    public function getEmpleadoRole()
    {
        $empleadoRole = Rol::where('nombre_del_rol', 'Empleado')->first();

        return response()->json(['rol' => $empleadoRole], 200);
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
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'rol_id' => 'required|exists:rols,id', // Ajusta esto según tu lógica
            'fecha_contratacion' => 'required|date',
            'puesto_id' => 'required|exists:puestos,id', // Ajusta esto según tu lógica
        ], [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'apellido.required' => 'El campo apellido es obligatorio.',
            'direccion.required' => 'El campo dirección es obligatorio.',
            'fecha_nacimiento.required' => 'El campo fecha de nacimiento es obligatorio.',
            'fecha_nacimiento.date' => 'El campo fecha de nacimiento debe ser una fecha válida.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'El campo correo electrónico debe ser una dirección de correo válida.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.min' => 'La contraseña debe tener al menos :min caracteres.',
            'rol_id.required' => 'El campo ID de rol es obligatorio.',
            'rol_id.exists' => 'El ID de rol proporcionado no es válido.',
            'fecha_contratacion.required' => 'El campo fecha de contratación es obligatorio.',
            'fecha_contratacion.date' => 'El campo fecha de contratación debe ser una fecha válida.',
            'puesto_id.required' => 'El campo ID de puesto es obligatorio.',
            'puesto_id.exists' => 'El ID de puesto proporcionado no es válido.',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
    
        // Crea el usuario
        $user = User::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'direccion' => $request->direccion,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol_id' => $request->rol_id, // Ajusta esto según tu lógica
        ]);
    
        // Crea el empleado
        Empleado::create([
            'fecha_contratacion' => $request->fecha_contratacion,
            'puesto_id' => $request->puesto_id,
            'user_id' => $user->id,
        ]);
    
        return response()->json(['message' => 'Empleado registrado correctamente'], 201);
    }

    public function update(Request $request, $id)
    {
        $empleado = Empleado::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'email' => 'required|email|unique:users,email,' . $empleado->user->id,
            'puesto_id' => 'required|exists:puestos,id',
            'fecha_contratacion' => 'required|date',
            'estado' => 'required',
        ], [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'apellido.required' => 'El campo apellido es obligatorio.',
            'direccion.required' => 'El campo dirección es obligatorio.',
            'fecha_nacimiento.required' => 'El campo fecha de nacimiento es obligatorio.',
            'fecha_nacimiento.date' => 'El campo fecha de nacimiento debe ser una fecha válida.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'El campo correo electrónico debe ser una dirección de correo válida.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'puesto_id.required' => 'El campo ID de puesto es obligatorio.',
            'puesto_id.exists' => 'El ID de puesto proporcionado no es válido.',
            'fecha_contratacion.required' => 'El campo fecha de contratación es obligatorio.',
            'fecha_contratacion.date' => 'El campo fecha de contratación debe ser una fecha válida.',
            'estado.required' => 'El campo de estado es necesario'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $empleado->update([
            'fecha_contratacion' => $request->fecha_contratacion,
            'puesto_id' => $request->puesto_id,
            'estado' => $request->estado,
        ]);

        $empleado->user->update([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'direccion' => $request->direccion,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'email' => $request->email,
            'estado' => $request->estado,
        ]);

        return response()->json(['message' => 'Empleado actualizado correctamente'], 200);
    }






    public function buscarEmpleados(Request $request)
    {
        $jsonData = $request->json()->all();

        if (isset($jsonData['search'])) {
            $searchQuery = $jsonData['search'];

            $empleados = Empleado::where(function ($query) use ($searchQuery) {
                $query->whereHas('user', function ($query) use ($searchQuery) {
                    $query->where('nombre', 'like', "%$searchQuery%")
                        ->orWhere('apellido', 'like', "%$searchQuery%");
                })
                ->orWhereHas('puesto', function ($query) use ($searchQuery) {
                    $query->where('puesto', 'like', "%$searchQuery%");
                });
            })
            ->with(['user', 'puesto',]) // Carga las relaciones 
            ->get();

            if ($empleados->isEmpty()) {
                return response()->json(['message' => 'No se encontraron empleados.'], 404);
            }

            return response()->json(['empleados' => $empleados], 200);
        } else {
            return response()->json(['message' => 'Por favor, proporciona un valor de búsqueda válido en el JSON.'], 400);
        }
    }


        public function softDelete($id)
    {
        $empleado = Empleado::find($id);
        if (!$empleado) {
            return response()->json(['message' => 'Empleado no encontrado'], 404);
        }

        $empleado->update(['estado' => false]);

        return response()->json(['message' => 'Empleado eliminado lógicamente'], 200);
    }

    
    public function getUserInfo(Request $request)
    {
        $user = $request->user(); // Obtiene el usuario autenticado
        
        // Si deseas excluir el campo de contraseña de la respuesta
        $user->makeHidden(['password']);
        
        return response()->json(['user' => $user], 200);
    }
    /**
     * Display the specified resource.
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Empleado $empleado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updat(Request $request, Empleado $empleado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empleado $empleado)
    {
        //
    }
}
