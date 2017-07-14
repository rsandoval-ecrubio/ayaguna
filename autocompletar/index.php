<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>autocompletar</title>


<link href="autocompletar.css" rel="stylesheet" type="text/css" />

<script src="autocompletar.js" type="text/javascript"></script>
</head>

<body>
    <div style="float: left;">
    
    <!-- este div contendrá el listado de coincidencias -->
    <div id="opciones"></div>
    <!-- este input contendra el criterio a buscar en autocompletado -->
    <input id="serial" name="serial" type="search" class="criterio" onkeyup="javascript:autocompletar()" />
    
    
    
    </div>
    
    <!-- botón de búsqueda -->
    <input type="submit" value="Buscar" />
    
</body>

</html>
