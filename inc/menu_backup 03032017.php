<!--Menú en la Barra Vertical Izquierda-->
<?php
	$directorio = $_SERVER['HTTP_HOST'];
	$PATHRAIZ = "https://".$directorio;
	$dir = $PATHRAIZ."/main.php";
?>
<aside>
<div id="sidebar"  class="nav-collapse">
<ul class="sidebar-menu" id="nav-accordion">
<!--Inicio-->
<li class="sub-menu"><a href="<?php echo $dir;?>"><i class="fa fa-globe"></i><span>INICIO</span></a></li>
<!--Clientes-->
<?php if ( mostrarMenu(1) ) { ?>
<li class="sub-menu">
	<a href="#"><i class="fa fa-group"></i><span>CLIENTES</span></a>
<?php } ?>
	<ul class="sub">
		<?php if( mostrarSubmenu(1000) || mostrarSubmenu(1000) ) { ?>
		<li class="sub-menu">
			<a href="javascript:;">Afiliación Express</a>
			<ul class="sub">
				<?php if( mostrarOpcion(60) ) { ?>
				<li><a  href="<?php echo $ROOT; ?>/_Clientes/Afiliaciones/newuser.php">Nuevo Cliente</a></li>
				<?php } ?>
				<?php if( mostrarOpcion(63) ) { ?>
				<li><a  href="<?php echo $ROOT; ?>/_Clientes/Afiliaciones/nuevasucursal.php">Nueva Sucursal</a></li>
				<?php } ?>
				<?php if( mostrarSubmenu(13) ) { ?>
				<li class="sub-menu"><a  href="#">Consulta</a>
                    <ul class="sub">
				<?php } ?>
						<?php if(mostrarOpcion(61)){ ?>
						<li><a  href="<?php echo $ROOT ?>/_Clientes/Afiliaciones/ConsultaCliente.php">Cliente</a></li>
						<?php } ?>
						<?php if(mostrarOpcion(62)){ ?>
						<li><a  href="<?php echo $ROOT ?>/_Clientes/Afiliaciones/ConsultaSucursal.php">Sucursal</a></li>
						<?php } ?>
					<?php if( mostrarSubmenu(13) ) { ?>
					</ul>
				</li>
				<?php } ?>
			</ul>
		</li>
		<?php } ?>
        <!-- ////////////////////////////////////////////////////////////////////////////-->

        	<?php if( mostrarSubmenu(23) ){ ?>
		<li class="sub-menu">
			<a href="javascript:;">Altas</a>
			<ul class="sub">
				<?php if( mostrarOpcion(129) ) { ?>
				<li><a  href="<?php echo $ROOT; ?>/afiliacion/registroCliente.php">Nuevo Cliente</a></li>
				<?php } ?>
				<?php if( mostrarOpcion(130) ) { ?>
				<li><a  href="<?php echo $ROOT; ?>/afiliacion/registroSucursal.php">Nueva Sucursal</a></li>
				<?php } ?>

			</ul>
		</li>
		<?php } ?>




        <!-- ////////////////////////////////////////////////////////////////////////////-->
             <!-- ////////////////////////////////////////////////////////////////////////////-->


        	<?php if( mostrarSubmenu(24)  ) { ?>
		<li class="sub-menu">
			<a href="javascript:;">Validaciones</a>
			<ul class="sub">
				<?php if( mostrarOpcion(131) ) { ?>
				<li><a  href="<?php echo $ROOT; ?>/afiliacion/autorizacionProspecto.php">Autorizar Cliente</a></li>
				<?php } ?>
				<?php if( mostrarOpcion(132) ) { ?>
				<li><a  href="<?php echo $ROOT; ?>/afiliacion/autorizacionSucursal.php">Autorizar Sucursal</a></li>
				<?php } ?>

			</ul>
		</li>
		<?php } ?>




        <!-- ////////////////////////////////////////////////////////////////////////////-->
		<?php if ( mostrarOpcion(1) ) { ?>
		<li><a href="<?php echo $ROOT ?>/_Clientes/menuConsulta.php">Consulta</a></li>

       	<li><a href="<?php echo $ROOT ?>/_Clientes/Correcciones/Cliente.php">Correcciones Cliente</a></li>
		<li><a href="<?php echo $ROOT ?>/_Clientes/Correcciones/Corresponsal.php">Correcciones Corresponsal</a></li>
		<?php } ?>
        <?php if ( mostrarOpcion(97) ) { ?>
        <li><a href="<?php echo $ROOT ?>/_Clientes/Cuentas/1.php">Cuenta Bancaria</a></li>
        <?php } ?>
        <?php if ( mostrarOpcion(105) ) { ?>
        <li><a href="<?php echo $ROOT ?>/_Clientes/Contratos/EnvioContratos.php">Env&iacute;o de Contratos</a></li>
        <?php } ?>
		<?php if ( mostrarOpcion(1000) ) { ?>
		<li class="sub-menu"><a href="javascript:;">Pre Alta</a>
		<ul class="sub">
			<li class="sub-menu"><a  href="#">Búsqueda</a>
				<ul class="sub">
					<li><a  href="<?php //echo $ROOT ?>/_Clientes/PrealtaBuscarCadenas.php">Cadena</a></li>
					<li><a  href="<?php //echo $ROOT ?>/_Clientes/PrealtaBuscarSubCadenas.php">Sub Cadena</a></li>
					<li><a  href="<?php //echo $ROOT ?>/_Clientes/PrealtaBuscarCorresponsales.php">Corresponsal</a></li>
				</ul>
			</li>
			<li>
				<a  href="<?php //echo $ROOT ?>/_Clientes/menuPrealta.php">Crear</a>
			</li>
			<li>
				<a  href="<?php //echo $ROOT ?>/_Clientes/MenuComisiones.php">Autorizar Comisiones</a>
			</li>
		</ul>
		</li>
		<?php } ?>
		<?php if (mostrarOpcion(95)) {?>
			<li><a  href="/_Clientes/cuentas.php">Administración de cuentas</a></li>
		<?php } ?>
		<li><a  href="/_Clientes/AdministrarCuentas.php">Administración de cuentas</a></li>
	</ul>
