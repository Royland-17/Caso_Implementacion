<?php

namespace Tests\Feature;

use App\Models\Curso;
use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\Grupo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GrupoTest extends TestCase
{
    use RefreshDatabase;

    public function test_grupo_contiene_informacion_completa_asociada()
    {
        $curso = Curso::create([
            'sigla' => 'IF1300',
            'nombreCurso' => 'Ingeniería de Software I',
            'creditos' => 4
        ]);

        $docente1 = Docente::create([
            'codEmpleado' => 101,
            'nombreEmpleado' => 'Carlos',
            'apellidosEmpleado' => 'Mora'
        ]);

        $docente2 = Docente::create([
            'codEmpleado' => 102,
            'nombreEmpleado' => 'Ana',
            'apellidosEmpleado' => 'Solís'
        ]);

        $grupo = Grupo::create([
            'numeroCiclo' => 1,
            'ano' => 2026,
            'numeroGrupo' => 1,
            'abierto' => true,
            'sigla' => 'IF1300'
        ]);

        $grupo->docentes()->attach([$docente1->codEmpleado, $docente2->codEmpleado]);

        for ($i = 1; $i <= 15; $i++) {
            $estudiante = Estudiante::create([
                'carne' => 'B' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'nombre' => 'Estudiante ' . $i,
                'apellidos' => 'Apellido ' . $i,
                'consejero_id' => $docente1->codEmpleado
            ]);

            $grupo->estudiantes()->attach($estudiante->carne, ['nota' => 90.0]);
        }

        $grupo->load('curso', 'docentes', 'estudiantes.consejero');

        $this->assertEquals('IF1300', $grupo->sigla);
        $this->assertEquals('Ingeniería de Software I', $grupo->curso->nombreCurso);
        $this->assertCount(2, $grupo->docentes);
        $this->assertCount(15, $grupo->estudiantes);

        $primerEstudiante = $grupo->estudiantes->first();
        $this->assertEquals(90.0, $primerEstudiante->pivot->nota);
        $this->assertNotNull($primerEstudiante->consejero);
        $this->assertEquals(101, $primerEstudiante->consejero->codEmpleado);
    }
}