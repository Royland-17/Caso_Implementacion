<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $table = 'grupos';
    protected $fillable = ['numeroCiclo', 'ano', 'numeroGrupo', 'abierto', 'sigla'];

    protected $casts = [
        'abierto' => 'boolean',
    ];

    public function asignarDocente($codEmpleado)
    {
        if ($this->docentes()->count() >= 2) {
            throw new \DomainException('Un grupo no puede tener más de dos docentes.');
        }
        
        $this->docentes()->attach($codEmpleado);
    }

    public function puedeAbrirse()
    {
        $totalEstudiantes = $this->estudiantes()->count();
        $totalDocentes = $this->docentes()->count();

        return $totalDocentes >= 1 && $totalEstudiantes >= 15;
    }

    public function abrir()
    {
        if (!$this->puedeAbrirse()) {
            throw new \DomainException('El grupo no cumple con los requisitos para ser abierto.');
        }

        $this->update(['abierto' => true]);
    }

    public function registrarNota($estudiante, float $nota)
    {
        if ($nota < 0 || $nota > 10) {
            throw new \InvalidArgumentException('La nota debe estar entre 0 y 10.');
        }

        $this->estudiantes()->updateExistingPivot($estudiante->carne, ['nota' => $nota]);
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'sigla', 'sigla');
    }

    public function docentes()
    {
        return $this->belongsToMany(Docente::class, 'docente_grupo', 'grupo_id', 'codEmpleado');
    }

    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class, 'estudiantes_matriculados', 'grupo_id', 'carne')
                    ->using(EstudianteMatriculado::class)
                    ->withPivot('nota');
    }
}