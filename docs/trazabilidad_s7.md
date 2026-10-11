# Trazabilidad del laboratorio S7

Origen: commit `698175744060ceb83dc3ecf6ce64623715ad87bf` de `develop`. Todas las URLs requieren iniciar sesión salvo `/ingresar`. Base de URL local: `http://127.0.0.1:8000`.

| Tarea | Historia | Decisión | Justificación | Verificación |
|---|---|---|---|---|
| T1 Reporte individual completo | H-04, H-03, H-01, H-11 | MANTENER | Caso prioritario de design.md y maqueta S6; incluye ruta, controlador, modelo, servicio y vista | Estudiante: `/estudiante/reporte/2` muestra Simulacro de octubre y 3/6; `/estudiante/reporte/no-existe-zz` devuelve 404 |
| T2 Reporte grupal completo | H-07, H-01, H-03, H-11 | MANTENER | Segunda consulta vertical con tablas y relaciones del DDL S6 | Docente: `/docente/grupos/G5A/simulacros/2` muestra dos estudiantes y Matemática 75.0 % de error; simulacro inexistente devuelve 404 |
| T3 Resumen institucional | H-09, H-01, H-11 | MANTENER | Tercera consulta, únicamente agregada | Dirección: `/direccion/resumen/2` muestra grupos de quinto sin EST-0001 ni otros códigos individuales |
| T4 Pruebas y entradas inesperadas | H-01, H-03, H-04, H-07, H-09, H-11 | MANTENER | Guía S7 §8.2; comprobar 200/404, cálculos y autorización con datos existentes | `php artisan test` sin RefreshDatabase, migraciones ni escrituras SQL |
| T5 Documentación y evidencias | H-04, H-07, H-11 | MANTENER | Guía S7 §12; dejar evidencia verificable y pendientes reales | Instrucciones, registro, matriz de criterios y resultados de verificación |
| Antigua 1 Crear proyecto | — | ELIMINAR · ya realizada | Laravel ya existe en web/ en develop; guía §5.2 | Conservar esqueleto existente |
| Antigua 13.1 Crear esquema | — | ELIMINAR · ya realizada | DDL MySQL ya definido en S6; tech.md prohíbe migraciones y seeders | La aplicación y pruebas solo leen la BD preparada en B0 |
| Antigua 4.2 Implementar MCP | H-02 | ELIMINAR del alcance S7 | Frontera de tech.md y guía §5.2; ADR-004 documenta discrepancia | Sin cliente/servidor MCP añadido |
| Antigua 8 y 10.5 Gemini/chat | H-10 | ELIMINAR del alcance S7 | Unidad 3 según tech.md; no forma parte de las consultas S7 | Sin claves ni llamadas externas |
| Antigua 5 Todos los cálculos | H-03, H-05 | DIVIDIR | Tarea horizontal; cálculos de H-03 se integran en T1/T2, comparación H-05 se pospone | Fórmulas verificadas por consulta |
| Antigua 10 API FastAPI | H-01, H-04, H-07, H-09 | DIVIDIR y adaptar | Contradice Laravel en web/; ADR-004 adopta vistas Blade | Rutas verticales T1–T3 |
| Antigua 12 Todo el frontend | H-04, H-07, H-09 | DIVIDIR | Tarea horizontal; vistas pasan a cada consulta vertical | Pantallas completas T1–T3 |

La preparación de una base de demostración vacía se documenta como recuperación de la precondición B0 ausente en los archivos recibidos, no como tarea funcional ni como migración sobre la base del equipo.
