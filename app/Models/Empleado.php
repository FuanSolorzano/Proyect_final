<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Puesto;
use App\Models\User;
use App\Models\Asistencia;

class Empleado extends Model
{
    use HasFactory;

    protected $fillable = ['fecha_contratacion', 'puesto_id', 'user_id'];

    public function puesto()
    {
        return $this->belongsTo(Puesto::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asistenciaRegistros()
    {
        return $this->hasMany(Asistencia::class);
    }
}
