 // JavaScript Document

//Datos permitidos
function permite(elEvento, permitidos) {
  // Variables que definen los caracteres permitidos
  var numeros = "0123456789";
  var caracteres = " abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
  var numeros_caracteres = numeros + caracteres;
  var teclas_especiales = [8, 37, 39, 46];
  // 8 = BackSpace, 46 = Supr, 37 = flecha izquierda, 39 = flecha derecha
 
 
  // Seleccionar los caracteres a partir del parámetro de la función
  switch(permitidos) {
    case 'num':
      permitidos = numeros;
      break;
    case 'car':
      permitidos = caracteres;
      break;
    case 'num_car':
      permitidos = numeros_caracteres;
      break;
  }
 
  // Obtener la tecla pulsada 
  var evento = elEvento || window.event;
  var codigoCaracter = evento.charCode || evento.keyCode;
  var caracter = String.fromCharCode(codigoCaracter);
 
  // Comprobar si la tecla pulsada es alguna de las teclas especiales
  // (teclas de borrado y flechas horizontales)
  var tecla_especial = false;
  for(var i in teclas_especiales) {
    if(codigoCaracter == teclas_especiales[i]) {
      tecla_especial = true;
      break;
    }
  }
 
  // Comprobar si la tecla pulsada se encuentra en los caracteres permitidos
  // o si es una tecla especial
  return permitidos.indexOf(caracter) != -1 || tecla_especial;
}

function validarNombres(campoN,valorN){
	var sigue = false;
	if(valorN.match(/^(\S[a-zA-Z]{2,20})$/)){
		document.getElementById(campoN).style.background = "#BBFFFF";
	}else {
		document.getElementById(campoN).style.background = "#FFC1C1";
		document.getElementById(campoN).focus();
		sigue = false;
		alert('Invalido');
	}
}

function validarEmail(campoE,valorE){
	var sigue = false;
	if(valorE.match(/^\S[a-zA-Z0-9_.-]{2,}@[a-zA-Z0-9_-]{2,}\.[a-zA-Z]{2,4}(\.[a-zA-Z]{2,4})?$/)){
		document.getElementById(campoE).style.background = "#BBFFFF";
	}else {
		document.getElementById(campoE).style.background = "#FFC1C1";
		document.getElementById(campoE).focus();
		alert('Invalido');
	}
}

function validarTlf(telefono){
	var sigue = false;
	var tlf = document.getElementById(telefono).value;
	if(tlf.match(/^[0-9]{11}$/)){
		document.getElementById(telefono).style.background = "#BBFFFF";
	}else {
		document.getElementById(telefono).style.background = "#FFC1C1";
		document.getElementById(telefono).focus();
		alert('Invalido');
	}
}

function validarUsuario(user){
	var sigue = false;
	var patronUser = /^\S[a-zA-Z0-9]{6,12}$/;
	var User = document.getElementById(user).value;
	
	if(User.match(patronUser) && (User!='') && (User!='root') && (User!='admin') ){
		document.getElementById(user).style.background = "#BBFFFF";
	}else {
		document.getElementById(user).style.background = "#FFC1C1";
		document.getElementById(user).focus();
		alert('Invalido');
	}
}

function validarClave(clave){
	var sigue = false;
	var patron = /(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{6,12})$/;
	var Valor = document.getElementById(clave).value;
	if(Valor.match(patron) && (Valor!='')){
		document.getElementById(clave).style.background = "#BBFFFF";
	}else {
		document.getElementById(clave).style.background = "#FFC1C1";
		document.getElementById(clave).focus();
		alert('Invalido');
	}
}

function confirmarClave(camp){
	var sigue = false;
	var c1 = document.getElementById('c1').value;
	var c2 = document.getElementById(camp).value;
	if(c2 == c1){
		document.getElementById('c1').style.background = "#BBFFFF";
		document.getElementById(camp).style.background = "#BBFFFF";
	}else {
		document.getElementById('c1').value = '';
		document.getElementById(camp).value = '';
		document.getElementById('c1').style.background = "#FFC1C1";
		document.getElementById('c1').focus();
		alert('La claves no coinciden');
	}
}
function validarLista(lista){
	var sigue = false;
	var indice = document.getElementById(lista).selectedIndex;
	if( indice == null || indice == 0 ){
		document.getElementById(lista).focus();
		alert('Seleccion requerida');
	}
}

function Submit_seguro(formulario) {  
    for(i=1; i < formulario.elements.length; i++){
		if (formulario.elements[i].type == 'submit'){
			formulario.elements[i].disabled = true;
		}
	}
	formulario.submit();
	Submit_seguro = Submit_off  
    return false  
}  

function Submit_off(formulario){  
    return false  
}

function llamaValidadorSubmit(){
	document.getElementById('nivel').onblur(validarNewUser());
}

function validarNewUser(){
	var Nombre = document.newUser.nombre.value;
	var Apellido = document.newUser.apellido.value;
	var Correo = document.newUser.correo.value;
	var Telefono = document.newUser.telefono.value;
	var Usuario = document.newUser.usuario.value;
	var C1 = document.newUser.c1.value;
	var C2 = document.newUser.c2.vaue;
	var DB = document.newUser.db.value;
	var Tipo = document.newUser.tipo.value;
	var Linea = document.newUser.linea.value;
	var Nivel = document.newUser.nivel.value;
	
	if(Nombre == '' || Apellido == '' || Correo == '' || Telefono == '' || Usuario == '' || C1 == '' || C2 == '' || DB == 0 || Tipo == 0 || Linea == 0 || Nivel == 0){
		alert('Todos los campos son requeridos');
	}else {
		document.newUser.enviar.disabled = false;
	}
}