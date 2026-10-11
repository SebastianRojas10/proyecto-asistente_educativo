# Modelo de datos

## Estado

**PENDIENTE:** no hay un modelo físico aprobado. `tech.md` fija MySQL/MariaDB; `requirements.md` y `tasks.md` nombran SQLite. También existen dos esquemas físicos distintos: el DDL MySQL en `.kiro/specs/asistente-retroalimentacion-simulacros/schema.sql` y el DDL SQLite en `data/schema.sql`.

## Borradores existentes

- El modelo lógico de diez entidades, trazabilidad y protección de datos está en [data-model.md](../../.kiro/specs/asistente-retroalimentacion-simulacros/data-model.md).
- El esquema MariaDB/MySQL está en [schema.sql](../../.kiro/specs/asistente-retroalimentacion-simulacros/schema.sql).
- El esquema SQLite está en [schema.sql](../../data/schema.sql).

No ejecutar ni modificar ninguno de los esquemas como fuente canónica hasta que el equipo resuelva ADR-001 y apruebe el motor. El acceso del Asistente a resultados debe pasar por el servidor MCP de solo lectura, conforme a `product.md` y `requirements.md`.

## Pendientes del equipo

- Elegir y documentar el motor de base de datos.
- Resolver cuál esquema queda como fuente canónica y reconciliar tablas y restricciones.
- Confirmar el mecanismo y momento de integración con el servidor MCP.

## Historial de cambios

| Fecha | Hallazgo | Cambio |
|---|---|---|
| 2026-10-09 | `tech.md` exige esta ruta documental, que no existía; los requisitos/tareas y steering difieren en motor, y hay esquemas físicos distintos. | Creé el índice canónico como registro `PENDIENTE` y referencié los artefactos existentes sin escoger ni alterar un DDL. |
