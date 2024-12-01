<?php

	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	include("../../../inc/config.inc.php");

	$idCorresponsal = (!empty($_POST['idCorresponsal']))? $_POST['idCorresponsal'] : 0;

?>
	<select name='ddlBanco' id="ddlBanco" style='width: 200px;'  class="form-control m-bot15">
		<option value='-1'>Seleccione</option>
		<?php
			$sql = $RBD->query("CALL `redefectiva`.`SP_LOAD_CORRESPONSALIAS`($idCorresponsal)");
			while($row = mysqli_fetch_assoc($sql)){
				echo "<option value='".$row['idBanco']."'>".utf8_encode($row['descBanco'])."</option>";
			}
		?>
	</select>