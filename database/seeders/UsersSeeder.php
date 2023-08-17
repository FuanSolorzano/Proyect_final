<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Burcocrata;
use App\Models\Empleado;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
        $supervisor=  User::create([
            'nombre' => 'Juan',
            'apellido' => 'Solorzano',
            'direccion' => 'Chone',
            'fecha_nacimiento' => '2002/05/18',
            'email' => 'juan@gmail.com',
            'password' => Hash::make('123456789'),
            'rol_id' => 1
        ]);
        Burcocrata::create([
            'fecha_contratacion' => '2023/05/12' , 'puesto_id' => 1, 'user_id' => 1
        ]); //
        $empleado=  User::create([
            'nombre' => 'Colorado',
            'apellido' => 'Valarezo',
            'direccion' => 'Tosagua',
            'fecha_nacimiento' => '2000/10/21',
            'email' => 'colores@gmail.com',
            'password' => Hash::make('123456789'),
            'rol_id' => 3
        ]);
        Empleado::create([
                    'fecha_contratacion' => '2023/05/12' , 'puesto_id' => 1, 'user_id' => 2
                ]); //
        $admin=   User::create([
            'nombre' => 'Sergio',
            'apellido' => 'Velasquez',
            'direccion' => 'Bahia',
            'fecha_nacimiento' => '2003/05/20',
            'email' => 'rango@gmail.com',
            'password' => Hash::make('123456789'),
            'rol_id' => 1
        ]);
        

    }
}
