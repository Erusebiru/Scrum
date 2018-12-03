
CREATE DATABASE ProyectoSCRUM;


CREATE TABLE tipos_usuario(
	id_tipo_usuario int(10) AUTO_INCREMENT PRIMARY KEY,
	nombre_tipo varchar(40) NOT NULL
);

CREATE TABLE grupos(
	id_grupo int(10) AUTO_INCREMENT PRIMARY KEY,
	nombre_grupo varchar(40),
	id_proyecto int(10)
);

CREATE TABLE usuarios(
	id_usuario int(10) AUTO_INCREMENT PRIMARY KEY,
	nombre_usuario varchar(100) NOT NULL,
	password varchar(512) NOT NULL,
	email varchar(50) NOT NULL,
	id_tipo_usuario int(10) NOT NULL,
	id_grupo int(10),
	id_spec int(10),
	CONSTRAINT fk_id_grupo_usuarios FOREIGN KEY (id_grupo) REFERENCES grupos(id_grupo) ON DELETE CASCADE,
	CONSTRAINT id_tipo_usuario_usuarios FOREIGN KEY (id_tipo_usuario) REFERENCES tipos_usuario(id_tipo_usuario) ON DELETE CASCADE
);

CREATE TABLE proyectos(
	id_proyecto int(10) AUTO_INCREMENT PRIMARY KEY,
	nombre_proyecto varchar(30) NOT NULL,
	descripcion_proyecto varchar(150) NOT NULL,
	ScrumMaster int(10) NOT NULL,
	ProductOwner int(10) NOT NULL,
	CONSTRAINT fk_id_scrummaster_proyectos FOREIGN KEY (ScrumMaster) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
	CONSTRAINT fk_id_productowner_proyectos FOREIGN KEY (ProductOwner) REFERENCES usuarios(id_usuario) ON DELETE CASCADE
);

CREATE TABLE sprints(
	id_sprint int(10) AUTO_INCREMENT PRIMARY KEY,
	horasTotales int(5) NOT NULL,
	Fecha_Inicio DATE NOT NULL,
	Fecha_Fin DATE NOT NULL,
	id_proyecto int(10) NOT NULL,
	CONSTRAINT fk_id_proyecto_sprints FOREIGN KEY (id_proyecto) REFERENCES proyectos(id_proyecto) ON DELETE CASCADE
);

CREATE TABLE especificaciones(
	id_spec int(10) AUTO_INCREMENT PRIMARY KEY,
	numero int(5) NOT NULL,
	horas int(5) NOT NULL,
	estado varchar(20) NOT NULL,
	id_sprint int(10) NOT NULL,
	id_proyecto int(10) NOT NULL,
	CONSTRAINT fk_id_sprint_especificaciones FOREIGN KEY (id_sprint) REFERENCES sprints(id_sprint) ON DELETE CASCADE,
	CONSTRAINT fk_id_proyecto_especificaciones FOREIGN KEY (id_proyecto) REFERENCES proyectos(id_proyecto) ON DELETE CASCADE
);

CREATE TABLE tareas(
	id_tarea int(10) AUTO_INCREMENT PRIMARY KEY,
	descripcion_tarea varchar(150) NOT NULL,
	horas int(5) NOT NULL,
	estado varchar(20) NOT NULL,
	dificultad varchar(20) NOT NULL,
	id_spec int(10) NOT NULL,
	id_usuario int(10) NOT NULL,
	CONSTRAINT fk_id_spec_tareas FOREIGN KEY (id_spec) REFERENCES especificaciones(id_spec) ON DELETE CASCADE,
	CONSTRAINT fk_id_usuario_tareas FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE
);

ALTER TABLE grupos ADD CONSTRAINT id_proyecto_grupos FOREIGN KEY (id_proyecto) REFERENCES proyectos(id_proyecto) ON DELETE CASCADE;
ALTER TABLE usuarios ADD CONSTRAINT id_spec_usuarios FOREIGN KEY (id_spec) REFERENCES especificaciones(id_spec) ON DELETE CASCADE;