<?php if ( mostrarMenu(1) ) { ?>
</li>
<?php } ?>
<!-- Administracion de Equipos -->
<?php if( mostrarMenu(17) ) { ?>
<li class="sub-menu"><a href="javascript:;">
	<i class="fa fa-briefcase"></i><span>ADMINISTRACI&Oacute;N</span></a>
<?php } ?>
<ul class="sub">
<?php if( mostrarSubmenu(21) ) { ?>
	<li class="sub-menu"><a  href="#">Proveedores</a>
		<ul class="sub">
	<?php } ?>
			<?php if(mostrarOpcion(116)){ ?>
			<li><a  href="<?php echo $ROOT ?>/_Proveedores/Telcel/">Telcel</a></li>
			<?php } ?>
		<?php if( mostrarSubmenu(21) ) { ?>
		</ul>
	</li>
	<?php } ?>
<?php if ( mostrarOpcion(96) ) { ?>
<li><a href="<?php echo $ROOT ?>/_Administracion/ActivacionEquipos/Equipos.php">Equipos</a></li>
<?php } ?>
<?php if ( mostrarOpcion(107) ) { ?>
<li><a href="<?php echo $ROOT ?>/_Administracion/Cuentas/CuentaProveedor.php">Cuenta Proveedor</a></li>
<?php } ?>
</ul>
<?php if( mostrarMenu(17) ) { ?>
</li>
<?php } ?>
<!--Operaciones-->
<?php if ( mostrarMenu(2) ) { ?>
<li class="sub-menu">
	<a href="javascript:;"><i class="fa fa-gear"></i><span>OPERACIONES</span></a>
	<ul class="sub">
<?php } ?>
        <?php if( mostrarSubmenu(1) ) { ?>
        <li class="sub-menu"><a href="javascript:;">Monitor</a>
        	<ul class="sub">
        <?php } ?>
        		<?php if ( mostrarOpcion(3) ) { ?>
        		<li><a  href="<?php echo $ROOT ?>/_Operaciones/Monitor/Gral/Listado1.php">General</a></li>
                <?php } ?>
                <?php if ( mostrarOpcion(4) ) { ?>
        		<li><a  href="<?php echo $ROOT ?>/_Operaciones/Monitor/Opera/Listado.php">Detalle</a></li>
                <?php } ?>
                <?php if ( mostrarOpcion(6) ) { ?>
        		<li><a  href="<?php echo $ROOT ?>/_Operaciones/Monitor/Perso/Listado.php">Personalizado</a></li>
                <?php } ?>
        <?php if( mostrarSubmenu(1) ) { ?>
            </ul>
        </li>
        <?php } ?>
        <?php if ( mostrarOpcion(7) ) { ?>
        <li><a href="<?php echo $ROOT ?>/_Operaciones/Incompletas/Listado.php">Incompletas</a></li>
        <?php } ?>
        <?php if ( mostrarOpcion(8) ) { ?>
        <li><a href="<?php echo $ROOT ?>/_Operaciones/Busqueda/Listado.php">Búsqueda</a></li>
        <?php } ?>
        <?php if( mostrarSubmenu(11) ) { ?>
        <li class="sub-menu"><a href="javascript:;">Remesas</a>
        	<ul class="sub">
            	<?php if ( mostrarOpcion(53) ) { ?>
                <li><a href="<?php echo $ROOT ?>/_Operaciones/Remesas/Listado.php">Remesas Pendientes</a></li> <!-- Originalmente se llamaba "Remesas" -->
                <?php } ?>
				<?php if ( mostrarOpcion(54) ) { ?>
                <li><a href="<?php echo $ROOT ?>/_Operaciones/Remesas/Busqueda.php">B&uacute;squeda</a></li>
                <?php } ?>
            </ul>
        </li>
        <?php } ?>
		<?php if ( mostrarOpcion(106) ) { ?>
        <li><a href="<?php echo $ROOT ?>/_Operaciones/Ticket/Reimpresion.php">Re-impresi&oacute;n de Tickets</a></li>
        <?php } ?>
        <?php if ( mostrarOpcion(109) ) { ?>
        <li><a href="<?php echo $ROOT ?>/_Operaciones/Seguimiento/index.php">Seguimiento a Corresponsales</a></li>
        <?php } ?>
