<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Empleado;
use App\Models\Burocrata;

class puesto extends Model
{
    use HasFactory;

    protected $fillable = ['puesto', 'salario'];

    public function empleados()
    {
        return $this->hasMany(Empleado::class);
        
    }

    public function burocratas()
    {
        return $this->hasMany(Burocrata::class);
    }
}
