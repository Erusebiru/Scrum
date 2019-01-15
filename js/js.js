
initBoards();
initChilds();

//Inicialización de los espacios donde SÍ SE PUEDE colocar elementos
function initBoards(){
	var boxes = document.querySelectorAll(".board");
	for(const box of boxes){
		box.addEventListener("dragover", function( event ) {
			event.preventDefault();
		}, false);

		box.addEventListener("dragenter", function( event ) {
			if ( event.target.className == "board" ) {
				event.target.style.background = "red";
			}

		}, false);

	    box.addEventListener("dragleave", function( event ) {
			if ( event.target.className == "board" ) {
				event.target.style.background = "";
			}
		}, false);

		box.addEventListener("drop", function( event ) {
			event.preventDefault();
			if (event.target.className.includes("board")) {
				event.target.style.background = "";
				dragged.parentNode.removeChild(dragged);
				dragged = modifyDragged(dragged,event.target);
				event.target.querySelector("tbody").appendChild( dragged );
				dragged = null;
			}
		}, false);
	}
}

function modifyDragged(dragged,target){
	var tds = dragged.querySelectorAll("td");

	tds[0].innerText = tds[1].innerText;
	tds[1].innerText = "";
	tds[2].innerText = "sprint"+target.getAttribute("sprint");
	addElement(tds[1],"input",undefined,["type=text","name=inputhoras","class=input-field horasSpec"]);
	return dragged;
}

function initChilds(){
	//Inicialización de los elementos que SÍ SE PUEDEN mover
	var fills = document.querySelectorAll(".tarea");
	for(const fill of fills){
	    fill.addEventListener("drag", function( event ) {
		}, false);
	    fill.addEventListener("dragstart", function( event ) {
			dragged = event.target;
			event.dataTransfer.setData('Text', this.id); //Evento para poder mover elementos en Firefox
			event.target.style.opacity = 0.5;
		}, false);
		fill.addEventListener("dragend", function( event ) {
			event.target.style.opacity = "";
		}, false);
	}
}

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