<?php

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Empaque</title>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
<link rel="stylesheet" href="assest/screen.css" type="text/css" media="screen, projection"> 
<link rel="stylesheet" href="assest/default.css" type="text/css" media="screen, projection">
<link rel="stylesheet" href="assest/print.css" type="text/css" media="print"> 
<link type="text/css" rel="stylesheet" href="assest/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"/>
<script type="text/javascript" src="assest/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>
<script   type="text/javascript" src="assest/Js/Botones.js"></script>
	
<script language="javascript" src="abm_iniciador_js.js" type="text/javascript"></script>

<script   type="text/javascript" src="Js/validacionesDeEntrada.js"></script>
<script   type="text/javascript" src="Js/ajax.js"></script>
</head>

<body id="fondo"  >
<div class="container">
<h3>área</h3>
<label class="span-3">Fecha: </label> 
                                          <input type="text" id="fecha" name="fecha" class="top" />
                                          <button type="button" onClick="displayCalendar(fecha,'dd/mm/yyyy',this);return false;" >
            <img src="./assest/plugins/buttons/icons/calendar.png" width="20" height="20" ></button>
                                             <img src="./assest/plugins/buttons/icons/calendar.png" class="top" onClick="displayCalendar(fecha,'dd/mm/yyyy',this);return false;">
                                          
        
</div>
</body>
</html>
