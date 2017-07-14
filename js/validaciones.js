// JavaScript Document validaciones ingreso
// Validar Formulario
//Valida Cedula
function validarCedula(objC){
	var cedula = document.getElementById(objC).value;
	if(/([\d]{7,8})/.test(cedula)){
		document.getElementById(objC).style.background = "#D5FFE2";
		document.getElementById(objC).style.color = '#000000';
		
	}else {
		document.getElementById(objC).style.background = "#FFCC00";
		document.getElementById(objC).style.color = '#000000';
		
	}
}

//Validar campos de nombrees
function validarInputName(a){
	var campo = document.getElementById(a).value;
	if(/[a-zA-Z0-9\s]{4,}?/.test(campo)){
		document.getElementById(a).style.background = "#D5FFE2";
		document.getElementById(a).style.color = '#000000';
		
	}else {
		document.getElementById(a).style.background = "#FFCC00";
		document.getElementById(a).style.color = '#000000';
		
	}
}


// Validar BL
function validarBL(bl){
	var campo = document.getElementById(bl).value;
	if(/^([0-9a-zA-Z]{6,25})$/.test(campo)){
		document.getElementById(bl).style.background = "#D5FFE2";
		document.getElementById(bl).style.color = '#000000';
		
	}else {
		document.getElementById(bl).style.background = "#FFCC00";
		document.getElementById(bl).style.color = '#000000';
		
	}
}

// Validar campos vacios de Nombres
function validaCampob(b){
	var campob = document.getElementById(b).value;
	if(/([\w]{7})/.test(campob)){
		document.getElementById(b).style.background = "#D5FFE2";
		document.getElementById(b).style.color = '#000000';
		
	}else {
		document.getElementById(b).style.background = "#FFCC00";
		document.getElementById(b).style.color = '#000000';
		
	}
}

//Validacion contenedor, Logitud, 4to caracter y digito de chequeo
function validarContenedor(obj, val){
	var tabla = "A10*B12*C13*D14*E15*F16*G17*H18*I19*J20*K21*L23*M24*N25*O26*P27*Q28*R29*S30*T31*U32*V34*W35*X36*Y37*Z38";
	var Nroequipo = document.getElementById(obj).value;
	var NroequipoM = Nroequipo.toUpperCase();
	var tamano = NroequipoM.length;
	var charter11 = NroequipoM.substring(10,11);
	var objContenedor = obj;
	var valContenedor = val;
	var charter4 = NroequipoM.substring(3,4);
	
	//Validar Campo con 11 caracteres
	if(/[\w]{11}/.test(valContenedor)){
		//Validar 4to Caracter
		if(/(u|U)/.test(charter4)){
			//Validar Formato del Numero y Digito de Chequeo
			if(/^([a-zA-Z]{3})([u|U]{1})([0-9]{7})$/.test(valContenedor)){
				verfak = new Array (10);
				for (var a = 0; a <= 3; a++){
					var waaro = NroequipoM.charAt(a);
					var welke = tabla.indexOf(waaro);
					verfak[a] = tabla.substring(welke+1, welke+3);
				}
				for (var b = 4; b < 10; b++){
					verfak[b] = NroequipoM.charAt(b);
				}
				var totaal = 0;
				for (var c = 0; c < 10; c++){
					var vermeniging = verfak[c] * Math.pow(2,c);
					var totaal = totaal + vermeniging;
				}
				if (totaal){
					var geheel = totaal / 11;
					var afgerond = Math.floor(geheel);
					var verschil = geheel - afgerond;
					checkdigit = Math.round(verschil*11);
					
					document.getElementById('validacion').value = checkdigit;
					document.getElementById('validacion').style.background = "#D5FFE2";
					document.getElementById('validacion').style.color = '#000000';
					
					if(charter11 == checkdigit){
						document.getElementById(objContenedor).style.background = "#D5FFE2";
						document.getElementById(objContenedor).style.color = '#000000';
						}else {
							document.getElementById(objContenedor).style.background = "#FFCC00";
							document.getElementById(objContenedor).style.color = '#000000';
						}
				}
			}else {
				document.getElementById(objContenedor).style.color="#000000";
			}
			//Fin Validar Formato del Numero
		}else {
			document.getElementById(objContenedor).style.background = "#FFCC00";
			document.getElementById(objContenedor).style.color = '#000000';
		}
		//Fin Validar 4to Caracter
	}else {
		document.getElementById(objContenedor).value = "";
		document.getElementById(objContenedor).style.background = "#FFCC00";
		document.getElementById(objContenedor).style.color = '#000000';
	}
}

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

function validaeir(c){
	var campoc = document.getElementById(c).value;
	var numeros = "0123456789";
	if(/([0-9]{4,6})/.test(campoc)){
		document.getElementById(c).style.background = "#D5FFE2";
		document.getElementById(c).style.color = '#000000';
		
	}else {
		document.getElementById(c).style.background = "#FFCC00";
		document.getElementById(c).style.color = '#000000';
		
	}
}

//Tipo de menu
function validaMenu(m){
	var nombreMenu = document.getElementById(m).name;
	var dato = document.getElementById(m).value;
	if(dato > 0){
		document.getElementById('enviar').disabled = false;
		return true;
	}else if(dato == '-1'){
		document.getElementById('enviar').disabled = false;
	}else {
		alert("El menu de selection " + nombreMenu + " no puede estar vacio.");
		document.getElementById('enviar').disabled = false;
	}
}

//Validar que la fecha sea menor o igual que la actual de ingreso
function validaFecha(f){
	
	var strfecha = document.getElementById(f).value;
	var strAno = strfecha.substring(0,4);
	var strMes = strfecha.substring(5,7) - 1;
	var strDia = strfecha.substring(8,10);
	var fechaform = new Date(strAno, strMes, strDia);
	var fecha = new Date();
	
	if(fechaform > fecha){
		alert("No esta permitido realizar ingreso con una fecha mayor a la actual");
		document.getElementById(f).style.background = "#FFCC00";
		document.getElementById(f).style.color = '#000000';
		document.getElementById(f).value = strfecha;
		
	}else {
		document.getElementById(f).style.background = "#D5FFE2";
		document.getElementById(f).style.color = '#000000';
	}
}
//Validar fecha de despacho (No se permite una fecha de menor a 2 dias ni mayor al dia actual
function fechadespacho(fd){
	var strfdesp = document.getElementById(fd).value;
	var strAnofd = strfdesp.substring(0,4);
	var strMesfd = strfdesp.substring(5,7) - 1;
	var strDiafd = strfdesp.substring(8,10);
	var fechaForm = new Date(strAnofd,strMesfd,strDiafd);
	var fechaActual = new Date();
	var diff = fechaActual.getDate() - fechaForm.getDate();
	
	if(fechaForm > fechaActual){
		alert("No esta permitido realizar un devolucion con fecha futura");
		document.getElementById(fd).style.background = "#FFCC00";
		document.getElementById(fd).style.color = '#000000';
		document.getElementById(fd).value = strfdesp;
	}else if(fechaForm < fechaActual){
			if(diff > 1){
				alert("No esta permitido realizar un devolucion con fecha anterior a un (1) dia" + diff);
				document.getElementById(fd).style.background = "#FFCC00";
				document.getElementById(fd).style.color = '#000000';
				document.getElementById(fd).value = strfdesp;
			}else {
				document.getElementById(fd).style.background = "#D5FFE2";
				document.getElementById(fd).style.color = '#000000';
			}
	}else {
		document.getElementById(fd).style.background = "#D5FFE2";
		document.getElementById(fd).style.color = '#000000';
	}
}