<?php if ( mostrarMenu(2) ) { ?>
    </ul>
</li>
<?php } ?>
<!--Reportes-->
<?php if( mostrarMenu(3) ) { ?>
<li class="sub-menu"><a href="javascript:;">
	<i class="fa fa-bar-chart-o"></i><span>REPORTES</span></a>
	<ul class="sub">
<?php } ?>
		<?php if( mostrarSubmenu(2) ) { ?>
		<li class="sub-menu"><a href="javascript:;">Contabilidad</a>
			<ul class="sub">
		<?php } ?>
				<?php if ( mostrarOpcion(11) ) { ?>
				<li><a href="<?php echo $ROOT ?>/_Reportes/Cortes/Listado.php">Corte</a></li>
				<?php } ?>
				<?php if ( mostrarOpcion(12) ) { ?>
				<li><a href="<?php echo $ROOT ?>/_Reportes/Comisiones/Listado.php">Comisiones</a></li>
				<?php } ?>
				<?php if ( mostrarOpcion(13) ) { ?>
				<li><a href="<?php echo $ROOT ?>/_Reportes/Proveedores/Listado.php">Proveedor</a></li>
				<?php } ?>
				<?php if ( mostrarOpcion(14) ) { ?>
				<li><a href="<?php echo $ROOT ?>/_Reportes/Movimientos/Listado.php">Movimientos</a></li>
				<?php } ?><?php if ( mostrarOpcion(14) ) { ?>
				<li><a href="<?php echo $ROOT ?>/_Reportes/Movimientos/Listado.php">Movimientos</a></li>
				<?php } ?>
				<?php if( mostrarOpcion(15) || mostrarOpcion(16) ) { ?>
				<li><a href="conre_depositos.php">Depósitos</a></li>
				<?php } ?>
				<?php if ( mostrarOpcion(17) ) { ?>
				<li><a href="conre_pagos.php">Pagos</a></li>
				<?php } ?>
		<?php if( mostrarSubmenu(2) ) { ?>
			</ul>
		</li>
		<?php } ?>
		<?php if ( mostrarSubmenu(19) ) { ?>
		<li class="sub-menu"><a href="javascript:;">Operaciones</a>
			<ul class="sub">
		<?php } ?>
				<?php if ( mostrarOpcion(10) ) { ?>
				<li><a href="<?php echo $ROOT ?>/_Reportes/Operaciones/Listado.php">General</a></li>
				<?php } ?>
				<?php if ( mostrarOpcion(50) ) { ?>
				<li><a href="<?php echo $ROOT ?>/_Reportes/Operaciones/ReporteGeneral.php">Reporte General</a></li>
				<?php } ?>
				<?php if ( mostrarOpcion(49) ) { ?>
				<li><a href="<?php echo $ROOT ?>/_Reportes/Operaciones/Reactivaciones.php">Reactivaciones</a></li>
				<?php } ?>
		<?php if ( mostrarSubmenu(19) ) { ?>
			</ul>
		</li>
		<?php } ?>
		<?php if( mostrarSubmenu(3) ) { ?>
		<li class="sub-menu"><a href="javascript:;">Comercial</a>
			<ul class="sub">
		<?php } ?>
				<?php if ( mostrarOpcion(18) ) { ?>
				<li><a href="<?php echo $ROOT ?>/_Reportes/Sucursales/Listado.php">Sucursales</a></li>
				<?php } ?>
		<?php if( mostrarSubmenu(3) ) { ?>
			</ul>
		</li>
		<?php } ?>


        <?php if ( mostrarSubmenu(20) ) { ?>
		<li class="sub-menu"><a href="javascript:;">Jurídico</a>
			<ul class="sub">
		<?php } ?>
				<?php if ( mostrarOpcion(111) ) { ?>
				<li><a href="<?php echo $ROOT ?>/_Reportes/Juridico/Remesas.php">Remesas</a></li>
				<?php } ?>
		<?php if ( mostrarSubmenu(20) ) { ?>
			</ul>
		</li>
		<?php } ?>

        <?php if( mostrarSubmenu(18) ){ ?>
        <li class="sub-menu"><a href="javascript:;">Administrativos</a>
        	<ul class="sub">
        <?php } ?>
        	<?php if( mostrarOpcion(100) ){ ?>
            	<li><a href="#">Score Card Modulo</a></li>
            <?php } ?>
         	<?php if( mostrarOpcion(101) ){ ?>
            	<li><a href="#">Semanal</a></li>
            <?php } ?>
        	<?php if( mostrarOpcion(102) ){ ?>
            	<li><a href="#">Mensual</a></li>
            <?php } ?>
        <?php if ( mostrarSubmenu(18) ) { ?>
        	</ul>
		</li>
        <?php } ?>
