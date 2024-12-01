
/*=================================================       Rutas      ==============================================================*/


/*=====================================================================*/
/*                            Usuarios ABC                             */
/*=====================================================================*/

function NewUsuario(){
	var nombre = txtValue('txtNombre');
	if( nombre != "" ){
		var paterno = txtValue('txtApellidoP');
		if( paterno != "" ){
			var materno = txtValue('txtApellidoM');
			if( materno != "" ){
				var correo = txtValue('txtCorreo');
				if( correo != ""){
					var tipoperfil = txtValue('ddlTipo');
					if( tipoperfil != ""){

						var parametros ="correo="+correo+"&idperfil="+tipoperfil+"&nombreusuario="+nombre+"&paternousuario="+paterno+"&maternousuario="+materno;

						MetodoAjax("../../../inc/Ajax/_Admin/NewUsuarios.php",parametros);

					}else{ alert("Favor de seleccionar un tipo de perfil"); }
				}else{ alert("Favor de escribir un correo"); }
			}else{ alert("Favor de escribir un apellido materno"); }
		}else{ alert("Favor de escribir un apellido paterno");}
	}else{ alert("Favor de escribir un nombre"); }
}

/*
 * Crea el string JSON utilizado para actualizar
 * los permisos de un usuario.
 * El string resultante contiene los Datos Generales
 * del usuario seleccionado en la aplicacion.
 * Parametro: idPortal ID del Portal sobre el que se
 * hara la actualizacion de permisos.
 * Autor: Roberto Cortina
 * Fecha de creacion: 21 de noviembre de 2013
 * Fecha de ultima modificacion: 21 de novimebre de 2013
 */
function crearStringJSONDatosGenerales ( idPortal ) {
	var idUsuario = txtValue('txtId');
	var idPerfilOriginal = txtValue('txtIdPerfil');
	var stringJSON = "";
	if ( idUsuario != "" ) {
		var apellidoMaterno = txtValue('txtApellidoM');
		var idPerfil = txtValue('ddlTipo');
		if ( idPerfil != "" ) {
			var estatus	= 0;
			var cbAct = txtValue('cbActivo');
			if ( cbAct != null ) {
				if ( Check('cbActivo')==false ) {
					estatus	= 1;
				}
			} else {
				estatus	= 2;
			}
			//Armar string JSON
			var stringJSON = '{ "datosGenerales": [';
			stringJSON += '{ "idEstatus": '+ estatus +', ';
			stringJSON += '"idUsuario": '+ idUsuario +', ';
			stringJSON += '"apellidoMaterno": "' + apellidoMaterno + '", ';
			stringJSON += '"idPerfil": '+ idPerfil +', ';
			stringJSON += '"idPortal": '+ idPortal +', ';
			stringJSON += '"idPerfilOriginal": '+ idPerfilOriginal + ' }';
			stringJSON += ']}';
		}
	}
	return stringJSON;
}

/*
 * Crea el string JSON utilizado para actualizar
 * los permisos de un usuario.
 * El string resultante contiene los Permisos
 * del usuario seleccionado en la aplicacion.
 * Parametro: idPortal ID del Portal sobre el que se
 * hara la actualizacion de permisos.
 * Autor: Roberto Cortina
 * Fecha de creacion: 21 de noviembre de 2013
 * Fecha de ultima modificacion: 21 de novimebre de 2013
 */
