# Ejecutar y demostrar el laboratorio S7 en VS Code

## Entrega

Rama laboratorio-s7, basada en develop (698175744060ceb83dc3ecf6ce64623715ad87bf). Se implementaron tres cortes verticales: reporte individual, grupal e institucional, autenticación y pruebas. El proyecto Python previo permanece en el repositorio como antecedente. El punto de entrada de esta entrega es web/.

## Instalación en otra computadora

1. Abrir la carpeta del repositorio en VS Code y cambiar a laboratorio-s7. Usar PHP 8.2 o superior con pdo_mysql, mbstring, openssl, fileinfo, curl, xml y Composer 2. PHP 8.0 de algunas versiones de XAMPP no sirve para Laravel 12. MySQL/MariaDB puede ejecutarse desde XAMPP.
2. Desde web/, ejecutar composer install. No ejecutar migraciones ni seeders. No se requiere npm ni una API externa.
3. Desde la raíz del repositorio, preparar una base ficticia independiente, una sola vez: php tools/preparar_demo.php --crear-base-aislada. Antes, definir S7_DB_PORT (por defecto 3306), S7_DB_ADMIN (por defecto root) y S7_DB_ADMIN_PASSWORD en el entorno de la terminal si corresponde. Este administrador necesita permisos para crear una base y su usuario. El programa crea exclusivamente asistente_cni_s7 y se detiene si la base, web/.env o las credenciales ya existen. No borrar una base existente para volver a ejecutarlo. Si falla a mitad, inspeccionar el error y la base aislada antes de reintentar.
4. La preparación genera web/.env con cuenta SELECT, clave de aplicación y contraseña aleatoria de demostración. Consultar web/storage/app/private/demo-credentials.json para conocer esa contraseña. Ambos archivos están ignorados por Git.
5. Desde web/, ejecutar php artisan config:clear y php artisan serve --host=127.0.0.1 --port=8000. Abrir http://127.0.0.1:8000/ingresar.
6. Para las pruebas, ejecutar php artisan test --compact desde web/. Requieren la base ficticia ya preparada, sin crear ni limpiar tablas. No usan RefreshDatabase ni SQLite. No ejecutarlas sobre datos reales: las expectativas corresponden exactamente a la demostración.

Si se usa una copia institucional existente en lugar de B0, configurar .env desde .env.example, generar APP_KEY con php artisan key:generate y utilizar una cuenta SELECT sobre el esquema existente. No ejecutar B0 contra esa base. Las pruebas de fixture necesitan su propia base ficticia y contraseña S7_DEMO_PASSWORD o el archivo privado generado.

## Demostración de cinco minutos

| Cuenta | Abrir después de ingresar | Qué comprobar |
|---|---|---|
| est_0001 | /estudiante/reporte/2 | Octubre: 3/6, 50.0 %, Ciencias 0 %, una omisión |
| est_0001 | /estudiante/reporte/no-existe-zz | Página 404 amigable |
| est_0004 | /estudiante/reporte | Mensaje sin resultados |
| doc_0001 | /docente/grupos | Solo G5A y G5C |
| doc_0001 | /docente/grupos/G5A/simulacros/2 | Dos participantes; Matemática 75.0 % de error |
| doc_0001 | /docente/grupos/G5B/simulacros/2 | Acceso 403 por grupo ajeno |
| doc_0001 | /docente/grupos/G5A/simulacros/3 | Simulacro asignado sin resultados |
| dir_0001 | /direccion/resumen/2 | Tres participantes, dos grupos incluidos y uno excluido; sin códigos individuales |

Cerrar sesión para cambiar de cuenta. Todas las cuentas ficticias comparten la contraseña aleatoria de la preparación. No confundir la contraseña de demostración con DB_PASSWORD. El simulacro más reciente del docente/dirección es intencionalmente uno sin resultados; seleccionar «Simulacro de octubre» para ver cifras.

## Archivos para sustentar

- .kiro/specs/asistente-retroalimentacion-simulacros/tasks.md: plan podado.
- docs/trazabilidad_s7.md: historias, decisiones y URLs.
- docs/adr/adr_004_alcance_laboratorio_s7.md: adaptación tecnológica y alcance.
- docs/arquitectura/s7.md: recorrido, fórmulas y seguridad.
- docs/evidencias/RESULTADOS.md: verificaciones realizadas.
- docs/registro_s7.md: registro honesto de decisiones y trabajo pendiente humano.
- docs/revision_cruzada_s7.md: plantilla E3 que cada integrante debe redactar tras revisar otro equipo.

## Publicación

No se modifica main ni develop. Publicar solamente la rama con git push -u origin laboratorio-s7 desde una sesión de GitHub con escritura. La conexión utilizada durante el desarrollo rechazó la creación remota con 403; por ello no hay rama remota ni PR creados por esta entrega. No hacer merge sin revisión del equipo.

El archivo laboratorio-s7.bundle entregado junto al proyecto permite trasladar los commits a otro clon: ejecutar git fetch RUTA_AL_BUNDLE laboratorio-s7:refs/heads/laboratorio-s7 y después git switch laboratorio-s7. Requiere que el clon tenga el commit base de develop. El ZIP es una copia del código versionado: no contiene dependencias, .env, credenciales, base de datos ni historial Git.
