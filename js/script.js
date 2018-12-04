var countTime;
var user = "ProductOwner";
newProyect(user);
proyectLink();

//Función que añade el evento click a los links de proyectos
function proyectLink(){
	var links = document.getElementsByName("proyecto");
	links.forEach(function(element){
		element.addEventListener("click",createErrorWindow);
	});
}

//Función que crea la ventana de error y los diferentes errores
function createErrorWindow(){
	var texto = "ERROR FATAL!!";
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

//Función que crea el botón de AddProyect, que sólo será visible si el usuario es de tipo ProductOwner
function newProyect(user){
	if(user == "ProductOwner"){
		var parent = document.querySelector(".proyect-table");
		addElement(parent,"button","Add Proyect",["onclick=showForm();","name=addProyect"])
	}
}


//Función que muestra el formulario para crear un nuevo proyecto. Este formulario sólo se creará cuando se clicke el botón de AddProyect
function showForm(){
	var parent = document.querySelector(".contenedor");
	var div = addElement(parent,"div",undefined,["class=proyect-list"]);
	var form = addElement(div,"form");
	addElement(form,"input",undefined,["type=text"]);
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