<?php if( mostrarMenu(3) ) { ?>
	</ul>
</li>
<?php } ?>
<!--Contabilidad-->
<?php if( mostrarMenu(4) ) { ?>
<li class="sub-menu">
	<a href="javascript:;" id="cont"><i class="fa fa-money"></i><span>CONTABILIDAD</span></a>
	<ul class="sub">
<?php } ?>
		<?php if ( mostrarOpcion(122) ) { ?>
		<li><a href="<?php echo $ROOT ?>/_Contabilidad/Tablero/index.php">Abono a Forelo</a></li>
		<?php } ?>
		<?php if( mostrarSubmenu(4) ) { ?>
		<li class="sub-menu"><a href="javascript:;">Pagos</a>
			<ul class="sub">
		<?php } ?>
		<?php if ( mostrarOpcion(161) ) { ?>
                <li><a href="<?php echo $ROOT ?>/_Contabilidad/Pagos/Paycash/conciliacionPayCash.php">Pagos PayCash
                </a></li>
               <?php } ?>
				<?php if ( mostrarOpcion(19) ) { ?>
				<li><a href="<?php echo $ROOT ?>/_Contabilidad/Pagos/Proveedores/Listado.php">Proveedores</a></li>
				<?php } ?>
				<?php if ( mostrarOpcion(90) ) { ?>
				<li><a href="<?php echo $ROOT ?>/_Contabilidad/Pagos/Proveedores/CorteProveedor.php">Corte Proveedor</a></li>
				<?php } ?>
				<?php if ( mostrarOpcion(20) ) { ?>
				<li class="sub-menu"><a href="<?php echo $ROOT ?>/_Contabilidad/Pagos/Reembolsos/Listado.php">Reembolsos</a>
					<!--ul class="sub">
				<?php } ?>
						<?php if ( mostrarOpcion(20) ) { ?>
						<li><a href="<?php echo $ROOT ?>/_Contabilidad/Pagos/Reembolsos/Listado.php">Manuales</a></li>
						<?php } ?>
						<?php if ( mostrarOpcion(52) ) { ?>
						<li><a href="">Automáticos</a></li>
						<?php } ?>
				<?php if( mostrarOpcion(20) || mostrarOpcion(52) ) { ?>
					</ul-->
				</li>
				<?php } ?>
				<?php if ( mostrarOpcion(21) ) { ?>
				<li><a href="<?php echo $ROOT ?>/_Contabilidad/Pagos/Corresponsales/Listado.php">Corresponsales</a></li>
				<?php } ?>
				<?php if ( mostrarOpcion(22) ) { ?>
				<li><a href="<?php echo $ROOT ?>/_Contabilidad/Pagos/Grupos/Listado.php">Grupos</a></li>
				<?php } ?>
				<?php if ( mostrarOpcion(55) ) { ?>
				<li><a href="<?php echo $ROOT ?>/_Contabilidad/Pagos/Varios/Listado.php">Otros</a></li>
				<?php } ?>
		<?php if( mostrarSubmenu(4) ) { ?>
			</ul>
		</li>
		<?php } ?>
		<?php if( mostrarSubmenu(5) ) { ?>
		<li class="sub-menu"><a href="javascript:;">Depósitos</a>
			<ul class="sub">
		<?php } ?>
				<?php if ( mostrarOpcion(23) ) { ?>
				<li><a href="<?php echo $ROOT ?>/_Contabilidad/Depositos/ManualesListado.php">Manuales</a></li>
				<?php } ?>
				<?php if ( mostrarOpcion(24) ) { ?>
				<li><a href="<?php echo $ROOT ?>/_Contabilidad/Depositos/AutomaticosListado.php">Automáticos</a></li>
				<?php } ?>
		<?php if( mostrarSubmenu(5) ) { ?>
			</ul>
		</li>
		<?php } ?>
		<?php if ( mostrarOpcion(25) ) { ?>
		<li><a href="<?php echo $ROOT ?>/_Contabilidad/Cuentas/Listado.php">Cuentas</a></li>
		<?php } ?>
		<?php if( mostrarSubmenu(6) ) { ?>
		<li class="sub-menu"><a href="">Factura / Recibos</a>
			<ul class="sub">
		<?php } ?>
				<?php if ( mostrarOpcion(27) ) {  ?>
				<li><a href="<?php echo $ROOT?>/_Contabilidad/FacturasRecibos/FacturasRecibos.php">Proveedores</a></li>
				<?php } ?>
				<?php if ( mostrarOpcion(26) ) { ?>
				<li><a href="<?php echo $ROOT?>/_Contabilidad/FacturasRecibos/Clientes.php">Clientes</a></li>
				<?php } ?>
				<?php if ( mostrarOpcion(57) ) { ?>
				<li><a href="<?php echo $ROOT?>/_Contabilidad/FacturasRecibos/Grupos.php">Grupos</a></li>
				<?php } ?>
		 <?php if( mostrarSubmenu(6) ) { ?>
			</ul>
		</li>
		<?php } ?>

		<?php if(mostrarSubmenu(17)){ ?>
			<li class="sub-menu"><a href="">Instrucciones de Pago</a>
			<ul class="sub" id="ul17">
				<?php if(mostrarOpcion(91)){ ?>
					<li><a href="<?php echo $ROOT?>/_Contabilidad/InstruccionesDePago/Proveedores.php?ul=17">Proveedores</a></li>
				<?php } ?>
				<?php if(mostrarOpcion(92)){ ?>
					<li><a href="<?php echo $ROOT?>/_Contabilidad/InstruccionesDePago/Clientes.php">Clientes</a></li>
				<?php } ?>

				<?php if(mostrarOpcion(93)){ ?>
					<li><a href="<?php echo $ROOT?>/_Contabilidad/InstruccionesDePago/Acreedores.php">Acreedores</a></li>
				<?php } ?>

				<?php if(mostrarOpcion(94)){  ?>
					<li><a href="<?php echo $ROOT?>/_Contabilidad/InstruccionesDePago/Grupos.php">Grupos</a></li>
				<?php } ?>
			</ul>
			</li>
		<?php } ?>

		<?php if(mostrarOpcion(58)){?>
			<li><a href="<?php echo $ROOT ?>/_Contabilidad/Pagos/Autorizacion/Autorizar.php">Autorizar Pagos</a></li>
		<?php } ?>

		<?php if ( mostrarOpcion(44) ) { ?>
		<li><a href="<?php echo $ROOT ?>/_Contabilidad/ReferenciasBancarias/ReferenciasBancarias.php">Alta Referencias Bancarias</a></li>
		<?php } ?>


        <?php if(mostrarSubmenu(31)){ ?>


         <li class="sub-menu"><a href="">Seguimiento a Facturas</a>
			<ul class="sub" >
				<?php if(mostrarOpcion(157)){ ?>
					<li><a href="<?php echo $ROOT?>/_Contabilidad/SeguimientoFacturasCorresponsal/SeguimientoFacturas.php">Autorizaciones</a></li>

		<?php  } if(mostrarOpcion(158)){?>
					<li><a href="<?php echo $ROOT?>/_Contabilidad/SeguimientoFacturasCorresponsal/SeguimientoFacturasSoporte.php">Seguimineto a Rechazos</a></li>

                <?php } ?>
			</ul>
			</li>

    <?php } ?>

