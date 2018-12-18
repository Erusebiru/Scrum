var global_error;
var global_personas = [];

var global_error = "";

var global_tipoUsuario = "";

class Persona{
	constructor(id,name,tipo){
		this.id = id;
		this.name = name;
		this.tipo = tipo;
	}
}

var global_grupos = [];

class Grupo{
	constructor(id,name){
		this.id = id;
		this.name = name;
	}
}