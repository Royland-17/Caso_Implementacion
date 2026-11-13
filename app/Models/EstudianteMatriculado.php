<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EstudianteMatriculado extends Pivot
{
    protected $table = 'estudiantes_matriculados';
    public $incrementing = false; 
    protected $fillable = ['grupo_id', 'carne', 'nota'];

    protected $casts = [
        'nota' => 'float',
    ];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'carne', 'carne');
    }
}