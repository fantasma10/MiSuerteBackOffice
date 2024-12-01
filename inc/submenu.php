

<div id="divUbicacion" class="divUbicacion">
	<table cellpadding="0" cellspacing="3">
    	<tr>
            <?php if(isset($_SESSION['Permisos'])){ ?>
            <td><?php echo $_SESSION['Permisos']['Descripcion'][$posicionPermiso]; ?></td>
            <?php 
			}
			if(isset($extra)){
			if(isset($subsubmenuTitulo)){
				if(isset($extra)){
				?>
					<td style="width:20px" align="center"> <img src="<?php echo $ROOT ?>/img/img_bread_crumb.png" width="10" height="27" /> </td>
					<td><?php echo $extra; ?></td>
				<?php
				} 
				if(isset($submenuTitulo)){
			 	?>
             
           		<td style="width:20px" align="center"> <img src="<?php echo $ROOT ?>/img/img_bread_crumb.png" width="10" height="27" /> </td>
            	<td><?php echo $submenuTitulo; ?></td>
             	<?php 
				}
					
				?>                
            <td style="width:20px" align="center"> <img src="<?php echo $ROOT ?>/img/img_bread_crumb.png" width="10" height="27" /> </td>
            <td><div id="Ubicacion" class="Ubicacion"><?php echo $subsubmenuTitulo; ?></div></td>
             
            <?php
			}
			}elseif(isset($subsubmenuTitulo)){
				if(isset($submenuTitulo)){
			 	?>
             
           		<td style="width:20px" align="center"> <img src="<?php echo $ROOT ?>/img/img_bread_crumb.png" width="10" height="27" /> </td>
            	<td><?php echo $submenuTitulo; ?></td>
             	<?php 
				}
					
				?>                
            <td style="width:20px" align="center"> <img src="<?php echo $ROOT ?>/img/img_bread_crumb.png" width="10" height="27" /> </td>
            <td><div id="Ubicacion" class="Ubicacion"><?php echo $subsubmenuTitulo; ?></div></td>
             <?php 
			}elseif(isset($submenuTitulo)){
			 ?>
             
            <td style="width:20px" align="center"> <img src="<?php echo $ROOT ?>/img/img_bread_crumb.png" width="10" height="27" /> </td>
            <td><div id="Ubicacion" class="Ubicacion"><?php echo $submenuTitulo; ?></div></td>
            
           
            <?php
			} 
			?>
        </tr>
    </table>
</div>