function crearStringJSONPermisos ( idPortal ) {
	var stringJSON = "";
	var opcionesConjunto = $( '.opcion' ).length;
	var opcionesTotal = opcionesConjunto / 3;
	var permisosDelUsuario = $( '.opcion:checked' );
	var opcionesTotal = permisosDelUsuario.length;
	if ( opcionesTotal > 0 ) {
		stringJSON += '{';
		stringJSON += '"Menu": [';
	}
	for ( var opcionIndex = 0; opcionIndex < opcionesTotal; opcionIndex++ ) {
		var permisos_split = permisosDelUsuario[opcionIndex].id.split('-');
		var idOpcion = permisos_split[1];
		var accion = permisos_split[2];
		if ( accion == 'lectura' ) {
			stringJSON += '{';
			stringJSON += ' "idOpcion": ' + idOpcion + ', "idAccion": ' + 1 + ' ';
			stringJSON += '}';
			if ( opcionIndex != opcionesTotal-1 ) {
				stringJSON += ', ';
			}
		} else if ( accion == 'escritura' ) {
			stringJSON += '{';
			stringJSON += ' "idOpcion": ' + idOpcion + ', "idAccion": ' + 2 + ' ';
			stringJSON += '}';
			if ( opcionIndex != opcionesTotal-1 ) {
				stringJSON += ', ';
			}
		} else if ( accion == 'bloqueado' ) {
			stringJSON += '{';
			stringJSON += ' "idOpcion": ' + idOpcion + ', "idAccion": ' + 3 + ' ';
			stringJSON += '}';
			if ( opcionIndex != opcionesTotal-1 ) {
				stringJSON += ', ';
			}
		}
	}
	if ( opcionesTotal > 0 ) {
		stringJSON += ']';
		stringJSON += '}';
	}
	return stringJSON;
}

function UpdateUsuario( idPortal ) {
	var datosGenerales = crearStringJSONDatosGenerales( idPortal );
	var permisos = crearStringJSONPermisos( idPortal );
	var parametros = datosGenerales + "|" + permisos;

	var datos = parametros.split("|");
	var dGenerales = datos[0];
	var perm = datos[1];

	if ( parametros != null ) {
		//MetodoAjaxJSON("../../../inc/Ajax/_Admin/UpdateUsuarios.php", parametros);
		showSpinner();
		$.ajax({
			url			: '../../../inc/Ajax/_Admin/UpdateUsuarios.php',
			type		: 'POST',
			dataType	: 'json',
			data		: { datosGenerales : dGenerales, permisos : perm, permiso : true }
		})
		.done(function(resp){
			if(resp.nCodigo == 0){
				alert(resp.sMensaje);
				//location.reload();
			}
			else{
				alert("Error: "+resp.nCodigo+"  "+resp.sMensaje);
			}
		})
		.fail(function() {
			hideSpinner();
		})
		.always(function() {
			hideSpinner();
		});

	}
}

function EliminarActualizarUsuario(id,val){
	if(id != "")
	{
		var parametros ="id="+id+"&val="+val;
			MetodoAjax("../../../inc/Ajax/_Admin/DeleteUsuarios.php",parametros);
	}
	else
	{ alert("Favor de escribir un Id para el Codigo de Error");}
}


function EditarUsuario(id){
	window.location.href = `Consulta.php?id=${id}`;
}

/*=====================================================================*/
/*                            Busquedas USER                           */
/*=====================================================================*/

function BuscarUsuarios() {
	var status = 0;
	if ( Check('Activo') ) {
		status = 0;
	}
	if ( Check('Inactivo') ) {
		status = 1;
	}
	if ( Check('Eliminado') ) {
		status = 2;
	}
	var oTable = $("#usuarios").dataTable();
	var oSettings = oTable.fnSettings();
	oSettings.sAjaxSource = "../../../inc/Ajax/_Admin/UsuariosDataTable.php?status=" + status;
	oTable.fnReloadAjax();
}

/*function BuscarUsuarios(){
	if(Check('Activo')){	Busca("../../inc/Ajax/_Admin/BuscaUsuarios-Activo.php");	}
	if(Check('Inactivo')){	Busca("../../inc/Ajax/_Admin/BuscaUsuarios-Inactivo.php");	}
	if(Check('Eliminado')){	Busca("../../inc/Ajax/_Admin/BuscaUsuarios-Eliminado.php");	}
}

function BuscarUsuarios(i){
	if(Check('Activo')){	BuscarParametros("../../../inc/Ajax/_Admin/BuscaUsuarios.php","status="+0,'',i);	}
	if(Check('Inactivo')){	BuscarParametros("../../../inc/Ajax/_Admin/BuscaUsuarios.php","status="+1,'',i);	}
	if(Check('Eliminado')){	BuscarParametros("../../../inc/Ajax/_Admin/BuscaUsuarios.php","status="+2,'',i);	}
}

function BuscarUsuariosPermisos(i){
	if(Check('Activo')){	BuscarParametros("../../../inc/Ajax/_Admin/BuscaUsuariosPermisos.php","status="+0,'',i);	}
	if(Check('Inactivo')){	BuscarParametros("../../../inc/Ajax/_Admin/BuscaUsuariosPermisos.php","status="+1,'',i);	}
	if(Check('Eliminado')){	BuscarParametros("../../../inc/Ajax/_Admin/BuscaUsuariosPermisos.php","status="+2,'',i);	}
}*/