<?php if( mostrarMenu(4) ) { ?>
	</ul>
</li>



<?php } ?>


<!--Sistemas-->
<?php if ( mostrarMenu(5) ) { ?>
<li class="sub-menu">
	<a href="javascript:;"><i class="fa fa-desktop"></i><span>SISTEMAS</span></a>
    <ul class="sub">
<?php } ?>
        <?php if ( mostrarSubmenu(8) ) { ?>
    	<li class="sub-menu"><a href="javascript:;">MI RED</a>
            <ul class="sub">
        <?php } ?>
        		<?php if ( mostrarOpcion(29) ) { ?>
                <li><a href="<?php echo $ROOT ?>/_Sistemas/MiRed/Usuarios/Listado.php">Usuarios</a></li>
                <?php } ?>
        <?php if ( mostrarSubmenu(8) ) { ?>
            </ul>
        </li>
        <?php } ?>

        <?php if ( mostrarSubmenu(7) ) { ?>
    	<li class="sub-menu"><a href="javascript:;">WEBPOS</a>
            <ul class="sub">
        <?php } ?>
        		<?php if ( mostrarOpcion(29) ) { ?>
                <li><a href="<?php echo $ROOT ?>/_Sistemas/WEBPOS/Permisos.php">Permisos</a></li>
                <?php } ?>
        <?php if ( mostrarSubmenu(8) ) { ?>
            </ul>
        </li>
        <?php } ?>
