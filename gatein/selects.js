// JavaScript Document
function crearAjax(){
	
	var linea = document.getElementById('').value;
	
	
	if(typeof XMLHttpRequest == "undefined"){
		XMLHttpRequest = function(){return new ActiveXObject(navigator.userAgent.indexOf("MSIE 5") >= 0 ?"Microsoft.XMLHTTP" : "Msxml2.XMLHTTP2");};
	}
	
	var completar ajax = new XMLHttpRequest();


    criterio = document.getElementById('serial').value;
    url = "autocompletar.php?serial="+criterio;
    
    completar.open("GET", url, true);
	completar.onreadystatechange=function(){
	    if(completar.readyState==4){
                respuesta = completar.responseText;
                opciones = document.getElementById('opciones');
                
                //hacer visible el div opciones y cargar el contenido de respuesta de autocompletar.php
                opciones.style.display='block';
                opciones.innerHTML = respuesta;
                //para que el div opciones no se muestre si no hay texto en criterio
                if(criterio==''){
                    opciones.style.display = 'none';
                }
	    }
	}
    completar.send(null);


