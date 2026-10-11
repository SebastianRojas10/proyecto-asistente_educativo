# ADR-003: Datos simulados y acceso institucional agregado

## Estado

Aceptado, conforme a las reglas de producto y los requisitos.

## Contexto

Los usuarios reales son estudiantes menores de edad. `product.md` ordena usar únicamente datos simulados durante el desarrollo y restringe a Dirección a información agregada. `requirements.md` formaliza estas restricciones en R9.2 y R11.1–R11.5.

## Decisión

- Desarrollo, pruebas y demostraciones usan exclusivamente datos simulados.
- Dirección solo recibe resultados agregados; no se muestran identificadores ni detalles individuales de estudiantes.
- El Asistente presenta a los estudiantes mediante su identificador anonimizado.
- Las consultas de resultados mantienen la frontera de solo lectura documentada en ADR-002.

## Alternativas consideradas

| Alternativa | Decisión | Justificación |
|---|---|---|
| Usar datos personales reales de estudiantes durante desarrollo o demostración | Descartada | Contradice la regla no negociable de `product.md` y R11.1. |
| Permitir a Dirección consultar resultados individuales | Descartada | Contradice la regla no negociable de `product.md` y R9.2/R9.3. |
| Usar datos simulados y restringir Dirección a agregados | Seleccionada | Es la política definida explícitamente en `product.md` y los criterios de aceptación citados. |

## Consecuencias y pendientes

- Los ejemplos, semillas y pruebas deben permanecer simulados; no se deben introducir datos personales reales.
- Campos exactos de agregación y retención de registros de auditoría: **PENDIENTE** según el diseño de logging.
- Este ADR no define mecanismos legales adicionales ni sustituye revisión institucional.

## Historial de cambios

| Fecha | Hallazgo | Cambio |
|---|---|---|
| 2026-10-09 | No había ADR que registrara estas reglas no negociables de datos y acceso por rol. | Registré la decisión y las alternativas descartadas con justificación referida únicamente a producto y requisitos. |