<?php if( mostrarMenu(5) ) { ?>
    </ul>
</li>
<?php } ?>



<!-- Apartado de PayCash preproduccion -->
<?php if ( mostrarMenu(19) ) { ?>
<li class="sub-menu">
	<a href="javascript:;"><i class="fa fa-credit-card"></i><span>PAYCASH</span></a>
    <ul class="sub">
     <?php if ( mostrarSubmenu(25) ) { ?>
    	<li><a href="javascript:;">Afiliación</a>
            <ul class="sub">
            <?php if ( mostrarOpcion(151) ) { ?>
        		<li><a href="<?php echo $ROOT ?>/paycash/Afiliacion/prospectos.php">Lista de Prospectos</a></li>
        	<?php } ?>
            <?php if ( mostrarOpcion(138) ) { ?>
                <li><a href="<?php echo $ROOT ?>/paycash/Afiliacion/AfiliacionEmisor.php">Emisor</a></li>
            <?php } ?>
            </ul>
            <ul class="sub">
            <?php if ( mostrarOpcion(139) ) { ?>
                <li><a href="<?php echo $ROOT ?>/paycash/Afiliacion/AfiliacionCadena.php">Receptor</a></li>
             <?php } ?>
             <?php if ( mostrarOpcion(152) ) { ?>
                <li><a href="<?php echo $ROOT ?>/paycash/Afiliacion/consultaClientes.php">Lista de Emisores/Receptores</a></li>
             <?php } ?>
            </ul>
        </li>
		<?php } ?>

        <?php if ( mostrarOpcion(144) ) { ?>
        <li><a href="<?php echo $ROOT ?>/paycash/Pagos/altaBanco.php">Alta de Banco</a></li>
        <?php } ?>
    	<?php if ( mostrarSubmenu(27) ) { ?>
        <li><a href="javascript:;">Liquidacion y Comisiones</a>
            <ul class="sub">
            <?php if ( mostrarOpcion(154) ) { ?>
            	<li><a href="<?php echo $ROOT ?>/paycash/Pagos/cargaPagos.php">Carga de Pagos</a></li>
            <?php } ?>
             <?php if ( mostrarOpcion(146) ) { ?>
            	<li><a href="<?php echo $ROOT ?>/paycash/Comisiones/comisionesEmisor.php">Cobro de Comisiones</a></li>
            <?php } ?>
            <?php if ( mostrarOpcion(147) ) { ?>
                <li><a href="<?php echo $ROOT ?>/paycash/Comisiones/comisionesReceptor.php">Pago de Comisiones</a></li>
               <?php } ?>
               <?php if ( mostrarOpcion(148) ) { ?>
                <li><a href="<?php echo $ROOT ?>/paycash/Pagos/pagosReceptor.php">Cobro de Liquidacion</a></li>
            <?php } ?>
            <?php if ( mostrarOpcion(153) ) { ?>
                <li><a href="<?php echo $ROOT ?>/paycash/Pagos/pagosEmisor.php">Pago de Liquidacion</a></li>
            <?php } ?>
             <?php if ( mostrarOpcion(145) ) { ?>
    			<li><a href="<?php echo $ROOT ?>/paycash/Comisiones/Actualizar.php">Actualizar Comisiones</a></li>
    		<?php } ?>
    		<?php if ( mostrarOpcion(150) ) { ?>
        		<li><a href="<?php echo $ROOT ?>/paycash/Pagos/proyeccion.php">Proyeccion</a></li>
        	<?php } ?>
            </ul>
        </li>
         <?php } ?>


         <?php if ( mostrarSubmenu(26) ) { ?>
        <li><a href="javascript:;">P&oacute;lizas</a>
            <ul class="sub">
            <?php if ( mostrarSubmenu(28) ) { ?>
        		<li><a href="javascript:;">Liquidacion de Pagos</a>
            		<ul class="sub">
              		<?php if ( mostrarOpcion(140) ) { ?>
                		<li><a href="<?php echo $ROOT ?>/paycash/polizas/liquidacion_pagos/">Receptor</a></li>
            		<?php } ?>
					<?php if ( mostrarOpcion(142) ) { ?>
                		<li><a href="<?php echo $ROOT ?>/paycash/polizas/liquidacion_pagos_emisor/">Emisor</a></li>
					<?php } ?>
            		</ul>
        		</li>
         	<?php } ?>
            <?php if ( mostrarOpcion(141) ) { ?>
                <li><a href="<?php echo $ROOT ?>/paycash/polizas/liquidacion_comisiones/">Pago de Comisiones</a></li>
             <?php } ?>
				<?php if ( mostrarOpcion(143) ) { ?>
                <li><a href="<?php echo $ROOT ?>/paycash/polizas/comision_ganada/">Cobro de Comisiones</a></li>
                <?php } ?>
            </ul>
        </li>
        <?php } ?>


        <?php if ( mostrarOpcion(149) ) { ?>
        <li><a href="<?php echo $ROOT ?>/paycash/Pagos/consulta.php">Consulta de Pagos</a></li>
        <?php } ?>
    </ul>
</li>
<?php } ?>




