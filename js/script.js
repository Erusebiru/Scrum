var countTime;

if(error != undefined){
	if(error == "usuario"){
	var texto = "¡ERROR! Usuario no encontrado";
	createErrorWindow(texto);
	}else if(error == "password"){
		var texto = "¡ERROR! Contraseña errónea.";
		createErrorWindow(texto);
	}
}

if(tipoUsuario != undefined){
	newProyect(tipoUsuario);
}


//Esta función sirve para inicializar los elementos SELECT dado que Materialize por defecto los tiene bloqueados
//Sólo se usa para esto, aunque es JQuery
function initSelect(){
	$(document).ready(function(){
		$('select').formSelect();
	});
}

//Función que añade el evento click a los links de proyectos
function proyectLink(){
	var links = document.getElementsByName("proyecto");
	links.forEach(function(element){
		element.addEventListener("click",createErrorWindow);
	});
}

proyectLink();

//Función que crea la ventana de error y los diferentes errores
function createErrorWindow(texto){
	
	var parent = document.querySelector(".error");
	var div = addElement(parent,"div",undefined,["class=image-error"]);
	var image = addElement(div,"img",undefined,["src=images/error.png"]);
	var span = addElement(div,"span",texto,["class=error-message"]);
	var span = document.createElement("span");

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
	clearTimeout(countTime);
	countTime =	setTimeout(function (){
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

function createText(parent,labelText,name){
	var divcol = addElement(parent, "div", undefined, ["class=input-field col s12"]);
	addElement(divcol,"label",labelText,["for="+name]);
	addElement(divcol,"input",undefined,["type=text","name="+name]);
}

function createSelect(parent,labelText,name){
	var divcol = addElement(parent, "div", undefined, ["class=col s12"]);
	addElement(divcol,"label",labelText,undefined);
	addElement(divcol,"br",labelText,undefined);
	var select = addElement(divcol,"select",undefined,["name="+name]);
	addElement(select,"option",undefined,["selected=selected","disabled=true","value="]).text = "Selecciona una opción";
	createDropDown(select,name);
	initSelect();
}

function createDropDown(select,tipoUsuario){
	personas.forEach(function(element){
		if(element.tipo == tipoUsuario){
			var option = addElement(select,"option");
			option.text = element.name;
			option.value = element.id;
			select.add(option);
		}
	});
}

function createGroup(parent,labelText,name){
	var divcol = addElement(parent, "div", undefined, ["class=col s12"]);
	addElement(divcol,"label",labelText,undefined);
	addElement(divcol,"br",labelText,undefined);
	var select = addElement(divcol,"select",undefined,["name="+name+"[]","multiple=true"]);
	addElement(select,"option",undefined,["disabled=true","value="]).text = "Selecciona una opción";
	insertGroup(select,name);
	initSelect();
}
function insertGroup(select){
	grupos.forEach(function(element){
		var option = addElement(select,"option");
		option.text = element.name;
		option.value = element.id;
		select.add(option);
	});
}

/*
//Función que muestra el formulario para crear un nuevo proyecto. Este formulario sólo se creará cuando se clicke el botón de AddProyect, que se deshabilitará al hacerlo
function showForm(){
	document.querySelector("[name='addProyect']").disabled = true;
	var parent = document.querySelector(".contenedor");
	var div = addElement(parent,"div",undefined,["class=proyect-form"]);
	
	var form = addElement(div,"form",undefined,["action=insert.php","method=post","id=createProyect"]);

	addElement(form,"h4","Añadir nuevo proyecto",["class=form-element"]);

	createText(form,"Nombre del proyecto: ","ProyectName");
	createText(form,"Descripción del proyecto: ","descripcion");

	createSelect(form,"Scrum Master del proyecto: ","scrumMaster");
	createSelect(form,"Product Owner del proyecto: ","productOwner");

	var inputdiv = addElement(form,"div",undefined,["class=form-element"]);
	addElement(inputdiv,"label","Grupos: ",["for=grupo"]);
	addElement(inputdiv,"br");
	var select = addElement(inputdiv,"select",undefined,["name=grupo"]);
	addElement(select,"option",undefined,["disabled=true","selected=selected","value="]).text = "Elige una opción";
	insertGroup(select);
	
	addElement(form,"br");

	addElement(form,"div","Crear",["class=button","onclick=checkNulls()"]);
}

function createText(form,labelText,name){
	var inputdiv = addElement(form,"div",undefined,["class=form-element"]);
	addElement(inputdiv,"label",labelText,["for="+name]);
	addElement(inputdiv,"br");
	addElement(inputdiv,"input",undefined,["type=text","name="+name, "class=input-field"]);
}

function createSelect(form,labelText,name){
	var inputdiv = addElement(form,"div",undefined,["class=form-element"]);
	addElement(inputdiv,"label",labelText,["for="+name]);
	addElement(inputdiv,"br");
	var select = addElement(inputdiv,"select",undefined,["name="+name]);
	addElement(select,"option",undefined,["disabled=true","selected=selected","value="]).text = "Elige una opción";
	createDropDown(select,name);
}

function createDropDown(select,tipoUsuario){
	personas.forEach(function(element){
		if(element.tipo == tipoUsuario){
			var option = addElement(select,"option");
			option.text = element.name;
			option.value = element.id;
			select.add(option);
		}
	});
}*/

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