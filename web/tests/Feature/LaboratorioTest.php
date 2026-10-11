<?php

// Historia: H-01, H-03, H-04, H-07, H-09, H-11

namespace Tests\Feature;

use App\Models\Usuario;
use App\Services\Reportes;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class LaboratorioTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->assertSame('mysql', config('database.default'), 'S7 debe probarse sobre MySQL/MariaDB existente.');
        DB::connection()->beforeExecuting(function (string $sql) {
            if (! preg_match('/^\s*(select|show)\b/i', $sql)) {
                throw new \LogicException('Las pruebas S7 no permiten escrituras ni migraciones SQL.');
            }
        });
        RateLimiter::clear('ingreso:'.hash('sha256', '127.0.0.1'));
    }

    private function entrar(string $nombre): self
    {
        $usuario = Usuario::where('nombre_usuario', $nombre)->firstOrFail();

        return $this->actingAs($usuario)->withSession(['inicio_sesion' => now()->timestamp]);
    }

    public function test_individual_muestra_dato_real_puntaje_y_omisiones(): void
    {
        $this->entrar('est_0001')->get('/estudiante/reporte/2')->assertOk()
            ->assertSee('Simulacro de octubre')->assertSee('EST-0001')->assertSee('50.0 %')
            ->assertViewHas('resultado', fn ($r) => $r['correctas'] === 3 && $r['preguntas'] === 6
                && $r['excluidos'] === 1 && $r['temas'][0]['nombre'] === 'Ciencias' && $r['temas'][0]['sin_responder'] === 1);
    }

    public function test_individual_inexistente_devuelve_404_y_no_500(): void
    {
        $this->entrar('est_0001')->get('/estudiante/reporte/no-existe-zz')->assertNotFound()->assertSee('No encontramos');
    }

    public function test_ultimo_simulacro_se_elige_por_fecha_de_aplicacion(): void
    {
        $this->entrar('est_0001')->get('/estudiante/reporte')->assertOk()
            ->assertViewHas('seleccionado', fn ($s) => $s->simulacro_id === 2);
    }

    public function test_estudiante_sin_resultados_tiene_mensaje_y_no_tabla_vacia(): void
    {
        $this->entrar('est_0004')->get('/estudiante/reporte')->assertOk()->assertSee('No existen resultados disponibles')
            ->assertDontSee('<table', false);
    }

    public function test_no_se_accede_al_simulacro_exclusivo_de_otro_estudiante(): void
    {
        $this->entrar('est_0001')->get('/estudiante/reporte/4')->assertNotFound();
    }

    public function test_grupal_muestra_calculos_y_excluye_inactivos_y_membresias_pasadas(): void
    {
        $this->entrar('doc_0001')->get('/docente/grupos/G5A/simulacros/2')->assertOk()->assertSee('75.0 %')
            ->assertViewHas('resultado', fn ($r) => $r['participantes'] === 2 && $r['temas'][0]['nombre'] === 'Matemática'
                && $r['temas'][0]['incorrectas'] === 3 && $r['temas'][0]['respondidas'] === 4);
    }

    public function test_grupal_inexistente_devuelve_404(): void
    {
        $this->entrar('doc_0001')->get('/docente/grupos/G5A/simulacros/no-existe-zz')->assertNotFound();
    }

    public function test_grupo_inexistente_y_simulacro_ajeno_devuelven_404(): void
    {
        $this->entrar('doc_0001')->get('/docente/grupos/no-existe-zz/simulacros/2')->assertNotFound();
        $this->get('/docente/grupos/G5A/simulacros/4')->assertNotFound();
    }

    public function test_docente_no_accede_a_otro_grupo(): void
    {
        $this->entrar('doc_0001')->get('/docente/grupos/G5B/simulacros/2')->assertForbidden()->assertDontSee('EST-0003');
    }

    public function test_docente_solo_ve_sus_grupos(): void
    {
        $this->entrar('doc_0001')->get('/docente/grupos')->assertOk()->assertSee('G5A')->assertSee('G5C')->assertDontSee('G5B');
    }

    public function test_grupo_sin_datos_tiene_mensaje(): void
    {
        $this->entrar('doc_0001')->get('/docente/grupos/G5C/simulacros/2')->assertOk()->assertSee('No existen resultados disponibles')->assertDontSee('<table', false);
    }

    public function test_docente_sin_grupos_tiene_mensaje(): void
    {
        $this->entrar('doc_sin_grupos')->get('/docente/grupos')->assertOk()->assertSee('Sin grupos asignados');
    }

    public function test_direccion_solo_ve_agregados_de_quinto(): void
    {
        $respuesta = $this->entrar('dir_0001')->get('/direccion/resumen/2')->assertOk()->assertSee('50.00 %')
            ->assertViewHas('resultado', fn ($r) => $r['participantes'] === 3)
            ->assertViewHas('excluidos', 1)->assertDontSee('G4A');
        foreach (['EST-0001', 'EST-0002', 'EST-0003', 'EST-0005', 'est_0001', 'contrasena_hash'] as $dato) {
            $respuesta->assertDontSee($dato);
        }
    }

    public function test_direccion_inexistente_y_sin_datos(): void
    {
        $this->entrar('dir_0001')->get('/direccion/resumen/no-existe-zz')->assertNotFound();
        $this->get('/direccion/resumen/3')->assertOk()->assertSee('Sin resultados disponibles')->assertDontSee('<table', false);
    }

    #[DataProvider('accesosProhibidos')]
    public function test_control_de_acceso_por_rol(string $usuario, string $ruta): void
    {
        $this->entrar($usuario)->get($ruta)->assertForbidden();
    }

    public static function accesosProhibidos(): array
    {
        return [['est_0001', '/docente/grupos'], ['est_0001', '/direccion/resumen/2'],
            ['doc_0001', '/direccion/resumen/2'], ['doc_0001', '/estudiante/reporte/2'],
            ['dir_0001', '/estudiante/reporte/2'], ['dir_0001', '/docente/grupos']];
    }

    #[DataProvider('parametrosInvalidos')]
    public function test_entradas_inesperadas_no_producen_500(string $parametro): void
    {
        $this->entrar('est_0001')->get('/estudiante/reporte/'.$parametro)->assertNotFound();
    }

    public static function parametrosInvalidos(): array
    {
        return [['%27'], ['-1'], [str_repeat('a', 500)], ['1abc'], ['9999999999999999999999']];
    }

    public function test_anonimo_es_redirigido_al_ingreso(): void
    {
        $this->get('/estudiante/reporte/2')->assertRedirect('/ingresar');
    }

    public function test_sesion_caduca_a_las_ocho_horas(): void
    {
        $this->entrar('est_0001')->withSession(['inicio_sesion' => now()->subHours(8)->timestamp])
            ->get('/estudiante/reporte/2')->assertRedirect('/ingresar')->assertSessionHas('aviso');
        $this->assertGuest();
    }

    public function test_cuenta_inactiva_no_conserva_acceso(): void
    {
        $this->entrar('est_inactivo')->get('/estudiante/reporte/2')->assertRedirect('/ingresar');
        $this->assertGuest();
    }

    public function test_ingreso_real_y_salida_sin_escribir_en_bd(): void
    {
        $archivo = storage_path('app/private/demo-credentials.json');
        $clave = getenv('S7_DEMO_PASSWORD') ?: (is_file($archivo) ? json_decode(file_get_contents($archivo), true)['password'] : null);
        $this->assertNotEmpty($clave, 'Proporciona S7_DEMO_PASSWORD o ejecuta la preparación B0 una vez.');
        $this->post('/ingresar', ['usuario' => 'est_0001', 'clave' => $clave])->assertRedirect('/inicio');
        $this->assertAuthenticated();
        $this->get('/inicio')->assertRedirect('/estudiante/reporte');
        $this->post('/salir')->assertRedirect('/ingresar');
        $this->assertGuest();
    }

    public function test_credenciales_incorrectas_y_campos_ausentes_son_genericos(): void
    {
        foreach ([['usuario' => 'desconocido', 'clave' => 'incorrecta'], ['usuario' => 'est_0001', 'clave' => 'incorrecta'], []] as $datos) {
            $this->from('/ingresar')->post('/ingresar', $datos)->assertRedirect('/ingresar')
                ->assertSessionHasErrors(['acceso' => 'Usuario o contraseña incorrectos.']);
            $this->assertGuest();
        }
    }

    public function test_ingreso_limita_intentos(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->from('/ingresar')->post('/ingresar', [])->assertRedirect('/ingresar');
        }
        $this->post('/ingresar', [])->assertStatus(429);
    }

    public function test_respuestas_personales_no_se_cachean(): void
    {
        $r = $this->entrar('est_0001')->get('/estudiante/reporte/2')->assertOk();
        $this->assertStringContainsString('no-store', $r->headers->get('Cache-Control'));
        $r->assertHeader('X-Frame-Options', 'DENY');
    }

    public function test_no_hay_ruta_de_escritura_de_resultados(): void
    {
        $this->entrar('est_0001')->post('/estudiante/reporte/2')->assertStatus(405);
    }

    public function test_formularios_rechazan_peticion_sin_token_csrf(): void
    {
        // Laravel omite CSRF en testing; activar el entorno web solo para este caso.
        $this->app['env'] = 'local';
        $this->post('/ingresar', ['usuario' => 'est_0001', 'clave' => 'incorrecta'])
            ->assertStatus(419);
        $this->assertGuest();
    }

    public function test_fallo_de_datos_muestra_503_sin_sql(): void
    {
        $this->entrar('est_0001');
        $this->mock(Reportes::class)->shouldReceive('calcular')->andThrow(
            new QueryException('mysql', 'SELECT secreto', [], new \RuntimeException('dato privado'))
        );
        $this->get('/estudiante/reporte/2')->assertStatus(503)->assertSee('no está disponible temporalmente')
            ->assertDontSee('SELECT secreto')->assertDontSee('dato privado');
    }
}
