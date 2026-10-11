# Plan trazable S7

Rama laboratorio-s7. Decisiones y alcance: docs/adr/adr_004_alcance_laboratorio_s7.md. Poda argumentada: docs/trazabilidad_s7.md. Plan anterior conservado en docs/antecedentes/tasks_antes_s7.md.

- [ ] T1 [MANTENER] [H-04, H-03, H-01, H-11] Reporte individual vertical con ingreso: ruta, controlador, modelos de tablas existentes, servicio, vista Blade. Verificar /estudiante/reporte/2 con est_0001: 200, Simulacro de octubre, 3/6; /estudiante/reporte/no-existe-zz: 404.
- [ ] T2 [MANTENER] [H-07, H-01, H-03, H-11] Reporte grupal vertical: grupos autorizados, simulacro, cálculo y vista. Verificar /docente/grupos/G5A/simulacros/2 con doc_0001: 200, dos estudiantes; simulacro inexistente: 404; grupo ajeno: 403. Depende de T1 para autenticación y relaciones comunes.
- [ ] T3 [MANTENER] [H-09, H-01, H-11] Resumen institucional vertical agregado. Verificar /direccion/resumen/2 con dir_0001: 200, sin códigos individuales. Depende de T2 para cálculo agregado.
- [ ] T4 [MANTENER] [H-01, H-03, H-04, H-07, H-09, H-11] Pruebas sobre BD existente de solo lectura; entradas inesperadas, autorización y fórmulas. Depende de T1–T3.
- [ ] T5 [MANTENER] [H-04, H-07, H-11] Evidencias técnicas, guía de ejecución y registro honesto. Depende de T4.

## Poda del plan anterior

- [ELIMINAR · ya realizada] Antigua 1: esqueleto existente en web/.
- [ELIMINAR · ya realizada] Antigua 13.1: DDL S6 existente; no crear migraciones.
- [ELIMINAR · contradice tech.md en S7] Antigua 4.2: integración MCP reservada según ADR-004.
- [ELIMINAR · contradice tech.md en S7] Antigua 8 y 10.5: Gemini y chat reservados para Unidad 3.
- [DIVIDIR] Antigua 5: integrar cálculos necesarios en T1–T3; H-05 queda fuera de S7.
- [DIVIDIR] Antigua 10: sustituir API FastAPI por las consultas Laravel T1–T3.
- [DIVIDIR] Antigua 12: construir cada vista junto a su ruta/modelo/controlador.

## Cierre humano pendiente

- [ ] E3: revisión cruzada redactada individualmente con archivo, línea, criterio, consecuencia y propuesta. Falta repositorio del otro equipo.
- [ ] Integrantes: leer los archivos, registrar lector real y decisiones.
- [ ] Equipo: completar identificación, atender hallazgos recibidos y entregar en plataforma.
