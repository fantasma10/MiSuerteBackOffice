<div id="divUbicacion" class="divUbicacion">
	<table cellpadding="0" cellspacing="3">
    	<tr>
            <?php if(isset($_SESSION['Permisos'])){ ?>
            <td><?php echo $_SESSION['Permisos']['Descripcion'][$posicionPermiso]; ?></td>
            <?php } ?>
            <td style="width:20px"> > </td>
            <td><a href="Listado.php" class="SubMenuA"><?php echo (isset($submenuTitulo))?$submenuTitulo:'Listado'; ?></a></td>
            <td style="width:20px"> > </td>
            <td><div id="Ubicacion" class="Ubicacion"><?php echo (isset($UbicacionSubM))?$UbicacionSubM:'Edicion'; ?></div></td>
            
            <!--
             <?php if(isset($_SESSION['Permisos'])){ ?>
            <td style="width:10px"> / </td>
            <td style="min-width:100px"><a href="Listado.php" class="SubMenuA"><strong><?php echo (isset($submenuTitulo))?$submenuTitulo:'Listado'; ?></strong></a></td>
            <?php }else{ ?>
            <td style="width:10px"> / </td>
            <td style="min-width:100px"><a href="Listado.php" class="SubMenuA"><strong><?php echo (isset($submenuTitulo))?$submenuTitulo:'Listado'; ?></strong></a></td>
            <td style="width:10px"> / </td>
            <td style="min-width:100px"><div id="Ubicacion" class="Ubicacion"><strong><?php echo (isset($UbicacionSubM))?$UbicacionSubM:'Edicion'; ?></strong></div></td>
            <?php } ?>
            
            
            <?php if(isset($UbicacionSubM) && isset($_SESSION['Permisos'])){ ?>
            <td style="width:10px"> / </td>
            <td style="min-width:100px"><div id="Ubicacion" class="Ubicacion"><strong><?php echo (isset($UbicacionSubM))?$UbicacionSubM:'Edicion'; ?></strong></div></td>
            <?php } ?>
            -->
        </tr>
    </table>
</div>