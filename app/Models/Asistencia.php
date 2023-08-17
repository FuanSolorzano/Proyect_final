<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Empleado;
use App\Models\Hora;

class Asistencia extends Model
{
    use HasFactory;

    protected $fillable = ['empleado_id', 'hora_entrada', 'hora_salida'];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function horasTrabajadas()
    {
        return $this->hasMany(Hora::class);
    }

}
