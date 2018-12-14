var global_countTime;

if (global_tipoUsuario != undefined) {
	newProyect(global_tipoUsuario);
}

if(global_error != undefined){
	if(global_error == "usuario"){
	var texto = "¡ERROR! Usuario no encontrado";
	createErrorWindow(texto);
	}else if(global_error == "password"){
		var texto = "¡ERROR! Contraseña errónea.";
		createErrorWindow(texto);
	}
}

//Esta función sirve para inicializar los elementos SELECT dado que Materialize por defecto los tiene bloqueados
//Sólo se usa para esto, aunque es JQuery
function initSelect(){
	$(document).ready(function(){
		$('select').formSelect();
	});
}

//Función que crea la ventana de error y los diferentes errores
function createErrorWindow(texto){
	
	var parent = document.querySelector(".error");
	var div = addElement(parent,"div",undefined,["class=image-error"]);
	var image = addElement(div,"img",undefined,["src=images/error.png"]);
	var span = addElement(div,"span",texto,["class=error-message"]);

	document.querySelector(".window-message").style.display = "block";
	resetAnimation(parent);
	setTimer();
}

//Función que resetea la animación clonando el objeto y reemplazándolo por sí mismo. Cuando esto ocurre la animación inicia de cero.
function resetAnimation(error){
	var newElement = error.cloneNode(true);
	error.parentNode.replaceChild(newElement,error);
}

//Función que crea un timer que, tras 10 segundos, oculta de nuevo la ventana de error y elimina los errores creados.
//Se eliminan para que la próxima vez que se genere un error sin recargar la página no aparezcan.
function setTimer(){
	clearTimeout(global_countTime);
	global_countTime =	setTimeout(function (){
		document.querySelector(".window-message").style.display = "none";
		var parent = document.querySelector(".error");
		var childs = document.querySelectorAll(".image-error");
		childs.forEach(function(element){
			parent.removeChild(element);
		});
	}, 10000);
}

//Función que crea el botón de AddProyect, que sólo será visible si el usuario es de tipo ScrumMaster
function newProyect(user){
	if(user == "scrumMaster"){
		var parent = document.querySelector(".proyect-table");
		addElement(parent,"button","Add Proyect",["onclick=showForm();","name=addProyect"])
	}
}

//Función que crea de cero un formulario para añadir un nuevo proyecto.
function showForm(){
	document.querySelector("[name='addProyect']").disabled = true;
	document.querySelector(".new-proyect-box").style.display = "block";
	var parent = document.querySelector(".new-proyect-box");
	var form = addElement(parent,"form",undefined,["action=insert.php","method=post","id=createProyect"]);
	var div = addElement(form,"div",undefined,["class=card-content container"]);
	addElement(div,"span","Añadir nuevo proyecto",["class=card-title"]);
	var divrow = addElement(div,"div",undefined,["class=row"]);
	
	createText(divrow,"Nombre del proyecto: ","ProyectName");
	createText(divrow,"Descripción del proyecto: ","descripcion");

	createSelect(divrow,"Scrum Master del proyecto: ","scrumMaster");
	createSelect(divrow,"Product Owner del proyecto: ","productOwner");
	createGroup(divrow,"Grupos del proyecto: ","grupos");

	addElement(form,"div","Crear",["class=button","onclick=checkNulls()"]);
}

//Función para crear un elemento de tipo texto para el formulario
function createText(parent,labelText,name){
	var divcol = addElement(parent, "div", undefined, ["class=input-field col s12"]);
	addElement(divcol,"label",labelText,["for="+name]);
	addElement(divcol,"input",undefined,["type=text","name="+name]);
}

//Función para crear un elemento de tipo select para el formulario
function createSelect(parent,labelText,name){
	var divcol = addElement(parent, "div", undefined, ["class=col s12"]);
	addElement(divcol,"label",labelText,undefined);
	addElement(divcol,"br",labelText,undefined);
	var select = addElement(divcol,"select",undefined,["name="+name]);
	addElement(select,"option",undefined,["selected=selected","disabled=true","value="]).text = "Selecciona una opción";
	createDropDown(select,name);
	initSelect();
}

//Función que añade los options al formulario según el tipo de usuario
function createDropDown(select,global_tipoUsuario){
	global_personas.forEach(function(element){
		if(element.tipo == global_tipoUsuario){
			var option = addElement(select,"option");
			option.text = element.name;
			option.value = element.id;
			select.add(option);
		}
	});
}

//Función para crear un select de grupos, que será un select multiple
function createGroup(parent,labelText,name){
	var divcol = addElement(parent, "div", undefined, ["class=col s12"]);
	addElement(divcol,"label",labelText,undefined);
	addElement(divcol,"br",labelText,undefined);
	var select = addElement(divcol,"select",undefined,["name="+name+"[]","multiple=true"]);
	addElement(select,"option",undefined,["disabled=true","value="]).text = "Selecciona una opción";
	insertGroup(select,name);
	initSelect();
}

//Función para insertar los option con los nombres de los grupos en el select
function insertGroup(select){
	global_grupos.forEach(function(element){
		var option = addElement(select,"option");
		option.text = element.name;
		option.value = element.id;
		select.add(option);
	});
}


//Función para crear nuevos elementos. Podrán tener un texto y diferentes atributos que se enviarán en forma de array
//Devuelve el elemento creado para poder concatenar creación de elementos
function addElement(parent, child, text,attributes){
	var childElement = document.createElement(child);
	if(text != undefined){
		var contenido = document.createTextNode(text);
		childElement.appendChild(contenido);
	}

	if(attributes != undefined && attributes instanceof Array){
		for(var i=0;i<attributes.length;i++){
			var attrName = attributes[i].split("=")[0];
			var attrValue = attributes[i].split("=")[1];
			childElement.setAttribute(attrName,attrValue);
		}
	}
	parent.appendChild(childElement);
	return childElement;
}


//Función para comprobar los elementos vacíos del formulario que añade un nuevo proyecto
function checkNulls(){
	
	form = document.getElementById("createProyect");
	var control = true;
	for(var i=0;i<form.length;i++){
		if(form[i].value == ""){
			if(form[i].name != "descripcion"){
				createErrorWindow("La opción "+form[i].name+" es obligatoria");
				control = false;
			}
		}
	}

	if(control){
		form.submit();
	}
}


//Función que despliega las características del Sprint
function showSprint(element){
	var elementoDesplegado = element.parentNode.querySelector("ul");
	if(!elementoDesplegado.classList.contains("desplegado")){
		removeClass();
		elementoDesplegado.classList.toggle("desplegado");
	}else{
		removeClass();
	}
}

//Función que pliega el Sprint
function removeClass(){
	var elements = document.querySelectorAll("ul");
	elements.forEach(function(element){
		element.classList.remove("desplegado");
	});
}