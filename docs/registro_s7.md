# Registro de la Sesión 7 · Equipo

## Respuesta a la Sección 2
**Pregunta:** Si en la semana 11 su agente conversacional necesita consultar los datos de su organización, ¿qué tiene que existir hoy para que eso sea posible?

**Respuesta:** Deben existir las tablas estructuradas en la base de datos con datos reales y los modelos Eloquent mapeados correctamente en el proyecto para que el agente pueda realizar las consultas sin problemas.

## Desarrollo asistido registrado el 11/10/2026

Solicitud del usuario: desarrollar el laboratorio completo con VS Code, omitir el uso de Kiro y trabajar en una rama aparte para preservar lo avanzado por los compañeros. Fuente de alcance: S7_Guia_de_laboratorio_estudiantes.docx, requisitos y diseño existentes, rama develop. No se atribuye este trabajo al horario original de clase.

### Decisiones y resultados

| Solicitud o problema | Decisión aplicada | Evidencia |
|---|---|---|
| Continuar el avance del equipo sin alterarlo | Rama local laboratorio-s7 desde develop; no merge | Historial Git y ADR-004 |
| Documentos mezclaban FastAPI/SQLite y Laravel/MySQL | Usar web/ Laravel existente y tablas MySQL, conservar antecedentes | Arquitectura S7 y nota en diseño |
| Plan organizado por capas y trabajo futuro | Podar y dividir en tres cortes verticales | tasks.md, trazabilidad_s7.md, copia del plan anterior |
| No había datos de demostración cargados | Preparación B0 explícita en base nueva con datos ficticios | tools/preparar_demo.php y data/s7/ |
| PHP instalado era 8.0 | Runtime portátil oficial compatible; no reemplazar XAMPP ni desactivar protección de Windows | Pruebas en PHP 8.3.30 |
| Evitar escrituras durante las consultas | Usuario SQL SELECT, sesiones/caché en archivos, sin migraciones | Configuración y pruebas de lectura |
| Cubrir reporte individual, grupal e institucional | Rutas, controladores, modelos, cálculos y vistas por historia | Tres commits feat(H-xx) |
| Verificar fallos y accesos | 40 pruebas, 158 aserciones aprobadas; navegación de tres perfiles | docs/evidencias/RESULTADOS.md |
| Subir trabajo aislado a GitHub | La rama laboratorio-s7 quedó publicada en upstream | Disponible para revisión e integración posterior a develop |

### Registro de uso de IA

El usuario dio autorización general para implementar. Se empleó asistencia de Codex para lectura del repositorio, diseño del alcance, código, pruebas, documentación y comprobación visual. Este registro agrupa decisiones reales; no pretende reproducir solicitudes independientes inexistentes ni acreditar el máximo de diez solicitudes de una dinámica de aula ya realizada. El historial de esta conversación conserva la interacción original. No se enviaron mensajes a compañeros ni se inventaron revisiones humanas.

### Lecturas y validación del equipo — completar por cada integrante

| Integrante real | Archivo leído y commit | Qué comprendió o corrigió | Fecha |
|---|---|---|---|
| Malasquez Laredo Jimmy Alexander | web/routes/web.php — b68fa5d | Comprendió que web.php define las rutas del sistema, envía cada URL a su controlador, protege las rutas privadas con los middleware auth y vigente y restringe los parámetros recibidos. | 2026-10-11 |
| Alvarez Calagua Nia Elizabeth | Pendiente | Pendiente | Pendiente |
| Rojas Castillo Sebastian Jaren | Pendiente | Pendiente | Pendiente |
| Oscar Andres Yaranga Huamanchaqui | Pendiente | Pendiente | Pendiente |

### Deuda y cierre

- E3 no se incluye en esta entrega según la indicación comunicada al equipo; no se fabrican revisiones cruzadas no realizadas.
- Confirmar con el docente la adaptación VS Code y la entrega en rama separada, dado que la guía menciona develop. No se fusionó por la instrucción del solicitante.
- Completar las lecturas y validaciones reales de Nia, Sebastián y Oscar antes del cierre final.
- Publicar la rama con una cuenta GitHub con escritura. La rama remota y el PR no están creados.
- Funcionalidad futura: comparación, orientación, detalle individual docente, Gemini/MCP y administración. Auditoría SQL, TLS y revisión con datos reales quedan fuera de esta demostración.

Los puntos anteriores son pendientes explícitos; no se declara cumplida una actividad humana o académica que no ocurrió.
