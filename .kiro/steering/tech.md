---
# Stack y reglas técnicas
- Framework: [DECISIÓN DE ADR-001], versión estable vigente [VERIFICAR].
- Base de datos: MySQL/MariaDB de XAMPP; collation utf8mb4_unicode_ci.
- Servidor: Apache de XAMPP; raíz pública: [CARPETA PUBLIC DEL FRAMEWORK].
- Nombres: español; snake_case en base de datos; PascalCase en clases; kebab-case en rutas.
- Secretos únicamente en .env; .env nunca se versiona.
- Todo módulo nuevo traza a una historia de requirements.md; si no traza, no se construye.
- FRONTERA: no implementar agente conversacional, modelos de IA ni MCP hasta la Unidad 3. Dejar solo el punto de extensión documentado.
- Toda tabla nueva obliga a actualizar docs/arquitectura/modelo_datos.md en el mismo commit.
---
## Reglas de la sesión 7
- La aplicación Laravel vive en web/. Toda ruta de archivo es relativa a web/.
- La base de datos YA EXISTE con tablas y datos. PROHIBIDO crear migraciones o seeders.
- Modelos Eloquent sobre tablas existentes: protected $table; public $timestamps = false si la tabla no tiene created_at/updated_at.
- Consultas solo con Eloquent o Query Builder parametrizado. Nunca DB::raw con datos del usuario ni SQL concatenado.
- Todo parámetro de ruta se valida; si el recurso no existe, abort(404).
- Cada archivo generado empieza con el comentario // Historia: H-xx
- Mensajes de commit: tipo(H-xx): descripción.