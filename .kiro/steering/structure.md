# Estructura del proyecto

## Estado de aprobación

**PENDIENTE:** no se define una estructura física canónica mientras ADR-001 tenga dos documentos contradictorios (Laravel aceptado y CodeIgniter 4 propuesto), `tech.md` deje el framework sin decidir y `tasks.md` describa Python/FastAPI.

## Elementos documentados

| Elemento | Evidencia disponible | Estado |
|---|---|---|
| Controladores, modelos, servicios y vistas en `app/` | Propuesta de carpetas de CodeIgniter en `design.md`, “Components and Interfaces” | PENDIENTE de selección de framework |
| `public/assets/js/` | Propuesta de frontend en `design.md`, “Components and Interfaces” | PENDIENTE de selección de framework |
| Scripts Python de seed/configuración | `tasks.md`, tareas 13.2 y 14.1 | PENDIENTE de selección de framework |
| Documentación del modelo físico | `tech.md` exige `docs/arquitectura/modelo_datos.md`; el borrador está en `.kiro/specs/.../data-model.md` | Ruta canónica añadida; motor pendiente |
| Registro de decisiones | Los documentos existentes están en `docs/adr/` | Mantener esa ubicación; no duplicar ADR en otra carpeta |

## Convenciones conocidas

- Nombres en español.
- Base de datos: `snake_case`.
- Clases: `PascalCase`.
- Rutas: `kebab-case`.
- Secretos únicamente en `.env`; `.env` no se versiona.
- Todo módulo debe trazar a una historia de `requirements.md`.

Las convenciones anteriores se toman de `tech.md`; las rutas concretas de aplicación no se declaran aprobadas hasta resolver ADR-001.

## Historial de cambios

| Fecha | Hallazgo | Cambio |
|---|---|---|
| 2026-10-09 | No existía `structure.md` y las carpetas/framework propuestos se contradicen entre diseño, tareas y steering. | Creé este documento para registrar las rutas candidatas y convenciones existentes sin aprobar una estructura ni elegir framework. |
