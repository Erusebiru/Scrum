var global_countTime;

//funcion para comprobar el tipo de usuario y si esta en la pagina de la lista de proyectos para crear el boton de add proyect
if (global_tipoUsuario != undefined && window.location.href.indexOf('proyectos.php') != -1 ) {
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



//funcion que cambia el icono del sprintProximo(candado)
function cambiarIconoProximo(){
	var candadoAbierto=document.getElementById("proximo");
	
	if (candadoAbierto.innerText=="lock") {
		candadoAbierto.innerText="lock_open";
	}else{
		candadoAbierto.innerText="lock";
	}
	
}



//funcion que bloquea el sprint pasado
function sprintTancat(element){
	var elements = document.querySelectorAll("ul");
	elements.forEach(function(element){
		element.classList.remove("desplegado");
		element.parentNode.classList.remove("sprint-desplegado");
	});
	
}


//Función que despliega las características del Sprint
function showSprint(element){
	var elementoDesplegado = element.parentNode.querySelector("ul");
	if(!elementoDesplegado.classList.contains("desplegado")){
		removeClass();
		elementoDesplegado.classList.toggle("desplegado");
		element.parentNode.classList.toggle("sprint-desplegado");
	}else{
		removeClass();
	}
	
}

//Función que pliega el Sprint
function removeClass(){
	var elements = document.querySelectorAll("ul");
	elements.forEach(function(element){
		element.classList.remove("desplegado");
		element.parentNode.classList.remove("sprint-desplegado");
	});
}

function vistaProyecto(proyecto) {
	var proyecto_seleccionado = proyecto.name;
	Enviar_Nombre_Proyecto();
	document.querySelector("input[name=selectedProyect]").value=proyecto_seleccionado;
	document.querySelector("input[name=tipoUsuario]").value=global_tipoUsuario;
	document.getElementById("sendProyect").submit();
	}

function Enviar_Nombre_Proyecto() {
	var parent = document.querySelector(".new-proyect-view-box");
	var form = addElement(parent,"form",undefined,["action=vistaproyecto.php","method=post","id=sendProyect"]);
	addElement(form,"input",undefined,["type=hidden","name=selectedProyect"]);
	addElement(form,"input",undefined,["type=hidden","name=tipoUsuario"]);
	
}


//Funciones para añadir eventos al clickar en los botones de subir, bajar y eliminar

function clickUP(){
	var button = document.querySelectorAll(".upside");
	button.forEach(function(element){
		element.addEventListener("click",subir);
	});
}

function clickDOWN(){
	var button = document.querySelectorAll(".downside");
	button.forEach(function(element){
		element.addEventListener("click",bajar);
	});
}

function clickDROP(){
	var button = document.querySelectorAll(".del");
	button.forEach(function(element){
		element.addEventListener("click",eliminar);
	});
}

//Con esta función se ponen los números de especificación en orden cada vez que se haga una acción (subir, bajar, eliminar o añadir)
function reNumber(){
	var numeros = document.getElementsByName("numSpec");
	var num = 1;
	for(var i=0;i<numeros.length;i++){
		numeros[i].textContent = num;
		num++;
	}
}

//Función que lanza el conjunto de funciones para añadir eventos
//Con esta función centralizamos todos los eventos y si quisiéramos hacer nuevas cosas, sólo habría que añadir la llamada en ésta
function addEvents(){
	clickUP();
	clickDOWN();
	clickDROP();
	reNumber();
}

addEvents();


//Función para subir una especificación en el listado
function subir(){
	var parent = this.parentNode.parentNode.parentNode;
	var elemento = this.parentNode.parentNode;
	
	if(elemento !== parent.firstElementChild.nextElementSibling){
		var previo = elemento.previousElementSibling;
		var cloned = elemento.cloneNode(true);
		parent.insertBefore(cloned,previo);
		parent.removeChild(elemento);
		addEvents();
	}	
}

//Función para bajar una especificación en el listado
function bajar(){
	var parent = this.parentNode.parentNode.parentNode;
	var elemento = this.parentNode.parentNode;
	if(elemento !== parent.lastElementChild){
		var siguiente = elemento.nextElementSibling.nextElementSibling;
		var cloned = elemento.cloneNode(true);
		parent.insertBefore(cloned,siguiente);
		parent.removeChild(elemento);
		addEvents();
	}
	
}

//Función que elimina una especificación
function eliminar(){
	var parent = this.parentNode.parentNode.parentNode;
	var elemento = this.parentNode.parentNode;
	parent.removeChild(elemento);
	reNumber();
}

//Función que añade una nueva especificación
//Si el valor del input estuviera vacío devolvería un error
function addNewSpec(){
	var newSpec = document.getElementById("newSpec");
	if(newSpec.value == ""){
		var texto = "La especificación no puede estar vacía";
		createErrorWindow(texto);
	}else{
		var parent = document.querySelector(".especificacion > table").firstElementChild;

		var tr = addElement(parent,"tr",undefined,["class=spec"]);
		addElement(tr,"td","0",["name=numSpec"]);
		addElement(tr,"td",newSpec.value);
		addElement(tr,"td","Backlog")
		var td = addElement(tr,"td");
		addElement(td,"img",undefined,["src=images/up.png","class=upside"]);
		addElement(td,"img",undefined,["src=images/down.png","class=downside"]);
		addElement(td,"img",undefined,["src=images/del.png","class=del"]);
		addEvents();
	}
	newSpec.value = "";
}


//Función para comparar los input de password. Si son correctos enviará el formulario, si son incorrectos aparecerá un mensaje tipo.
function compararPassword(){
	var password1=document.getElementById("primerPassword").value;
	var password2=document.getElementById("segundoPassword").value;
	var formpass=document.getElementById("formpass");

	if(password1==password2) {
		formpass.submit();
	}
	else{
		createErrorWindow("Las Contraseña no coinciden");
	}
}

function deleteSprint(element) {
	reasignar_specs(element);

}

//funcion para pasar las especificaciones a backlog
function reasignar_specs(element) {
	//alert(element);
	//alert(element.parentNode);
	var specs = document.querySelectorAll("[name='specs"+element+"']");
	var parent = document.querySelector(".remove-specs-box");
	var form = addElement(parent,"form",undefined,["action=removeSpecs.php","method=post","id=sendSpecs"]);
	var num_specs = specs.length;
	addElement(form,"input",undefined,["type=hidden","name=num_specs","value="+specs.length]);

	for (var i=0;i<specs.length;i++){
		var especificacion = specs[i].firstElementChild.innerText;
		addElement(form,"input",undefined,["type=hidden","name=spec[]", "value="+especificacion]);
	}
	form.submit();


}

//Función que comprueba las fechas de los sprints
//En primera instancia comprueba si la fecha de inicio introducida es menor que la de fin
//Y luego comprueba que la fecha de inicio es superior a la fecha de fin del último sprint
function checkSprints(form){
	form = form.parentNode;
	console.log(form);
	var sprints = document.querySelectorAll(".sprintData");
	var startDate = getStartDate();
	var endDate = getEndDate();
	var sprint = sprints[sprints.length-1];

	if(startDate < endDate){
		var fecha_inicio_sprint = getSprintStartDate(sprint);
		var fecha_fin_sprint = getSprintEndDate(sprint)
		if(startDate > fecha_inicio_sprint){
			form.submit();
		}else{
			console.log("Mal");
		}
	}else{
		console.log("WRONG");
	}
}

//Función que devuelve la fecha de inicio introducida en el formulario que añade un nuevo sprint
function getStartDate(){
	var startDate = document.querySelector("[name='inicio']").value;
	startDate = new Date(startDate).getTime();
	return startDate;
}

//Función que devuelve la fecha de fin introducida en el formulario que añade un nuevo sprint
function getEndDate(){
	var endDate = document.querySelector("[name='fin']").value;
	endDate = new Date(endDate).getTime();
	return endDate;
}

//Función que devuelve la fecha de inicio del sprint que se le pasa por parámetro
function getSprintStartDate(sprint){
	var fecha_inicio_sprint = sprint.querySelector("[name='fechaInicio']").innerHTML;
	fecha_inicio_sprint = fecha_inicio_sprint.split("-").reverse().join("-");
	fecha_inicio_sprint = new Date(fecha_inicio_sprint).getTime();
	return fecha_inicio_sprint;
}

//Función que devuelve la fecha de fin del sprint que se le pasa por parámetro
function getSprintEndDate(sprint){
	var fecha_fin_sprint = sprint.querySelector("[name='fechaInicio']").innerHTML;
	fecha_fin_sprint = fecha_fin_sprint.split("-").reverse().join("-");
	fecha_fin_sprint = new Date(fecha_fin_sprint).getTime();
	return fecha_fin_sprint;
}