<?php 
include("../../inc/config.inc.php");
include("../../inc/session.inc.php");

$posicionPermiso = 4;
$submenuTitulo = "Usuarios";
$UbicacionSubM = "Nuevo Usuario";

$idPermiso = (isset($_SESSION['Permisos']['Tipo'][4]))?$_SESSION['Permisos']['Tipo'][4]:1;
if($idPermiso == 1){
	header("Location: Listado.php"); 
    exit(); 
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Creando Usuario</title>

<link href="../../css/bootstrap.css" rel="stylesheet">
<link href="../../css/tm_docs.css" rel="stylesheet">
<script src="../../inc/js/jquery.cookie.js" type="text/javascript"></script>

<link href="../../css/SAC.css" rel="stylesheet" type="text/css" />
</head>
<script src="../../inc/js/jquery.js" type="text/javascript"></script>
<script src="../../inc/js/menu.js" type="text/javascript"></script>
<script src="../../inc/js/RE.js" type="text/javascript"></script>
<script src="../../inc/js/_Admin.js" type="text/javascript"></script>
<script language="javascript">
function CheckBoxAction(a, b)
{
	alert(a);
	alert(b);
}
</script>
<body>
<br />
	<?php include("../../inc/submenu2.php") ?>
<br />

<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center">
    	<p align="center">
      	<form action="Listado.php" method="post">  
            <input type="submit" id="Regresar" value="Regresar"/>
        </form>        
      </p>
      <p align="center" class="Titulo1">Creando Usuario</p>
    </div></td>
  </tr>
</table>
<br />
<table width="550" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="BorderShadow2 CornerRadius">
  <tr>
    <td><br />
    <table width="420" border="0" align="center" cellpadding="0" cellspacing="15">    
      <tr>
        <td style="width:150px"><strong>Nombre</strong></td>
        <td style="width:20px">&nbsp;</td>
        <td style="width:200px"><input type="text" id="txtNombre" name="txtNombre" value="" class="ctrls"/></td>
      </tr>
      <tr>
        <td><strong>Apellido Paterno</strong></td>
        <td>&nbsp;</td>
        <td><input type="text" id="txtApellidoP" name="txtApellidoP" value="" class="ctrls"/></td>
      </tr>
     <tr>
        <td><strong>Apellido Materno</strong></td>
        <td>&nbsp;</td>
        <td><input type="text" id="txtApellidoM" name="txtApellidoM" value="" class="ctrls"/></td>
      </tr>
     <tr>
        <td><strong>Correo</strong></td>
        <td>&nbsp;</td>
        <td><input type="text" id="txtCorreo" name="txtCorreo" value="" class="ctrls"/></td>
      </tr>
       <tr>
        <td><strong>Tipo de Perfil</strong></td>
        <td>&nbsp;</td>
        <td>
        	<?php 
				global $RBD;
				$res = null;
				$sql = "select idPerfil,descPerfil from `data_acceso`.`in_dat_perfilad` WHERE `statusPerfil` = 0;";
				$res = $RBD->query($sql);
				if($res != null){
					$d = "<select id='ddlTipo' style='width:100%'>";
					while($r = mysqli_fetch_array($res)){
							$d.="<option value='".$r['idPerfil']."'>".$r['descPerfil']."</option>";
					}
					$d.="</select>";
					echo $d;
				}
			?>
        </td>
      </tr>
      <tr>
      	<td colspan="3">&nbsp;</td>
      </tr>
      <tr>
      	<td align="center" colspan="3">
        	<input type="button" id="btnCrear" name="btnCrear" value="Crear Usuario" onclick="NewUsuario();"/>
        </td>
      </tr>
    </table>
      <p>&nbsp;</p>    </td>
  </tr>
</table>
</body>
<?php $RBD->close(); ?>
</html>
