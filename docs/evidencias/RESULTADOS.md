# Evidencias técnicas S7

Verificación real el 11/10/2026 en la rama laboratorio-s7. Entorno: Windows, PHP 8.3.30 CLI, Laravel 12 (dependencias de composer.lock), MariaDB 10.4.32 de XAMPP en instancia aislada 127.0.0.1:3307 y servidor Laravel local 127.0.0.1:8000. La versión PHP 8.0 instalada originalmente no era compatible; se usó PHP portátil oficial sin reemplazar XAMPP. Son versiones de demostración local, no una certificación de despliegue productivo.

## Resultado automatizado

Comando desde web/: php artisan test --compact --no-ansi.

Resultado: **40 pruebas aprobadas, 158 aserciones, 2.70 segundos**. Laravel Pint --test --dirty: aprobado. composer validate: manifiesto válido. Las pruebas se ejecutaron con los datos de data/s7/, ya cargados previamente; interceptan y rechazan consultas que no sean SELECT/SHOW.

Cobertura comprobada: rutas 200/404; grupos ajenos y roles 403; entradas malformadas; acceso anónimo; omisiones y porcentajes; grupos activos y matrícula vigente; exclusión de cuarto grado; ausencia de identificadores individuales en dirección; estados sin datos; ingreso/salida real; límite de intentos; caducidad de ocho horas; cuenta inactiva; cabeceras sin caché; formularios sin CSRF 419; inexistencia de rutas de escritura; fallo SQL 503 sin detalles privados.

## Contraste de datos

- Estudiante EST-0001, octubre: 3 correctas de 6 = 50.0 %. Matemática 1/2; lectura 2/2; ciencias 0/2, con un error y una omisión.
- Docente G5A, octubre: dos participantes. Matemática 3 errores/4 respuestas = 75.0 %; ciencias 1/3 = 33.3 %; lectura 1/4 = 25.0 %. La omisión no se incluye en el denominador de error.
- Dirección, octubre: tres participantes únicos de dos grupos de quinto. Un grupo sin respuestas excluido. Los alumnos de cuarto e inactivos no forman parte del agregado.

## Evidencia visual

Las capturas locales se guardan en esta carpeta. Muestran datos ficticios. Se recorrió el ingreso y la navegación de los perfiles; también se inspeccionó el reporte individual con tamaño móvil. La tabla dispone de desplazamiento horizontal en pantallas estrechas. Las capturas son evidencia visual complementaria; los códigos HTTP y fórmulas se verifican en las pruebas.

## Lo que esta evidencia no afirma

No acredita revisión cruzada por compañeros, lectura individual, ejecución dentro del horario original de clase, entrega en plataforma, publicación remota ni cumplimiento de un presupuesto histórico de diez solicitudes a IA. Esas actividades no se inventan y quedan identificadas en registro_s7.md.

## Integridad de la base

SHOW GRANTS confirmó que la cuenta de la aplicación solo tiene USAGE y SELECT. Se calculó una huella SHA-256 de las filas de las diez tablas, ordenadas, antes y después de la última ejecución de pruebas. Ambas dieron e04eb22739d5d12876c0d4f702e605e78d2da2f31e414ce794f46f45bb645c3b: los datos no cambiaron. No se guardaron filas, hashes de contraseñas ni credenciales en la evidencia. La salida de PHPUnit está en pruebas.txt.
