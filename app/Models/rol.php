<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class rol extends Model
{
    use HasFactory;
    protected $fillable = ['nombre_del_rol'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
