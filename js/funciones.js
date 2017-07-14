// JavaScript Document
//funciones javascript
function validarContenedorM(obj, val){
	var alfabet = "A10*B12*C13*D14*E15*F16*G17*H18*I19*J20*K21*L23*M24*N25*O26*P27*Q28*R29*S30*T31*U32*V34*W35*X36*Y37*Z38";
	var invoer = document.getElementById(obj).value;
	var hinvoer = invoer.toUpperCase();
	var lange = invoer.length;
	var c11 = hinvoer.substring(10,11);
	var objContenedor = obj;
	var valContenedor = val;
	var c4 = hinvoer.substring(3,4);
	<!--Validar Formato del Numero inicio
	if(/(^[A-Z]{4})([0-9]{7})$/.test(hinvoer)){
		document.getElementById(objContenedor).style.color="#008B00";
	}else {
		document.getElementById(objContenedor).style.color="#FF0000";
		setTimeout(answer=prompt("ERROR\nFormato del Numero incorrecto",valContenedor),100);
		if(answer != valContenedor){
			document.getElementById(objContenedor).value = answer;
			document.body.style.backgroundColor='#FFFFFF';
			document.getElementById(objContenedor).style.color="#008B00";
		}
	}
		<!--Validar Formato del Numero fin
	if (lange > 11){
		document.getElementById(objContenedor).style.color="#FF0000";
		<!--nietgoed("tekort");
	}else{
		verfak = new Array (10);
		for (var a = 0; a <= 3; a++){
			var waaro = hinvoer.charAt(a);
			var welke = alfabet.indexOf(waaro);
			verfak[a] = alfabet.substring(welke+1, welke+3);
		}
		for (var b = 4; b < 10; b++){
			verfak[b] = hinvoer.charAt(b);
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
			//document.formInsert.digit.value = checkdigit;
			if(checkdigit != c11){
				document.getElementById(objContenedor).style.color="#996600";
				//setTimeout(answer=prompt("ERROR\nDigito de Chequeo errado\nEl correcto es: " + checkdigit,valContenedor),100);
				alert("Digito de Chequeo errado\nUd., indico " + c11 + " y el correcto es: " + checkdigit);
			}
		}else{
			document.getElementById(obj).style.color="#FF0000";
			error();
		}
	}
} 
function error(msj){
	if(msj == "maxchart"){
		alert ('ERROR \n Debe ser un Numero de 11 caracteres.');
	}else {
		alert ('La calculadora no puedo resolver el Digito de Chequeo.\nPor favor verifique su numero e intente de nuevo.');
	}
}
//validar eir
function validarEir(objE, valE){
	var objEIR = objE;
	var valEIR = valE;
	if(/^[\d]{5,6}$/.test(valEIR)){
		document.getElementById(objEIR).style.color="#008B00";
		document.body.style.backgroundColor='#FFFFFF';
	}else {
		document.getElementById(objEIR).style.color="#FF0000";
		document.body.style.backgroundColor='#FFFF00';
		document.getElementById(objEIR).select();
		document.getElementById(objEIR).focus();
		setTimeout(answer=prompt("Indique el numero de EIR Correcto",valEIR),100);
		if(answer != valEIR){
			document.getElementById(objEIR).value = answer;
			document.body.style.backgroundColor='#FFFFFF';
			document.getElementById(objEIR).style.color="#008B00";
		}
	}
}

//Validar contraseñas
function clave(val1,val2,b){
	var p1 = val1.value;
	var p2 = val2.value;
	var boton = b;
	var espacios = false;
	var cont = 0;
	
	while (!espacios && (cont < p1.length)){
		if (p1.charAt(cont) == " ")
		espacios = true;
		cont++;
	}
	
	if (espacios){
		b.disabled = true;
		alert ("La contraseña no puede contener espacios en blanco");
		return false;
	}
	
	if (p1.length == 0 || p2.length == 0){
		b.disabled = true;
		alert("Los campos de la password no pueden quedar vacios");
		return false;
	}
	
	if (p1 != p2){
		b.disabled = true;
		alert("Las passwords deben de coincidir");
		return false;
	}else{
		if(p1.length > 5 || p2.length > 5){
			b.disabled = false;
			return true;
		}else{
			b.disabled = true;
			alert("Las passwords deben tener al menos 6 caracteres");
			return false;
		}
		b.disabled = false;
		return true; 
	}
}

//No enter
function Noenter(){
	document.onkeypress = KeyPressed;
	function KeyPressed(e){
		return ((window.event) ? event.keyCode : e.keyCode) != 13;
	}
}