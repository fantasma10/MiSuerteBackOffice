<!--Menú en la Barra Vertical Izquierda-->
<?php
$directorio = $_SERVER['HTTP_HOST'];
$PATHRAIZ = "https://" . $directorio;
$dir = $PATHRAIZ . "/main.php";
//echo "<script>console.log('dato:".$ROOT."')</script>";
?>
<aside>
    <div id="sidebar" class="nav-collapse">
        <ul class="sidebar-menu" id="nav-accordion">
            <!--Inicio-->
            <li class="sub-menu"><a href="<?php echo $dir; ?>"><i class="fa fa-globe"></i><span>INICIO</span></a></li>

            <!-- Apartado de Mi Suerte produccion -->
            <?php if (mostrarMenu(20)) { ?>
                <li class="sub-menu">

                    <a href="javascript:;"><i class="fa fa-ticket"></i><span>MI SUERTE</span></a>
                    <ul class="sub">


                        <?php if (mostrarSubmenu(30)) { ?>
                            <li><a href="javascript:;">Liquidacion y Comisiones</a>
                                <ul class="sub">
                                    <?php if (mostrarOpcion(134)) { ?>
                                        <li><a href="<?php echo $ROOT; ?>/misuerte/comisiones/cobro/">Cobro de Comisiones</a></li>
                                    <?php } ?>
                                    <?php if (mostrarOpcion(135)) { ?>
                                        <li><a href="<?php echo $ROOT; ?>/misuerte/conciliacion/">Conciliaci&oacute;n Manual</a></li>
                                    <?php } ?>
                                    <?php if (mostrarOpcion(164)) { ?>
                                        <li><a href="<?php echo $ROOT; ?>/misuerte/cortes/consultaCorte.php/">Consulta de Corte</a></li>
                                    <?php } ?>
                                    <?php if (mostrarOpcion(136)) { ?>
                                        <li><a href="<?php echo $ROOT; ?>/misuerte/cortes/mensual/">Corte Mensual</a></li>
                                    <?php } ?>
                                    <?php if (mostrarOpcion(178)) { ?>
                                        <li><a href="<?php echo $ROOT; ?>/misuerte/cortes/corte.php/">Conciliaci&oacute;n de Pagos</a></li>
                                    <?php } ?>
                                    <?php if (mostrarOpcion(156)) { ?>
                                        <li><a href="<?php echo $ROOT; ?>/misuerte/conciliacion/monitorPagos.php/">Liquidaci&oacute;n de Pagos</a></li>
                                    <?php } ?>
                                    <?php if (mostrarOpcion(166)) { ?>
                                        <li><a href="<?php echo $ROOT; ?>/misuerte/conciliacion/liberacionRetiros.php/">Liquidaci&oacute;n de Retiros</a></li>
                                    <?php } ?>
                                    <?php if (mostrarOpcion(168)) { ?>
                                        <li><a href="<?php echo $ROOT; ?>/misuerte/conciliacion/pagosConPremios.php/">Pagos con Premios</a></li>
                                    <?php } ?>
                                    <?php if (mostrarOpcion(173)) { ?>
                                        <li><a href="<?php echo $ROOT; ?>/misuerte/conciliacion/pagosCuentaElectronica.php/">Pagos con Cuenta Electronica</a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if (mostrarOpcion(137)) { ?>
                            <li><a href="<?php echo $ROOT; ?>/misuerte/monitor/">Monitor</a></li>
                        <?php } ?>
                        <?php if (mostrarOpcion(162)) { ?>
                            <li><a href="<?php echo $ROOT ?>/misuerte/cortes/cargaJuegos.php">Carga de juegos</a></li>
                        <?php } ?>
                        <?php if (mostrarSubmenu(25)) { ?>
                            <li><a href="javascript:;">Afiliación</a>
                                <?php if (mostrarOpcion(126)) { ?>
                                    <ul class="sub">
                                        <li><a href="<?php echo $ROOT ?>/misuerte/Afiliacion/AfiliacionProveedor.php">Proveedor</a></li>
                                    </ul>
                                <?php } ?>
                                <?php if (mostrarOpcion(127)) { ?>
                                    <ul class="sub">
                                        <li><a href="<?php echo $ROOT ?>/misuerte/Afiliacion/AfiliacionClientes.php">Cliente</a></li>
                                    </ul>
                                <?php } ?>
                                <?php if (mostrarOpcion(155)) { ?>
                                    <ul class="sub">
                                        <li><a href="<?php echo $ROOT; ?>/misuerte/Afiliacion/consulta.php">Lista de Proveedores/Clientes</a></li>
                                    </ul>
                                <?php } ?>
                            </li>
                        <?php } ?>


                        <?php if (mostrarSubmenu(29)) { ?>
                            <li><a href="javascript:;">Configuración</a>
                                <?php if (mostrarOpcion(128)) { ?>
                                    <ul class="sub">
                                        <li><a href="<?php echo $ROOT; ?>/misuerte/metodospago/">M&eacute;todos de Pago</a></li>
                                    </ul>
                                <?php } ?>
                                <?php if (mostrarOpcion(180)) { ?>
                                    <ul class="sub">
                                        <li><a href="<?php echo $ROOT; ?>/misuerte/metodospago/abonoCuenta.php">Reconocimiento de Abonos</a></li>
                                    </ul>
                                <?php } ?>
                                <?php if (mostrarOpcion(133)) { ?>
                                    <ul class="sub">
                                        <li><a href="<?php echo $ROOT; ?>/misuerte/configuracion/">Mi Suerte</a></li>
                                    </ul>
                                <?php } ?>
                            </li>
                        <?php } ?>

                        <?php if (mostrarSubmenu(50)) { ?>
                            <li><a href="javascript:;">Reportes</a>
                                <?php if (mostrarOpcion(246)) { ?>
                                    <ul class="sub">
                                        <li><a href="<?php echo $ROOT ?>/misuerte/reportes/reporteOperaciones.php">Repote de Operaciones</a></li>
                                    </ul>
                                <?php } ?>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>

            <!--Sistemas-->
            <?php if (mostrarMenu(5)) { ?>
                <li class="sub-menu">
                    <a href="javascript:;"><i class="fa fa-desktop"></i><span>SISTEMAS</span></a>
                    <ul class="sub">
                    <?php } ?>
                    <?php if (mostrarSubmenu(8)) { ?>
                        <li class="sub-menu"><a href="javascript:;">MI RED</a>
                            <ul class="sub">
                            <?php } ?>
                            <?php if (mostrarOpcion(29)) { ?>
                                <li><a href="<?php echo $ROOT ?>/_Sistemas/MiRed/Usuarios/Listado.php">Usuarios</a></li>
                            <?php } ?>
                            <?php if (mostrarSubmenu(8)) { ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <!-- <?php if (mostrarSubmenu(7)) { ?>
                        <li class="sub-menu"><a href="javascript:;">WEBPOS</a>
                            <ul class="sub">
                            <?php } ?>
                            <?php if (mostrarOpcion(29)) { ?>
                                <li><a href="<?php echo $ROOT ?>/_Sistemas/WEBPOS/Permisos.php">Permisos</a></li>
                            <?php } ?>
                            <?php if (mostrarSubmenu(8)) { ?>
                            </ul>
                        </li>
                    <?php } ?> -->
                    <?php if (mostrarMenu(5)) { ?>
                    </ul>
                </li>
            <?php } ?>

        </ul>
    </div>
</aside>
<!--Fin Menu Vertical-->