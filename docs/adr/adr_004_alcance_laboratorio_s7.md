# ADR 004 Implementación aislada del laboratorio S7

Fecha: 11 de octubre de 2026. Estado: adoptado para la rama `laboratorio-s7`, por autorización del solicitante. No constituye aprobación de la docente ni una fusión en `develop`.

## Decisión

Continuar el esqueleto Laravel 12 existente en `web/`, con PHP 8.2 o superior, MySQL/MariaDB y VS Code. El código Python y el esquema SQLite se conservan como antecedentes, sin ejecutarlos en S7. Esta decisión sustituye las alternativas contradictorias de los ADR 001 únicamente dentro del alcance de esta rama.

Se implementan tres consultas verticales: reporte individual (H-04), reporte grupal (H-07) y resumen institucional agregado (H-09), con autenticación (H-01), cálculo por tema (H-03) y datos ficticios (H-11). Los alias H-xx corresponden a los requisitos numerados preexistentes, no a historias nuevas.

## Adaptación explícita del diseño

La guía S7 exige Eloquent sobre tablas existentes y aplaza MCP y Gemini. Los requisitos R2.2 y R11.2 y el diseño general exigen MCP. Para esta entrega se usa Eloquent con una cuenta SQL de solo lectura; no se afirma cumplir el transporte MCP ni los criterios conversacionales. El servicio de reportes concentra las lecturas y cálculos para permitir reemplazar la fuente en Unidad 3. La aceptación académica de esta adaptación corresponde al equipo/docente.

Las sesiones son de Laravel, almacenadas en archivos, con vencimiento absoluto a las ocho horas, cookies HTTP-only y protección CSRF. No se implementan JWT ni almacenamiento de tokens en JavaScript. Sesiones y caché no crean tablas. La auditoría escribe metadatos mínimos en el log local, nunca resultados, contraseñas ni SQL.

## Datos e independencia

El repositorio entregado contiene DDL, pero no datos de demostración. Se añade una preparación B0 separada, explícita y de una sola ejecución: importa una copia del DDL MySQL en una base nueva llamada `asistente_cni_s7` y carga un conjunto ficticio determinista. Se niega a operar si esa base ya existe. No toca `asistente_cni`, no usa migraciones ni seeders de Laravel y nunca se ejecuta desde la aplicación o las pruebas.

Los comandos Composer heredados que ejecutaban migraciones se sustituyen por instalación y arranque sin mutaciones SQL. Los archivos de migración del esqueleto se conservan como antecedentes y no se ejecutan.

## Semántica de los reportes

- Individual: último simulacro con respuestas del usuario, por fecha de aplicación e ID descendentes. El total incluye todas las preguntas; una omisión no suma aciertos. Se distinguen errores y omisiones. Los temas sin preguntas se excluyen y se cuenta su cantidad.
- Grupal: solo grupos activos asignados al docente, estudiantes activos con pertenencia vigente y simulacros asociados al grupo. Se incluyen estudiantes con al menos una respuesta válida. Porcentaje de error = respuestas incorrectas / respuestas válidas del tema × 100. Las omisiones se muestran separadas y no se convierten silenciosamente en errores. Un tema sin respuestas válidas se muestra sin porcentaje.
- Dirección: solo grupos activos de nivel `5.º secundaria`, agregados sin códigos individuales; se informa cuántos grupos carecen de resultados. Porcentaje agregado con dos decimales.
- Los datos inconsistentes se omiten y cuentan. No hay persistencia de reportes calculados.
- Recurso inexistente o parámetro inválido: 404. Rol o grupo no autorizado: 403. Base no disponible: 503 con mensaje genérico. No hay endpoints de escritura de resultados.

## Fuera de esta sesión

Comparación entre simulacros, orientación independiente, detalle docente individual, conversación, servidor MCP y llamadas a Gemini permanecen para sesiones posteriores. No se necesitan claves de API para S7. La revisión cruzada E3 y las lecturas atribuidas a integrantes requieren participación humana y se entregan como pendientes explícitos.
