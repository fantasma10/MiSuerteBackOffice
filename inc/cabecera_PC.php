<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];
$directorio = $_SERVER['HTTP_HOST'];
$PATHRAIZ = "https://" . $directorio;
include($PATH_PRINCIPAL . "/paycash/ajax/reportes/consultaPaises.php");
//echo $_SESSION['idpais'].'<br>';
//echo $_SESSION['RPC_SERVER'].'<br>';
//echo $_SESSION['RPC_DATABASE'].'<br>';

//session_destroy();
?>
<!--Cuerpo del Sitio-->
<style>
    .menuPaises {
        border: 1px solid #eeeeee;
        border-radius: 4px;
        -webkit-border-radius: 4px;
        padding: 6px;
        background: #ffffff;
        margin-right: 0;
        -webkit-box-shadow: -3px 3px 16px -7px rgba(23, 23, 23, 0.66);
        -moz-box-shadow: -3px 3px 16px -7px rgba(23, 23, 23, 0.66);
        height: 37px;
    }
</style>

<body>
    <!--Contenedor Principal-->
    <section id="container">
        <!--Inicio de la Cabecera-->
        <header class="header white-bg">
            <div class="sidebar-toggle-box">
                <div data-original-title="Ocultar Menú" data-placement="right" class="fa fa-bars tooltips"></div>
                <img src="<?php echo $PATHRAIZ ?>/img/logon.png" width="113" style="margin-left:13px;">

            </div>

            <!--Notificaciones-->
            <div class="nav notify-row" id="top_menu">
                <ul class="nav top-menu">
                    <li id="header_notification_bar" class="dropdown">
                    </li>
                </ul>
            </div>
            <!-- Menú del Usuario-->
            <div class="top-nav pull-right">
                <ul class="nav top-menu">
                    <li class="dropdown">
                        <select class="menuPaises" id="cmbPaisGeneral">
                            <?php echo $cmbPais; ?>
                        </select>
                    </li>

                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="username">
                                <?php
                                $nombreUsuario = $_SESSION['nombre'];
                                if (!preg_match('!!u', $nombreUsuario)) {
                                    $nombreUsuario = utf8_encode($nombreUsuario);
                                }
                                echo $nombreUsuario;
                                ?>
                            </span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <div class="log-arrow-up"></div>
                            <li><a href="#">Permisos</a></li>
                            <li><a href="#">Editar</a></li>
                            <li><a href="#">Contrase&ntilde;a</a></li>
                            <li><a href="<?php echo $ROOT; ?>/logout.php">CERRAR SESI&Oacute;N</a></li>
                        </ul>
                    </li>

                </ul>




            </div>
            <!--Final del Menú de Usuario-->
            <!-- Menú del Pais-->


            <!--Final del Menú de Pais-->
            <!--*.JS Generales-->
            <script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.js"></script>
            <script src="<?php echo $PATHRAIZ; ?>/inc/js/respond.min.js"></script>
            <script src="<?php echo $PATHRAIZ; ?>/inc/js/RE.js" type="text/javascript"></script>
            <script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.alerts.js"></script>
            <!--Autocomplete -->
            <script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.core.js"></script>
            <script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.widget.js"></script>
            <script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.menu.js"></script>
        </header>
        <!--Final de la Cabecera-->
        <script>
            //Bloqueamos la seleccion para que solo este en México
            function cambiarSelect() {
                if (window.location.origin.concat("/", "paycash/Pagos/subirPagos.php") === window.location.href) {
                    $("#cmbPaisGeneral").prop("disabled", true);
                }
            }
            window.addEventListener("load", function(event) {
                cambiarSelect();
            });
        </script>

        <script type="text/javascript">
            BASE_PAATH = "<?PHP echo $PATHRAIZ; ?>";
            $(document).ready(function() {
                IDPAIS = "<?php echo $_SESSION['idpais']; ?>"
                var _idPais = IDPAIS;
                if (_idPais == "" || _idPais == null) {
                    _idPais = 1;
                    $('#cmbPaisGeneral').val(_idPais);
                    $('#cmbPaisGeneral').change();
                }

                $('#cmbPaisGeneral').val(_idPais);
                $('#cmbPaisGeneral').change(function() {
                    var cargando = $("#emergente");
                    $(document).ajaxStart(function() {
                        cargando.show();
                    });
                    var dbW = $('#cmbPaisGeneral').find(':selected').data('dbw');
                    var portW = $('#cmbPaisGeneral').find(':selected').data('portw');
                    var hostW = $('#cmbPaisGeneral').find(':selected').data('hostw');
                    var userW = $('#cmbPaisGeneral').find(':selected').data('userw');
                    var pwW = $('#cmbPaisGeneral').find(':selected').data('pww');
                    var dbR = $('#cmbPaisGeneral').find(':selected').data('dbr');
                    var portR = $('#cmbPaisGeneral').find(':selected').data('portr');
                    var hostR = $('#cmbPaisGeneral').find(':selected').data('hostr');
                    var userR = $('#cmbPaisGeneral').find(':selected').data('userr');
                    var pwR = $('#cmbPaisGeneral').find(':selected').data('pwr');
                    var abrev = $('#cmbPaisGeneral').find(':selected').data('abreviatura');
                    var idPais = $('#cmbPaisGeneral').find(':selected').val();
                    $.post(BASE_PAATH + "/paycash/ajax/reportes/DatosDeConexion.php", {
                            dbW: dbW,
                            portW: portW,
                            hostW: hostW,
                            userW: userW,
                            pwW: pwW,
                            dbR: dbR,
                            portR: portR,
                            hostR: hostR,
                            userR: userR,
                            pwR: pwR,
                            abreviatura: abrev,
                            idpais: idPais
                        },
                        function(resp) {
                            location.reload();
                            if(location == (BASE_PAATH + "/paycash/Afiliacion/AfiliacionEmisor.php")){
                                window.location = "../../paycash/Afiliacion/AfiliacionEmisor.php?idemisores=0";
                            }
                        });
                });
            });
        </script>