<html>
<head>
<title>usuario y/o password no valido </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body onLoad="error()">
<form name="no_login" action="index.php">
</form>
</body>
</html>
<script>
function error() // EN CASO DE USUARIO Y/O PASS INCORRECTO 
	{
	 alert("Usuario y/o Password Invalidos")
	 document.no_login.submit();
	}

</script>