/*=====================================================================*/
/*                         UpdatePermisos                              */
/*=====================================================================*/

function UpdatePermisos(idsec,tipo,idu){
	var check = 0;
	if(document.getElementById('cbP'+idsec+'R').checked == true)
		var check = 1;

	http.open("POST", "../../../inc/Ajax/_Admin/UpdatePermisos.php", true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	http.onreadystatechange=function()
	{
		if (http.readyState==1)
		{
			//div para  [cargando....]
		}
		if (http.readyState==4)
		{
			var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
			var RESserv = RespuestaServidor.split("|");
			validaSession(RESserv[0]);
			if(RESserv[0] == 0){
				alert(RESserv[1]);
				document.getElementById('FormConsulta').submit();
			}
			else
			{
				alert("Error: "+RESserv[0]+" "+RESserv[1]);
			}
		}
	}
	http.send("idSeccion="+idsec+"&idUsuario="+idu+"&tipo="+check+"&pemiso="+true);
}

function SincronizarUsuarios(){
	//Emergente();
	//MetodoAjaxReload("../../../inc/Ajax/_Admin/SincronizarUsuarios.php","");
	showSpinner();
	$.ajax({
		url			: '../../../inc/Ajax/_Admin/SincronizarUsuarios.php',
		type		: 'POST',
		dataType	: 'json',
		data		: {}
	})
	.done(function(resp){
		alert(resp.sMensaje);
		if(resp.nCodigo == 0){
			location.reload();
		}
	})
	.fail(function() {
		hideSpinner();
	})
	.always(function() {
		hideSpinner();
	});

}

function getSubcadenas() {
	var idCadena = $("#cadenas").val();
	$.post( "../../inc/Ajax/GetSubcadenas.php", { "idCadena": idCadena } ).done(
		function( data ) {
			var subcadenas = jQuery.parseJSON( data );
			var mensajeRespuesta = subcadenas[subcadenas.length-1];
			if ( mensajeRespuesta.codigoRespuesta == 0 ) {
				var opciones = [];
				opciones.push('<option value="-1"></option>');
				for ( var i = 0; i <= subcadenas.length-2; i++ ) {
					opciones.push('<option value="' + subcadenas[i].id + '">' + subcadenas[i].nombre + '</option>');
				}
				$("#subcadenas").html(opciones.join(''));
				$("#subcadenas").trigger("chosen:updated");
			} else {
				$("#subcadenas").html('<option value="-1"></option>');
				$("#subcadenas").trigger("chosen:updated");
				alert(mensajeRespuesta.descripcionRespuesta);
			}
		}
	);
}

function getCorresponsales() {
	var idCadena = $("#cadenas").val();
	var idSubcadena = $("#subcadenas").val();
	$.post( "../../inc/Ajax/GetCorresponsales.php", { "idCadena": idCadena, "idSubcadena": idSubcadena } ).done(
		function( data ) {
			var corresponsales = jQuery.parseJSON( data );
			var mensajeRespuesta = corresponsales[corresponsales.length-1];
			if ( mensajeRespuesta.codigoRespuesta == 0 ) {
				var opciones = [];
				opciones.push('<option value="-1"></option>');
				for ( var i = 0; i <= corresponsales.length-2; i++ ) {
					opciones.push('<option value="' + corresponsales[i].id + '">' + corresponsales[i].nombre + '</option>');
				}
				$("#corresponsales").html(opciones.join(''));
				$("#corresponsales").trigger("chosen:updated");
			} else {
				$("#corresponsales").html('<option value="-1"></option>');
				$("#corresponsales").trigger("chosen:updated");
				alert(mensajeRespuesta.descripcionRespuesta);
			}
		}
	);
}