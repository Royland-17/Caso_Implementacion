<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    protected $table = 'estudiantes';
    protected $primaryKey = 'carne';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['carne', 'nombre', 'apellidos', 'consejero_id'];

    public function consejero()
    {
        return $this->belongsTo(Docente::class, 'consejero_id', 'codEmpleado');
    }

    public function grupos()
    {
        return $this->belongsToMany(Grupo::class, 'estudiante_matriculado', 'carne', 'grupo_id')
                    ->using(EstudianteMatriculado::class)
                    ->withPivot('nota');
    }
}