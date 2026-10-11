# ADR-002: Acceso a resultados exclusivamente mediante MCP

## Estado

Aceptado respecto a la frontera de acceso. **PENDIENTE** respecto al calendario y despliegue de la integración.

## Contexto

`product.md` ordena reutilizar el servidor MCP en modo exclusivo de solo lectura y lo ubica en la semana 4. `requirements.md` también define el MCP como único punto autorizado para consultar resultados y prohíbe conexión directa desde el Asistente. El encargo de auditoría lo identifica como Unidad 1, mientras `tech.md` limita su implementación hasta Unidad 3. La equivalencia entre unidad y semana y el calendario de integración quedan **PENDIENTE**. `design.md` previo y los documentos ADR-001, en cambio, muestran o describen acceso directo a la base de datos.

## Decisión

El Asistente consulta resultados únicamente a través del servidor MCP de solo lectura. No establece conexión SQL directa con el almacén de resultados. El MCP es un contenedor obligatorio de la arquitectura lógica.

## Alternativas consideradas

| Alternativa | Decisión | Justificación |
|---|---|---|
| Conexión directa del Asistente a la base de resultados | Descartada | Contradice la regla no negociable de `product.md` y los criterios R2.2 y R11.2 de `requirements.md`. |
| Servidor MCP como frontera exclusiva, con operaciones de lectura | Seleccionada | Es la arquitectura exigida por `product.md` y `requirements.md`; limita el acceso del Asistente a consultas mediante el servidor existente. |

## Consecuencias y pendientes

- El cliente, las consultas disponibles y el manejo de errores deben documentarse en `design.md`.
- Protocolo, transporte, endpoint y esquema MCP: **PENDIENTE**.
- `tech.md` limita la implementación de MCP hasta la Unidad 3, mientras producto lo sitúa en semana 4 y el encargo lo llama Unidad 1: relación y calendario exactos **PENDIENTE** del equipo.
- El motor detrás del MCP sigue **PENDIENTE** por contradicción SQLite/MySQL.

## Historial de cambios

| Fecha | Hallazgo | Cambio |
|---|---|---|
| 2026-10-09 | El MCP obligatorio no aparecía como contenedor en el diseño, que conectaba directamente a MySQL. | Registré la frontera de solo lectura como decisión obligatoria y dejé transporte, motor y calendario sin resolver. |
