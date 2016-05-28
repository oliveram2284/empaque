<?php
session_start();
session_destroy();

require("header.php");
?>


<body id="fondo">

<br />
<div class="container">
  <div class="well" style="min-height: 90%">
  <form name="index" action="func_php.php" method="post" onSubmit="return valida()">
    <br><br><br><br>
    <div style=" width: 320px; background: #F0F0F0; border-radius: 10px 10px 10px 10px; -moz-border-radius: 10px 10px 10px 10px; -webkit-border-radius: 10px 10px 10px 10px; border: 1px solid #04B431; box-shadow: 20px 20px 45px rgba(0, 0, 0, 0.99); -moz-box-shadow: 20px 20px 45px rgba(0, 0, 0, 0.99); -webkit-box-shadow: 20px 20px 45px rgba(0, 0, 0, 0.99);">
      <br>
      <table>
	<tr>
	  <td><img src="logo-V2.png" width="200" height="150" /><br><br><br></td>
	</tr>
	<tr>
	  <td><input type="text" name="user" id="user" placeholder="Nombre de Usuario" /></td>
	</tr>
	<tr>
	  <td><input type="password" name="pass" id="pass" placeholder="Constraseña" /></td>
	</tr>
	<tr>
	  <td style="text-align: center"><input type="submit" value="Ingresar" class="btn btn-success" /></td>
	</tr>
      </table>
      <br>
      <br>
	<input type="hidden" name="oper" value="V"/>

    </div>


  </form>
  </div>
</div>
<br>
<br>
<br>


<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
</div>

</body>
<?php
require("header.php");
?>