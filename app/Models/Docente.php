<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;

    protected $table = 'docentes';
    protected $primaryKey = 'codEmpleado';
    protected $keyType = 'int';
    public $incrementing = false;

    protected $fillable = ['codEmpleado', 'nombreEmpleado', 'apellidosEmpleado'];

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class, 'consejero_id', 'codEmpleado');
    }

    public function grupos()
    {
        return $this->belongsToMany(Grupo::class, 'docente_grupo', 'codEmpleado', 'grupo_id');
    }
}