<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Asistencia;

class Hora extends Model
{
    use HasFactory;

    protected $fillable = ['asistencia_id', 'horas_trabajadas', 'horas_extras'];

    public function asistenciaRegistro()
    {
        return $this->belongsTo(Asistencia::class);
    }
}
