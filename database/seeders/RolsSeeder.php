<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rol;

class RolsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rol::create(['nombre_del_rol' => 'Admin']);
        Rol::create(['nombre_del_rol' => 'Supervisor']);
        Rol::create(['nombre_del_rol' => 'Empleado']);
    }
}
