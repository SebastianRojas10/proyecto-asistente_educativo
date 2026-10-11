-- Historia: H-01, H-03, H-04, H-07, H-09, H-11
-- Datos enteramente ficticios. @demo_hash se suministra durante la preparación B0.
INSERT INTO usuario (usuario_id,nombre_usuario,contrasena_hash,rol,codigo_anonimo,activo) VALUES
(1,'est_0001',@demo_hash,'estudiante','EST-0001',1),
(2,'est_0002',@demo_hash,'estudiante','EST-0002',1),
(3,'est_0003',@demo_hash,'estudiante','EST-0003',1),
(4,'est_0004',@demo_hash,'estudiante','EST-0004',1),
(5,'est_0005',@demo_hash,'estudiante','EST-0005',1),
(6,'est_inactivo',@demo_hash,'estudiante','EST-0006',0),
(10,'doc_0001',@demo_hash,'docente',NULL,1),
(11,'doc_0002',@demo_hash,'docente',NULL,1),
(12,'doc_sin_grupos',@demo_hash,'docente',NULL,1),
(20,'dir_0001',@demo_hash,'direccion',NULL,1);
INSERT INTO grupo (grupo_id,codigo_grupo,nivel,seccion,activo) VALUES
(1,'G5A','5.º secundaria','A',1),(2,'G5B','5.º secundaria','B',1),
(3,'G5C','5.º secundaria','C',1),(4,'G4A','4.º secundaria','A',1);
INSERT INTO docente_grupo VALUES (10,1),(10,3),(11,2),(11,4);
INSERT INTO estudiante_grupo VALUES
(1,1,'2026-03-01',1),(2,1,'2026-03-01',1),(3,2,'2026-03-01',1),
(4,3,'2026-03-01',1),(5,4,'2026-03-01',1),(6,1,'2026-03-01',1),
(3,1,'2025-03-01',0);
INSERT INTO simulacro (simulacro_id,nombre,fecha_aplicacion,fecha_registro,descripcion) VALUES
(1,'Simulacro de septiembre','2026-09-25','2026-09-26 09:00:00','Primera evaluación ficticia'),
(2,'Simulacro de octubre','2026-10-09','2026-10-10 09:00:00','Evaluación ficticia para S7'),
(3,'Simulacro sin resultados','2026-10-10','2026-10-10 10:00:00','Caso vacío'),
(4,'Simulacro exclusivo B','2026-10-08','2026-10-08 10:00:00','Caso de autorización');
INSERT INTO simulacro_grupo VALUES (1,1),(1,2),(1,3),(1,4),(2,1),(2,2),(2,3),(2,4),(3,1),(3,3),(4,2);
INSERT INTO tema (tema_id,nombre,descripcion) VALUES
(1,'Matemática','Cálculo y razonamiento'),(2,'Comprensión lectora','Comprensión de textos'),
(3,'Ciencias','Conceptos científicos'),(4,'Historia','Tema sin preguntas en S7');
INSERT INTO pregunta (pregunta_id,simulacro_id,tema_id,numero_pregunta,opcion_correcta) VALUES
(1,1,1,1,'A'),(2,1,1,2,'B'),(3,1,2,3,'C'),(4,1,2,4,'D'),(5,1,3,5,'E'),(6,1,3,6,'A'),
(7,2,1,1,'A'),(8,2,1,2,'B'),(9,2,2,3,'C'),(10,2,2,4,'D'),(11,2,3,5,'E'),(12,2,3,6,'A'),
(13,4,1,1,'A');
INSERT INTO respuesta (usuario_id,pregunta_id,opcion_seleccionada) VALUES
(1,1,'A'),(1,2,'A'),(1,3,'C'),(1,4,'A'),(1,5,'A'),(1,6,'B'),
(1,7,'A'),(1,8,'A'),(1,9,'C'),(1,10,'D'),(1,11,'A'),
(2,7,'B'),(2,8,'A'),(2,9,'C'),(2,10,'A'),(2,11,'E'),(2,12,'A'),
(3,7,'A'),(3,8,'B'),(3,9,'C'),(3,10,'D'),(3,11,'E'),(3,12,'A'),(3,13,'A'),
(5,7,'A'),(5,8,'B'),(5,9,'C'),(5,10,'D'),(5,11,'E'),(5,12,'A'),
(6,7,'A'),(6,8,'B'),(6,9,'C'),(6,10,'D'),(6,11,'E'),(6,12,'A');
