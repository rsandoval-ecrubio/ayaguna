<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AYAGUNA</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #FFF;
}
body,td,th {
	font-family: Calibri, "Calibri Bold Caps";
	font-size: 12px;
	color: #333;
}
h1 {
	font-size: 20px;
	color: #E8EBEF;
}
h2 {
	font-size: 18px;
}
h3 {
	font-size: 14px;
}
h4 {
	font-size: 12px;
}
h5 {
	font-size: 10px;
}
h6 {
	font-size: 9px;
}
.header {
	height: 60px;
	width: 100%;
	background-color: #66C;
	margin-top: 0px;
}
.titulo {
	float: left;
	width: 400px;
	padding: 3px;
	margin-left: 8px;
	height: 20px;
	margin-top: 10px;
	margin-right: auto;
	margin-bottom: auto;
	font-size: 18px;
	color: #FFF;
	font-weight: bold;
	border-bottom-width: 2px;
	border-bottom-style: solid;
	border-bottom-color: #CCC;
}
.reloj {
	float: right;
	width: 200px;
	padding: 1px;
	margin-top: 10px;
	margin-right: 10px;
	color: #FFF;
}
.usuario {
	padding: 2px;
	width: 200px;
	float: right;
	margin-right: 10px;
	margin-bottom: auto;
	margin-left: auto;
	font-weight: bold;
	clear: right;
	margin-top: 5px;
	color: #FFF;
}
</style>
</head>

<body onload="KW_doClock()">
<div class="header" id="header">
  <div class="titulo" id="titulo">AYAGUNA | Control de Contenedores</div>
<div class="reloj" id="clock"><script language='JavaScript'>
// Kaosweaver Live Clock Start
function class_clock(f,s,c,b,w,h,d,m,g,z) { // Copyright 2002 by Kaosweaver, All rights reserved
	this.b=b;this.w=w;this.h=h;this.d=d;this.g=g;this.z=z
	this.o='<font style="color:'+c+'; font-family:'+f+'; font-size:'+s+'pt;">';
if (m==1) this.o+=0
}
var clock=new class_clock("Verdana, Geneva, sans-serif","12","#000000","#FFFFFF","84",1,1,0,0,0)
// If the clock's size needs adjusting, change the 84 above.
d=document
if (d.all || d.getElementById) {d.write('<span id="activeClock" style="width:'+clock.w+'px; "></span>'); }
else if (d.layers) {d.write('<ilayer  id="wrapClock"><layer width="'+clock.w+'" id="activeClock"></layer></ilayer>'); }
else {KW_doClock(1);}
function KW_doClock(a) { // Copyright 2003 by Kaosweaver, All rights reserved
	d=document;t=new Date();p="";dClock="";	if (d.layers) d.wrapClock.visibility="show";
	tD=(t.getTimezoneOffset()-(clock.z*60))*clock.g;t.setMinutes(tD+t.getMinutes())
	h=t.getHours();m=t.getMinutes();s=t.getSeconds();if (clock.h)
	 {p=(h>11)?"PM":"AM";h=(h>12)?h-12:h;h=(h==0)?12:h;}if (clock.d)
	 {m=(m<=9)?"0"+m:m; s=(s<=9)?"0"+s:s;} dClock = clock.o+h+':'+m+':'+s+' '+p+'</font>';
	if (a) {d.write(dClock);}if (d.layers) {wc = document.wrapClock;lc = wc.document.activeClock;
		lc.document.write(dClock);lc.document.close();
	} else if (d.all) {	activeClock.innerHTML = dClock;
	} else if (d.getElementById) {d.getElementById("activeClock").innerHTML = dClock;}
	if (!a) setTimeout("KW_doClock()",1000);
}

// Kaosweaver Live Clock End
      </script>
      <!-- KW Live Clock -->
    </div>
    <div class="usuario" id="usuario">Usuario: <?php echo $_SESSION['variables']['nombreUsuario']." ".$_SESSION['variables']['apellidoUsuario']; ?></div>
</div>
</body>
</html>