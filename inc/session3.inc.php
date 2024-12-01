<?php
if ($_SERVER["SERVER_PORT"] != 443){
header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
    exit();
}

session_start();

function getUsuarioRoles ($nIdUsuario, $nIdFormulario)
{
    if (!isset($_SESSION['roles']))
    {
        $_SESSION['roles'] = getSpUsuarioRole($nIdUsuario, $nIdFormulario);
    }
}


function getSpUsuarioRole ($nIdUsuario, $nIdFormulario) 
{
    $sql = "CALL redefectiva.sp_select_usuario_role($nIdUsuario, $nIdFormulario);";
    $resultado = $GLOBALS['RBD']->query($sql);
    
    $roles = array();
    if (!($resultado)) {
    } else {
        $index = 0;
        while($row = mysqli_fetch_assoc($resultado)) {
            $roles[$index]['nIdRoleUsuario'] = $row['nIdRoleUsuario'];
            $roles[$index]['nIdFormulario'] = $row['nIdFormulario'];
            $roles[$index]['nIdTipoUsuario'] = $row['nIdTipoUsuario'];
            $roles[$index]['sCorreos'] = $row['sCorreos'];
            $roles[$index]['sTipoUsuario'] = $row['sTipoUsuario'];

            $index++;
        }
    }

    return $roles;
}