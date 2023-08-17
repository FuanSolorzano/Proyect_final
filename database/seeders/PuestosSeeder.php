<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Puesto;

class PuestosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Puesto::create(['Puesto' => 'Back_end', 'Salario' => 50000]);
        Puesto::create(['Puesto' => 'Front_end', 'Salario' => 25000]);
    }
}
