<?php
$directorio = $_SERVER['HTTP_HOST'];
$PATHRAIZ = "https://".$directorio;
?>
<!--Cuerpo del Sitio-->
<body>
<!--Contenedor Principal-->
<section id="container">
<!--Inicio de la Cabecera-->
<header class="header white-bg">
<div class="sidebar-toggle-box">
<div data-original-title="Ocultar Menú" data-placement="right" class="fa fa-bars tooltips"></div>
<img src="<?php echo $PATHRAIZ?>/img/logon.png" width="113" style="margin-left:13px;">

</div>

<!--Notificaciones-->
<div class="nav notify-row" id="top_menu">
<ul class="nav top-menu">
<li id="header_notification_bar" class="dropdown">
</li>
</ul>
</div>
<!-- Menú del Usuario-->
<div class="top-nav ">
<ul class="nav pull-right top-menu">
<li class="dropdown">
<a data-toggle="dropdown" class="dropdown-toggle" href="#">
<span class="username"><?php
$nombreUsuario = $_SESSION['nombre'];
if ( !preg_match('!!u', $nombreUsuario) ) {
    //no es utf-8
    $nombreUsuario = utf8_encode($nombreUsuario);
}
echo $nombreUsuario;
?></span>
<b class="caret"></b></a>
<ul class="dropdown-menu extended logout">
<div class="log-arrow-up"></div>
<li><a href="#">Permisos</a></li>
<li><a href="#">Editar</a></li>
<li><a href="#">Contrase&ntilde;a</a></li>
<li><a href="<?php echo $ROOT; ?>/logout.php">CERRAR SESI&Oacute;N</a></li>
</ul>
</li>
<!--Final del Menú de Usuario-->
</ul>
</div> 
</header>
<!--Final de la Cabecera-->