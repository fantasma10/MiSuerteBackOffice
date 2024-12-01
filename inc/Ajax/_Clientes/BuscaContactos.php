<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

if(!isset($_SESSION['Permisos'])){
	header("Location: ../../../logout.php"); 
    exit(); 
}

$idPermiso 	= (isset($_SESSION['Permisos']['Tipo'][0]))?$_SESSION['Permisos']['Tipo'][0]:1;

$id			= (isset($_POST['id']))?$_POST['id']: -2;
$nombre		= (isset($_POST['nombre']))?$_POST['nombre']: -2;
$correo		= (isset($_POST['correo']))?$_POST['correo']: -2;
$tel		= (isset($_POST['tel']))?$_POST['tel']: -2;

$tipoContac	= (isset($_POST['tipoContac']))?$_POST['tipoContac']: 1;

$status		= (isset($_POST['status']))?$_POST['status']:1;


$AND = "";
if($id > -2)
	$AND .= " AND `idContacto` = ".$id;

if($nombre > -2)
	$AND .= " AND `nombreContacto` Like '%".$nombre."%'";

	
if( $tel > -2)
	$AND .= " AND `telefono1` = '".$tel."'";

if($correo > -2)
	$AND .= " AND `correoContacto` = '".$correo."'";

if($id != -3){
	
global $RBD;
	   
$cant = 10;
$funcion = "BuscarAccesos";
$sqlcount = "SELECT  COUNT(`idContacto`)
				FROM  `redefectiva`.`dat_contacto` 
				WHERE  `idcTipoContacto` = $tipoContac
				$AND;";
echo $sqlcount."<br />";
include("../actualpaginacion.php");


$SQL = "SELECT  `idContacto`,`idcTipoContacto`,`nombreContacto`,`apPaternoContacto`,`apMaternoContacto`,`telefono1`,`correoContacto` 
		FROM  `redefectiva`.`dat_contacto` 
		WHERE  `idcTipoContacto` = $tipoContac
		$AND;";	
echo $SQL;						
$Result = $RBD->query($SQL);
if($RBD->error() == ''){

$SQL2 = "SELECT  `idContacto`,`idcTipoContacto`,`nombreContacto`,`apPaternoContacto`,`apMaternoContacto`,`telefono1`,`correoContacto`,`descContacto` 
		FROM  `redefectiva`.`dat_precontacto` 
		WHERE  `idcTipoContacto` = $tipoContac
		$AND;";	
//echo $SQL2;						
$Result2 = $RBD->query($SQL2);
if($RBD->error() == ''){

	if((mysqli_num_rows($Result) > 0 || mysqli_num_rows($Result2) > 0 )){
	?>
	
	<table id="ordertabla" class="tablesorter" border="0"  cellpadding="0" cellspacing="1">
		<thead>
			<tr>
			<th class="header headerSortDown">Nombre</th>
			<th class="header">Telefono</th>
			<th class="header">Correo</th>
	
			</tr>
		</thead>
		<tbody>
			<?php 
				if(mysqli_num_rows($Result) > 0){
				while(list($id,$idTipo,$Nombre,$Apaterno,$Amaterno,$tel,$correo)=mysqli_fetch_array($Result))
				{
			?>
				<tr>
						  <td><div align="left"><?php echo $Nombre.' '.$Apaterno.' '.$Amaterno; ?></div></td>
						  <td><div align="left"><?php echo $tel; ?></div></td>
						  <td><div align="left"><?php echo $correo; ?></div></td>
					<!--?php if($idPermiso == 0){ ?-->
						
                        <td><div align="center"><a onclick="AsignarContacto(<?php echo '0,'.$id.','.$idTipo.','.$Nombre.','.$Apaterno.','.Amaterno.','.tel.','.$correo.',|'; ?>)">Asignar Contacto</a></div></td>
                        
					<!--?php }?-->
				  </tr>
			<?php }}
				if(mysqli_num_rows($Result2) > 0){
				while(list($id2,$idTipo2,$Nombre2,$Apaterno2,$Amaterno2,$tel2,$correo2,$desc2)=mysqli_fetch_array($Result2))
				{
			?>
				<tr>
						  <td><div align="left"><?php echo $Nombre2.' '.$Apaterno2.' '.$Amaterno2; ?></div></td>
						  <td><div align="left"><?php echo $tel2; ?></div></td>
						  <td><div align="left"><?php echo $correo2; ?></div></td>
					<!--?php if($idPermiso == 0){ ?-->
						
                        <td><div align="center"><a onclick="AsignarContacto(<?php echo '1,'.$id2.','.$idTipo2.','.$Nombre2.','.$Apaterno2.','.Amaterno2.','.tel2.','.$correo2.','.$desc2.'|'; ?>)">Asignar Contacto</a></div></td>
                        
					<!--?php }?-->
				  </tr>
            
            <?php }} ?>
		</tbody>
	</table>
	
	<table align='center'><tr><td>
		<?php include("../paginanavegacion.php"); ?>
	</td></tr></table>
	
    
	<?php }else{ ?>
    
		
        <table align="center">
        	<tr align="left">
            	<td>
                	<label class="NoRows">No se encontraron registros Crear?????</label>
                </td>
            </tr>
            <tr align="center">
            	<td>
                	<input type="button" id="CrearContacto" name="CrearContacto" value="Crear Contacto" class="button" onclick="FormCrearContacto()"/>
                </td> 
            </tr>
        </table>
	<?php }?>
    
<?php }else{ ?>
    <label>Ocurrio un error: <?php echo $RBD->error(); ?></label>
<?php }?>      
    
<?php }else{ ?>
    <label>Ocurrio un error: <?php echo $RBD->error(); ?></label>
<?php }?>

<?php }else{ ?>
    
		
        <table align="center">
        	<tr align="left">
            	<td>
                	<label class="NoRows">No se encontraron registros Crear?????</label>
                </td>
            </tr>
            <tr align="center">
            	<td>
                	<input type="button" id="CrearContacto" name="CrearContacto" value="Crear Contacto" class="button" onclick="FormCrearContacto()"/>
                </td> 
            </tr>
        </table>
	<?php }?>