<?php if ( mostrarMenu(20) ) { ?>
<li class="sub-menu">

	<a href="javascript:;"><i class="fa fa-ticket"></i><span>MI SUERTE</span></a>
    <ul class="sub">


    	<?php if ( mostrarSubmenu(30) ) { ?>
        <li><a href="javascript:;">Liquidacion y Comisiones</a>
            <ul class="sub">
            <?php if ( mostrarOpcion(134) ) { ?>
        		<li><a href="<?php echo $ROOT; ?>/misuerte/comisiones/cobro/">Cobro de Comisiones</a></li>
        	<?php } ?>
			<?php if ( mostrarOpcion(135) ) { ?>
        		<li><a href="<?php echo $ROOT; ?>/misuerte/conciliacion/">Conciliaci&oacute;n Manual</a></li>
        	<?php } ?>
			<?php if ( mostrarOpcion(136) ) { ?>
        		<li><a href="<?php echo $ROOT; ?>/misuerte/cortes/mensual/">Corte Mensual</a></li>
        	<?php } ?>
 			<?php if ( mostrarOpcion(156) ) { ?>
        		<li><a href="<?php echo $ROOT; ?>/misuerte/conciliacion/monitorPagos.php/">Liquidacion de Pagos</a></li>
        	<?php } ?>
            </ul>
        </li>
        <?php } ?>
        <?php if ( mostrarOpcion(137) ) { ?>
        	<li><a href="<?php echo $ROOT; ?>/misuerte/monitor/">Monitor</a></li>
        <?php } ?>
    	<?php if ( mostrarSubmenu(25) ) { ?>
    	<li><a href="javascript:;">Afiliación</a>
    		<?php if ( mostrarOpcion(126) ) { ?>
            <ul class="sub">
                <li><a href="<?php echo $ROOT ?>/misuerte/Afiliacion/AfiliacionProveedor.php">Proveedor</a></li>
            </ul>
            <?php } ?>
            <?php if ( mostrarOpcion(127) ) { ?>
            <ul class="sub">
                <li><a href="<?php echo $ROOT ?>/misuerte/Afiliacion/AfiliacionClientes.php">Cliente</a></li>
            </ul>
            <?php } ?>
            <?php if ( mostrarOpcion(155) ) { ?>
             <ul class="sub">
        		<li><a href="<?php echo $ROOT; ?>/misuerte/Afiliacion/consulta.php">Lista de Proveedores/Clientes</a></li>
        	</ul>
        	<?php } ?>
        </li>
        <?php } ?>


        <?php if ( mostrarSubmenu(29) ) { ?>
    	<li><a href="javascript:;">Configuración</a>
 			<?php if ( mostrarOpcion(128) ) { ?>
 			<ul class="sub">
        		<li><a href="<?php echo $ROOT; ?>/misuerte/metodospago/">M&eacute;todos de Pago</a></li>
        	</ul>
        	<?php } ?>
        	<?php if ( mostrarOpcion(133) ) { ?>
        	<ul class="sub">
        		<li><a href="<?php echo $ROOT; ?>/misuerte/configuracion/">Mi Suerte</a></li>
        	</ul>
        	<?php } ?>
 		</li>
        <?php } ?>
    </ul>
</li>
<?php } ?>


</ul>
</div>
</aside>
<!--Fin Menu Vertical-->