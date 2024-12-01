function AutoCadena(){
	if(Existe("txtNombreCadena"))
		AutoCompletar("txtNombreCadena","../inc/Ajax/AutoCadenaNom.php",1);
}
function AutoCorresponsal(){
	/*if(Existe("txtNomCorr"))
		AutoCompletar("txtNomCorr","../inc/Ajax/AutoCorresponsalNom2.php",2);*/
}
function AutoCorresponsalTel(){
	if(Existe("txtTel"))
		AutoCompletar("txtTel","../inc/Ajax/AutoCorresponsalTel.php",3);
}

function AutoContactoNom(){
	if(Existe("txtContacNom"))
		AutoCompletar("txtContacNom","../../inc/Ajax/AutoContactoNom.php",1);
}
function AutoContactoApP(){
	if(Existe("txtContacAP"))
		AutoCompletar("txtContacAP","../../inc/Ajax/AutoContactoAP.php",2);
}
function AutoContactoApM(){
	if(Existe("txtContacAM"))
		AutoCompletar("txtContacAM","../../inc/Ajax/AutoContactoAM.php",3);
}
function AutoRepLegal(){
	if(Existe("txtreplegal"))
		AutoCompletar("txtreplegal","../../inc/Ajax/AutoRepLegal.php",3);
}
function AutoCalleDir(){
	if(Existe("txtcalle"))
		AutoCompletar("txtcalle","../../inc/Ajax/AutoCalleDireccion.php",3);
}
function AutoColoniaDir(){
	if(Existe("txtcolonia"))
		AutoCompletar("txtcolonia","../../inc/Ajax/AutoColoniaDireccion.php",3);
}
function AutoCiudadDir(){
	if(Existe("txtciudad"))
		AutoCompletar("txtciudad","../../inc/Ajax/AutoCiudadDireccion.php",1);
}
function AutoCalleDir2(){
	if(Existe("txtcalle"))
		AutoCompletar("txtcalle","../../inc/Ajax/AutoCalleDireccion.php",2);
}
function AutoColoniaDir2(){
	if(Existe("txtcolonia"))
		AutoCompletar("txtcolonia","../../inc/Ajax/AutoColoniaDireccion.php",3);
}
function AutoActividadBanco(){
	if(Existe("txtactbanc"))
		AutoCompletar("txtactbanc","../../inc/Ajax/AutoActividadBanco.php?idbanco="+txtValue("ddlBanco"),3);
}

function AutoEjecutivoVenta(){
	if(Existe("txtejecutivoventa"))
		AutoCompletar("txtejecutivoventa","../../inc/Ajax/AutoEjecutivoVenta.php",2);
}

function AutoEjecutivoCuenta(){
	if(Existe("txtejecutivocuenta"))
		AutoCompletar("txtejecutivocuenta","../../inc/Ajax/AutoEjecutivoCuenta.php",3);
}
function AutoUsuarioAlta(){
	if(Existe("txtusuarioalta"))
		AutoCompletar("txtusuarioalta","../../inc/Ajax/AutoUsuarioAlta.php?idCorresponsal="+getDivHTML('idCorresponsal'),5);		
}
/*==================================  estos autocompletar son para prealtas ========================*/

function AutoPreCorresponsal(){
	if(Existe("txtNombrePreCorr"))
		AutoCompletar("txtNombrePreCorr","../../inc/Ajax/AutoPreCorrNom.php",1,2);
}

function AutoCadena2(){
	if(Existe("txtNombreCadena"))
		AutoCompletar("txtNombreCadena","../../inc/Ajax/AutoCadenaNom.php",2,2);
}

function AutoPreCadena(){
	if(Existe("txtNombreCadena"))
		AutoCompletar("txtNombreCadena","../../inc/Ajax/AutoPreCadenaNombre.php",2,2);
}

function AutoCadenaN(){
	if(Existe("txtNombreCadena"))
		AutoCompletar("txtNombreCadena","../../inc/Ajax/AutoCadenaNombre.php",2,2);
}

function AutoPreSubCadena(){
	if(Existe("txtNombre"))
		AutoCompletar("txtNombre","../../inc/Ajax/AutoPreSubCadenaNombre.php",3,2);
}

function AutoPreSubCorr(){
	if(Existe("txtPreSubCorr"))
		AutoCompletar("txtPreSubCorr","../../inc/Ajax/AutoPreSubCorrNom.php",3,2);
}

function getSelDiv(){
	var idbanco = txtValue("ddlBanco");
	BuscarParametros("../../inc/Ajax/_Clientes/SelectEntDiv.php","idBanco="+idbanco,'selectdivision');
}

/* ====================================  Editar y Agregar Contactos  =========================================*/
function EditarContactos(id,nom,apP,apM,idTipo,tel,correo, ext, e){
	e.preventDefault();

	setValue("txtContacNom",nom);
	setValue("txtContacAP",apP);
	setValue("txtContacAM",apM);

	$("#ddlTipoContac option[value="+ idTipo +"]").attr("selected",true);
	setValue("txtTelContac",tel);
	setValue("txtMailContac",correo);
	setValue("txtExtTelContac",ext);
	
	setValue("HidContacto",id);
	
	Persiana(false);
}
function AgregarContacto(e){
	e.preventDefault();
	
	setValue("txtContacNom","");
	setValue("txtContacAP","");
	setValue("txtContacAM","");
	setValue("ddlTipoContac",-2);
	//setValue("txtTelContac","52-");
	setValue("txtMailContac","");
	setValue("txtExtTelContac", "");
	
	setValue("HidContacto",-2);
	
	Persiana(false);
}


function BuscaCadSubCad1(){
	if(Check('rdbCadena'))
		BuscaCadena1();
	if(Check('rdbSubcadena'))
		BuscaSubCadena1();
}

function BuscaCadena1() {
	var id = txtValue('cadenaID');
	if ( id != "" && id > -1 ) {
		$.post( '../inc/Ajax/_Clientes/ChecarCadena.php', { cadenaID: id }).done( function ( data ) {
			if ( data > 0 ) {
				alert('No existe la Cadena');
			} else {
				setValue('hidCadenaX',id);
				irAForm('formPase','Cadena/Listado.php','../menuConsulta.php');							
			}
		});
	} else {
		alert('Favor de escribir un Id de Cadena valido');																					 																				
	}
}

function BuscaSubCadena1(i) {
	var id = txtValue('subcadenaID');
	if ( id != "" && id >= 0 ) {
		$.post( '../inc/Ajax/_Clientes/ChecarSubCadena.php', { subcadenaID: id }).done( function ( data ) {
			if ( data > 0 ) {
				alert('No existe la Subcadena');
			} else {
				setValue('hidCadenaX',-1);
				setValue('hidSubCadenaX',id);		
				irAForm('formPase','Subcadena/Listado.php','../menuConsulta.php');						
			}
		});		
	} else {
		alert('Favor de escribir un Id de SubCadena valido');	
	}
}


function BuscaCadSubCad2(){
	if(Check('rdbCadena'))
		BuscaCadena2();
	if(Check('rdbSubcadena'))
		BuscaSubCadena2();
}

function BuscaCadena2(){
	if(txtValue('txtNombreCadena') != "" && sel != -3){
		setValue('hidCadenaX',sel);
		irAForm('formPase','Cadena/Listado.php','../menuConsulta.php');
		
	}else{alert("favor de buscar una Cadena y seleccionarla");}
}

function returnListado1(){
	irAForm('formPase','Listado.php','');
}


function BuscaSubCadena2(i){
	var cadenaID = txtValue('cadena2ID');
	if ( cadenaID != "" && cadenaID >= 0 ) {
		var parametros = "idCadena="+cadenaID;
		BuscarParametros("../inc/Ajax/_Clientes/BuscaSubCadena.php",parametros,'',i);
	} else {
		alert("Favor de buscar una Cadena y seleccionarla");
	}
}

function GoSubCadena(idCad,idSub){
	if(idCad >= 0 && idSub >= 0){

		setValue('hidCadenaX',idCad);
		setValue('hidSubCadenaX',idSub);		
		irAForm('formPase','Subcadena/Listado.php','../menuConsulta.php');
		
	}else{
		alert("aguas no tiene cadena o subcadena");
	}
}
function GoCorresponsal(idCorr){
	if(idCorr > -1 ){
		setValue('hidCorresponsalX',idCorr);		
		irAForm('formPase','../Corresponsal/Listado.php','../Cadena/Listado.php');
		
	}else{
		alert("Favor de escribir un ID de Corresponsal valido");
	}
}
function GoCorresponsal2(){
	var idCorr= txtValue('ddlCorresponsales')
	if(idCorr > 0 ){
		setValue('hidCorresponsalX',idCorr);		
		irAForm('formPase','../Corresponsal/Listado.php','../Subcadena/Listado.php');
		
	}else{
		alert("Favor de escribir un ID de Corresponsal valido");
	}
}


function getInfoCorresponsal(){
	if(txtValue("ddlCad") != -1 && txtValue("ddlSubCad") != -1 && txtValue("ddlCorresponsal") != -1){
		setValue('hidCorresponsalX',txtValue("ddlCorresponsal"));
		irAForm('formPase','Corresponsal/Listado.php');	
	}else{
		if ( txtValue('ddlCad') == -1 ) {
			return alert('Falta seleccionar Cadena');
		} else if ( txtValue('ddlSubCad') == -1 ) {
			return alert('Falta seleccionar Subcadena');
		} else if ( txtValue('ddlCorresponsal') == -1 ) {
			return alert('Falta seleccionar Corresponsal');	
		}
	}
}
function getInfoCorresponsal2(){
	if(txtValue('txtNomCorr') != "" && sel2 != -3){
		setValue('hidCorresponsalX',sel2);
		irAForm('formPase','Corresponsal/Listado.php');
	}else{alert("Favor de escribir un nombre de Corresponsal valido");}
}

function getInfoCorresponsal3(){
	var idCorrX = txtValue('txtIdCorr');
	if ( idCorrX != "" && idCorrX > 0 ) {
		$.post( '../inc/Ajax/_Clientes/ChecarCorresponsal.php', { corresponsalID: idCorrX }).done( function ( data ) {
			if ( data > 0 ) {
				alert('No existe el Corresponsal');
			} else {
				setValue('hidCorresponsalX',idCorrX);
				irAForm('formPase','Corresponsal/Listado.php');						
			}
		});			
	} else {
		alert("Favor de escribir un ID de Corresponsal valido");	
	}
}

function getInfoCorresponsal4(){
	if(txtValue('txtTel') != "" && sel3 != -3){
		setValue('hidCorresponsalX',sel3);
		irAForm('formPase','Corresponsal/Listado.php');
		
	}else{alert("Favor de escribir un Telefono valido");}
}
function getInfoCorresponsal5(idCorrX){
	if(idCorrX != "" && idCorrX > 0){
		setValue('hidCorresponsalX',idCorrX);
		irAForm('formPase','Corresponsal/Listado.php');
		
	}else{alert("favor de buscar una Cadena y seleccionarla");}
}


function getOperacionesCorresponsal(id){
	setDivHTML('NomCorPopUp',"Operaciones");
	MetodoAjaxDiv("../../inc/Ajax/_Clientes/BuscaOperaciones.php","idCorresponsal="+id);
}

function getMovimientosCorresponsal(cta){
	setDivHTML('NomCorPopUp',"Movimientos de FORELO");
	MetodoAjaxDiv("../../inc/Ajax/_Clientes/BuscaMovimientos.php","numcta="+cta);
}

function getDepositosCorresponsal(cta){
	setDivHTML('NomCorPopUp',"Depositos");
	MetodoAjaxDiv("../../inc/Ajax/_Clientes/BuscaDepositos.php","numcta="+cta);
}

function getRemesasCorresponsal(id){
	setDivHTML('NomCorPopUp',"Remesas Pendientes");
	MetodoAjaxDiv("../../inc/Ajax/_Clientes/BuscaRemesas.php","idCorresponsal="+id);
}

function getDetallesCorresponsal(id){
	setDivHTML('NomCorPopUp',"Detalle Corresponsal");
	MetodoAjaxDiv("../../inc/Ajax/_Clientes/DetallesCorresponsal.php","hidCorresponsal="+id);
}

function getBancosCorresponsal(id){
	setDivHTML('NomCorPopUp',"Corresponsalias Bancarias");
	MetodoAjaxDiv("../../inc/Ajax/_Clientes/BuscaBancos.php","idCorresponsal="+id);
}

function getBancosCorresponsaliaBancaria(){
	var id = txtValue("idCorresponsal");
	BuscarParametros("../../inc/Ajax/_Clientes/BuscaBancosCorresponsalia.php","idCorresponsal="+id,"divcorrbanc");
}

function BuscaCorresponsalDir(i){
	var pais = txtValue("ddlPais");
	if(pais > -2){
		var edo = txtValue("ddlEstado");
		if(edo > -2){
			var cd = txtValue("ddlMunicipio");
			if(cd > -2){
				var col = txtValue("ddlColonia");
				var parametros = "idpais="+pais+"&idedo="+edo+"&idcd="+cd+"&idcol="+col;
				BuscarParametros("../../inc/Ajax/_Clientes/BuscaCorresponsalXDirecc.php",parametros,"divRES",i);
			}else{alert("Favor de seleccionar una ciudad");}	
		}else{alert("Favor de seleccionar un estado");}
	}else{alert("Favor de seleccionar un pais");}
}

function irAVersio(id,rutaVuelta){
	if(id > 0){
		setValue('hidVersionX',id);
		
		irAForm('formPase','../../_Comercial/Comisiones/Versiones/Listado.php',rutaVuelta);
	}else{
		alert("aguas no tiene cadena o subcadena");
	}
}

function verCorresponsalesPopUp(idCade,idSubcadena,cantidad,nombreSub){
	if(idCade >=0 && idSubcadena > -1){
		console.log(nombreSub);
		//nombreSub = utf8_encode(nombreSub);
		console.log(nombreSub);
		setDivHTML('NomCorPopUp',"Corresponsales");
		MetodoAjaxDiv("../../inc/Ajax/_Clientes/VerCorresponsales.php","idCadena="+idCade+"&idSubcadena="+idSubcadena+"&cantidad="+cantidad+"&nombreSub="+nombreSub);
	}else{alert("no tienes cadena ni subcadena, favor de verificar");}
}

function irAEditar(){
	irAForm('formPase','Editar.php');
}

function MostrarTelEditar(){
	DisplayNone("divTel");
	DisplayBlock("divEditTel");	
}
function OcultarTelEditar(){
	DisplayNone("divEditTel");
	DisplayBlock("divTel");
}

function goOperadores(){
	irAForm('formPase','../../_Sistemas/Webpos/Listado.php','../../_Clientes/Corresponsal/Listado.php');
}
function goEquipos(){
	irAForm('formPase','../../_Sistemas/Equipos/Listado.php','../../_Clientes/Corresponsal/Listado.php');
}
function goMovimientos(idTipoMovi){
	setValue('hidTipoMovX',idTipoMovi);
	irAForm('formPase','../../_Reportes/Movimientos/Listado.php','../../_Clientes/Corresponsal/Listado.php');
}
function goMovimientosPorCta(cta,idTipoMovi){
	setValue('hnumCtaX',cta);
	setValue('hidTipoMovX',idTipoMovi);
	setValue('hidCorresponsalX',-1);
	irAForm('formPase','../../_Reportes/Movimientos/Listado.php','../../_Clientes/Subcadena/Listado.php');
}
function goOperaciones(){
	irAForm('formPase','../../_Reportes/Operaciones/Listado.php','../../_Clientes/Corresponsal/Listado.php');
}
function goProductos(){
	irAForm('formPase','../../_Comercial/Productos/Listado.php','../../_Clientes/Corresponsal/Listado.php');
}
function goContratos(numContrato){
	setValue('hnumContratoX',numContrato);
	irAForm('formPase','../../_Legal/Contratos/Listado.php','../../_Clientes/Corresponsal/Listado.php');
}
function goRepreLegal(idRepLegal){
	setValue('hidRepLegX',idRepLegal);
	irAForm('formPase','../../_Legal/RepresLegal/Listado.php','../../_Clientes/Corresponsal/Listado.php');
}


function Persiana(bandPersiana){
	if(bandPersiana)
		$("#NewContacto").slideUp("normal");
	else
		$("#NewContacto").slideDown("normal");
}

function validar_email(valor){
	// creamos nuestra regla con expresiones regulares.
	var filter = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
	// utilizamos test para comprobar si el parametro valor cumple la regla
	if(filter.test(valor))
		return true;
	else
		return false;
}
/*Actualizaciones de datos ....*/
function UpdateCadena(idCade,idcampo,tipoCliente) {
	if ( document.getElementById("ddlGrupo") ) {
		var grupo			= txtValue("ddlGrupo");
	} else {
		grupo = null;	
	}
	var nombreCadena	= txtValue("txtNombreCadena");
	if ( document.getElementById("ddlGiro") ) {
		var giro			= txtValue("ddlGiro");
	} else {
		giro = null;	
	}
	var estatus			= txtValue("ddlEstatus");
	var telefono		= txtValue("txtTelCadena");
	var correo			= txtValue("txtCorreo");
	var ejecutivo		= txtValue("ddlEjecutivo");
	var ejecutivoVenta	= txtValue("ddlEjecutivoVenta");
	var referencia		= txtValue("ddlReferencia");
	if ( document.getElementById("idGrupoOriginal") ) {
		var gpoOriginal		= txtValue("idGrupoOriginal");
	}
	var deletePermisos = false;
	
	if(referencia <= -1){
		alert("Seleccione Referencia");
		return false;
	}

	if(telefono.length < 15){
		alert("Introduzca un Tel\u00E9fono v\u00E1lido");
		return false;
	}

	if(grupo < 0){
		alert("Seleccione Grupo");
		return false;
	}

	if(ejecutivo <= 0){
		alert("Seleccione Ejecutivo de Cuenta");
		return false;
	}

	if(ejecutivoVenta <= 0){
		alert("Seleccione Ejecutivo de Venta");
		return false;
	}

	if(gpoOriginal != grupo){
		var btn = confirm("Si cambia de Grupo las configuraciones de permisos se perder\u00E1n,\n\u00BFEst\u00E1 seguro que desea continuar?");
		if(btn == false){
			return false;
		}
		else{
			deletePermisos = true;
		}
	}

	if(validar_email(correo) || correo == ""){
		editarInfo("../../inc/Ajax/_Clientes/UpdateCadena.php","cadena="+idCade+"&grupo="+grupo+"&nombreCadena="+nombreCadena+"&giro="+giro+"&estatus="+estatus+"&telefono="+telefono+"&correo="+correo+"&idEjecutivo="+ejecutivo+"&idTipoCliente="+tipoCliente+"&idEjecutivoVenta="+ejecutivoVenta+"&idReferencia="+referencia+"&deletePermisos="+deletePermisos+"&idGrupoOriginal="+gpoOriginal);
	}
	else{
		alert("Introduzca un formato de correo v\u00E1lido");
	}
}

/* actualiza ejecutivo de cuenta de cadena, cadena y corresponsal*/
function UpdateEjecutivo(idCliente,tipoCliente){
	var valor = txtValue("ddlEjecutivo");
	if(valor != -2){
		var valor2 = getTextSelect("ddlEjecutivo");
		var parametros = "id="+idCliente+"&idEjecutivo="+valor+"&idTipoCliente="+tipoCliente;
		
		MetodoAjaxUpdateDiv("../../inc/Ajax/_Clientes/UpdateEjecutivoClientes.php",parametros,"lblEjecutivoCta",valor2);
		
	}else{alert("Favor de seleccionar un Ejecutivo de Cuenta");}
}

/* actualiza contactos*/
function UpdateContactos(idCadSubCor,idTipoCliente){
	var NomC = txtValue("txtContacNom");
	if(NomC.trim() != ""){
		var apPC = txtValue("txtContacAP");
		if(apPC.trim() != ""){
			var apMC = txtValue("txtContacAM");
			if(apMC.trim() != ""){
				var telC = txtValue("txtTelContac");
				if(telC.trim() != "" && validaTelefono("txtTelContac")){
					
					var mailC = txtValue("txtMailContac");
					if(mailC.trim() != "" && validarEmail("txtMailContac")){
						var tipoC = txtValue("ddlTipoContac");
						if(tipoC > -1){

							var idContac = txtValue("HidContacto");
							var extension = txtValue("txtExtTelContac");
							var parametros = "id="+idCadSubCor+"&idContacto="+idContac+"&NomC="+NomC+"&apPC="+apPC+"&apMC="+apMC+"&telC="+telC+"&mailC="+mailC+"&tipoC="+tipoC+"&idTipoCliente="+idTipoCliente+"&extension="+extension;
							//alert(parametros);
							/*el 1 es para cadenas el 2 es para subcadenas y el 3 para corresponsales PARA LAS BUSQUEDAS DE CONTACTOS*/
							MetodoAjaxContactos("../../inc/Ajax/_Clientes/UpdateContactosClientes.php",parametros,idTipoCliente,idCadSubCor);
							
						}else{alert("Favor de seleccionar un Tipo de Contacto");}	
					}else{alert("Favor de escribir un correo valido para el Contacto");}	
				}else{alert("Favor de escribir un telefono valido para el Contacto");}	
			}else{alert("Favor de escribir un apellido materno para el Contacto");}	
		}else{alert("Favor de escribir un apellido paterno para el Contacto");}	
	}else{alert("Favor de escribir un nombre de Contacto");}
}

function DeleteContactos(idCliente,idContacto,tipoCliente){
	if(confirm('\u00BFDesea Eliminar el Contacto?')){
		var parametros = "tipoCliente="+tipoCliente+"&id="+idCliente+"&idContacto="+idContacto;
		MetodoAjaxContactos("../../inc/Ajax/_Clientes/DeleteContacto.php",parametros,tipoCliente,idCliente);
	}
}

/*Actualizaciones de datos de la subcadena*/
function UpdateSubCadena(idSubCade,idcampo,tipoCliente){
	if ( document.getElementById("ddlGrupo") ) {
		var grupo = txtValue("ddlGrupo");
	} else {
		var grupo = null;	
	}
	var nombreSubCadena	= txtValue("txtNombreSubCadena");
	if ( document.getElementById("ddlGiro") ) {
		var giro = txtValue("ddlGiro");
	} else {
		var giro = null;	
	}
	var estatus			= txtValue("ddlEstatus");
	var ejecutivo		= txtValue("ddlEjecutivo");
	var ejecutivoVenta	= txtValue("ddlEjecutivoVenta");
	var referencia		= txtValue("ddlReferencia");
	var iva				= txtValue("ddlIva");

	if ( document.getElementById("ddlVersion") ) {
		var idVersion = txtValue("ddlVersion");
	} else {
		var idVersion =	null;
	}
	if ( document.getElementById("idVersionOriginal") ) {
		var idVersionOriginal = txtValue("idVersionOriginal");
	} else {
		var idVersionOriginal = null;
	}
	var tel = txtValue("txttel1");
	var correo = txtValue("txtMailSubCadena");

	if(referencia <= -1){
		alert("Seleccione Referencia");
		return false;
	}

	var telefono = tel.trim();
	if(telefono.length < 15){
		alert("Introduzca un tel\u00E9fono v\u00E1lido");
		return false;
	}

	if(ejecutivo <= 0){
		alert("Seleccione Ejecutivo de Cuenta");
		return false;
	}

	if(ejecutivoVenta <= 0){
		alert("Seleccione Ejecutivo de Venta");
		return false;
	}

	if(!validar_email(correo)){
		alert("El Correo no tiene un formato v\u00E1lido");
		return false;
	}

	if(idVersion <= -1){
		alert("Seleccione una Versi\u00F3n");
		return false;
	}

	if(iva <= -1 && iva != null){
		alert("Seleccione IVA");
		return false;
	}

	if(idVersion == -2){idVersion = 0;}
	
	editarInfo("../../inc/Ajax/_Clientes/UpdateSubCadena.php","subcadena="+idSubCade+"&grupo="+grupo+"&nombreSubCadena="+nombreSubCadena+"&giro="+giro+"&estatus="+estatus+"&idEjecutivo="+ejecutivo+"&idTipoCliente="+tipoCliente+"&idEjecutivoVenta="+ejecutivoVenta+"&idReferencia="+referencia+"&idVersion="+idVersion+"&idVersionOriginal="+idVersionOriginal+"&telefono="+telefono+"&correo="+correo+"&iva="+iva);
}

function agregarCorresponsaliaBanc(idcorresponsal){
	var parametros = "";
	var idbanco = txtValue("ddlBanco");
	//var idactividad = sel3;
	//var iddatgeo = txtValue("ddlEntDiv");

	if(idbanco <= 0){
		alert("Seleccione Banco");
		return false;
	}

	parametros = "idCorresponsal="+idcorresponsal+"&idBanco="+idbanco;

	MetodoAjax2("../../inc/Ajax/_Clientes/AgregarCorresponsaliaBancaria.php",parametros);
	window.setTimeout("getBancosCorresponsaliaBancaria()",200);
	window.setTimeout("getDdlBanco()",200);
}

function eliminarCorresponsaliaBanc(id){
	MetodoAjax2("../../inc/Ajax/_Clientes/EliminarCorresponsaliaBancaria.php","idCorresponsalBanco="+id);
	window.setTimeout("getBancosCorresponsaliaBancaria()",200);
	window.setTimeout("getDdlBanco()",200);
}

function esValido(valor){
	if(valor != "" && valor != undefined){
		return true;
	}
	else{
		return false;
	}
}

function UpdateCorresponsal(iddato, tipoCliente){
	var parametros				= "";
	var idCorresponsal			= txtValue("idCorresponsal");
	var nombreCorresponsal		= txtValue("txtnomcor");
	var telefono1				= txtValue("txttel1");
	var telefono2				= txtValue("txttel2");
	var fax						= txtValue("txtfax");
	var correo					= txtValue("txtmail");
	var fechaVencimiento		= txtValue("txtFechaVenc");
	var giro					= txtValue("ddlGiro");
	var referencia				= txtValue("ddlReferencia");
	var estatus					= txtValue("ddlEstatus");
	var corresponsaliaBancaria	= txtValue("ddlCorBanc");
	var usuarioAlta				= sel5;
	var ejecutivoVenta			= $("#ddlEjecutivoVenta").val();
	var ejecutivoCuenta			= $("#ddlEjecutivo").val();
	var representanteLegal		= $("#ddlRepLegal").val();
	var calle					= txtValue("txtcalle");
	var numeroExterior			= txtValue("txtnext");
	var numeroInterior			= txtValue("txtnint");
	var iva						= $("#ddlIva").val();

	if(!esValido(telefono1)){
		alert("Agregue Teléfono 1 ");return false;
	}
	if(!esValido(telefono2)){
		alert("Agregue Teléfono 2");return false;
	}
	if(!esValido(fechaVencimiento)){
		alert("Agregue Fecha de Vencimiento");return false;
	}
	if(!esValido(giro) || giro < 0){
		alert("Seleccione Giro");return false;
	}
	if(!esValido(estatus)){
		alert("Seleccione Estatus");return false;
	}
	if(!esValido(corresponsaliaBancaria)){
		alert("Seleccione Corresponsal Bancario");return false;
	}
	if(!esValido(ejecutivoVenta) || ejecutivoVenta <= 0){
		alert("Seleccione Ejecutivo de Venta");return false;
	}
	if(!esValido(ejecutivoCuenta) || ejecutivoCuenta <= 0){
		alert("Seleccione Ejecutivo de Cuenta");return false;
	}
	if(!esValido(representanteLegal) || representanteLegal <= 0){
		alert("Agregue Representante Legal");return false;
	}
	if(!esValido(calle) || calle <= 0){
		alert("Agregue Calle");return false;
	}
	if(!esValido(numeroExterior) || numeroExterior <= 0){
		alert("Agregue Número Exterior");return false;
	}
	if(!esValido(numeroInterior) || numeroInterior <= 0){
		alert("Agregue Número Interior");return false;
	}

	if(tipoDireccion == "nacional"){
		var colonia		= txtValue("ddlColonia");
		var estado		= txtValue("ddlEstado");
		var municipio	= txtValue("ddlMunicipio");		
	}
	else{
		var colonia		= txtValue("txtColonia");
		var estado		= txtValue("txtEstado");
		var municipio	= txtValue("txtMunicipio");		
	}

	var pais				= txtValue("ddlPais");
	var codigoPostal		= txtValue("txtcp");
	var nombreSucursal		= txtValue("txtnombresucursal");
	var numeroSucursal		= txtValue("txtnumerosucursal");
	//var banco				= txtValue("ddlBanco");
	//var actividadBanco		= txtValue("txtactbanc");
	//var divisionGeografica	= txtValue("ddlEntDiv");

	if(!esValido(colonia) || colonia <= 0){
		alert("Seleccione Colonia");return false;
	}
	if(!esValido(estado) || estado <= 0){
		alert("Seleccione Estado");return false;
	}
	if(!esValido(municipio) || municipio <= 0){
		alert("Seleccione Municipio");return false;
	}
	if(!esValido(pais) || pais <= 0){
		alert("Seleccione País");return false;
	}
	if(!esValido(codigoPostal) || codigoPostal <= 0){
		alert("Agregue Código Postal");return false;
	}
	if(!esValido(nombreSucursal) || nombreSucursal <= 0){
		alert("Agregue Nombre de Sucursal");return false;
	}
	if(!esValido(iva) || iva <= 0){
		alert("Seleccione Iva");return false;
	}

	parametros += "idCorresponsal="+idCorresponsal+"&nombreCorresponsal="+nombreCorresponsal+"&telefono1="+telefono1+"&telefono2="+telefono2+"&fax="+fax+"&correo="+correo+"&fechaVencimiento="+fechaVencimiento+"&giro="+giro+"&referencia="+referencia+"&estatus="+estatus+"&corresponsaliaBancaria="+corresponsaliaBancaria+"&usuarioAlta="+usuarioAlta+"&ejecutivoVenta="+ejecutivoVenta+"&representanteLegal="+sel3+"&calle="+calle+"&numeroExterior="+numeroExterior+"&numeroInterior="+numeroInterior+"&colonia="+colonia+"&pais="+pais+"&estado="+estado+"&municipio="+municipio+"&codigoPostal="+codigoPostal+"&nombreSucursal="+nombreSucursal+"&numeroSucursal="+numeroSucursal+/*"&banco="+banco+"&actividadBanco="+actividadBanco+"&divisionGeografica="+divisionGeografica+*/"&ejecutivoCuenta="+ejecutivoCuenta+"&iva="+iva;
	MetodoAjax4("../../inc/Ajax/_Clientes/ActualizaCorresponsal.php",parametros);
	window.setTimeout("UpdateDirC()",200);
}


function UpdateDirC(){
	var d = "";
	d+= getDivHTML("calle")+" No. "+getDivHTML("nexte")+" No. int "+getDivHTML("ninte")+" Col. "+getDivHTML("colonia")+", "+getDivHTML("municipio")+", "+getDivHTML("estado")+" C.P. "+getDivHTML("cp")
	document.getElementById("dircompleta").innerHTML = d;
}




/*Update Horarios de los corresponsales*/
function UpdateHorariosCorr(idCorr){
		
	var parametros = "idCorresponsal="+idCorr;
	var DE1 = txtValue("txt1");
	var DE2 = txtValue("txt3");
	var DE3 = txtValue("txt5");
	var DE4 = txtValue("txt7");
	var DE5 = txtValue("txt9");
	var DE6 = txtValue("txt11");
	var DE7 = txtValue("txt13");
	
	var A1 = txtValue("txt2");
	var A2 = txtValue("txt4");
	var A3 = txtValue("txt6");
	var A4 = txtValue("txt8");
	var A5 = txtValue("txt10");
	var A6 = txtValue("txt12");
	var A7 = txtValue("txt14");
	
	
	if(validaHorasDia(DE1,A1,"txt2","Lunes")){
		if(validaHorasDia(DE2,A2,"txt4","Martes")){
			if(validaHorasDia(DE3,A3,"txt6","Miercoles")){
				if(validaHorasDia(DE4,A4,"txt8","Jueves")){
					if(validaHorasDia(DE5,A5,"txt10","Viernes")){
						if(validaHorasDia(DE6,A6,"txt12","Sabado")){
							if(validaHorasDia(DE7,A7,"txt14","Domingo")){
								
								parametros += "&DE1='"+DE1+"'&DE2='"+DE2+"'&DE3='"+DE3+"'&DE4='"+DE4+"'&DE5='"+DE5+"'&DE6='"+DE6+"'&DE7='"+DE7+"'";
								parametros += "&A1='"+txtValue("txt2")+"'";
								parametros += "&A2='"+txtValue("txt4")+"'";
								parametros += "&A3='"+txtValue("txt6")+"'";
								parametros += "&A4='"+txtValue("txt8")+"'";
								parametros += "&A5='"+txtValue("txt10")+"'";
								parametros += "&A6='"+txtValue("txt12")+"'";
								parametros += "&A7='"+txtValue("txt14")+"'";
								
								//alert(parametros);
								editarCorresponsal = true;
								MetodoAjax2("../../inc/Ajax/_Clientes/UpdateHorarios.php",parametros);
							}
							else{
								editarCorresponsal = false;
								return false
							}
						}
						else{
							editarCorresponsal = false;
							return false
						}
					}
					else{
						editarCorresponsal = false;
						return false
					}
				}
				else{
					editarCorresponsal = false;
					return false
				}
			}
			else{
				editarCorresponsal = false;
				return false
			}
		}
		else{
			editarCorresponsal = false;
			return false
		}
	}
	else{
		editarCorresponsal = false;
		return false
	}
}
function validaHorasDia(valorDe,valorA,txt,dia){
	if(valorDe != "")
		if(valorA != "")
			if(validaHorasRegex(valorDe))
				if(validaHorasRegex(valorA))
					return true;
				else{
					alert("Favor de escribir la Hora de Cierre correctamente del " + dia + ". Ejemplo: hh:mm en formato 24 horas.");
					return false;
				}
			else{
				alert("Favor de escribir la Hora de Inicio correctamente del " + dia + ". Ejemplo: hh:mm en formato 24 horas.");
				return false;
			}
		else{
			alert("Favor de escribir la Hora de Cierre del " + dia + ". Ejemplo: hh:mm en formato 24 horas.");
			return false;
		}
	else
		setValue(txt,'');

	return true;
}
var tipocreacion = 0;
function CrearGeneral(j){
	$("#tablacrear").fadeIn("normal");
	switch(tipoconsulta){
		case 0:document.getElementById("snombre").innerHTML = "Nombre Cadena";if(j == true){CrearPreCadena();}
			break;
		case 1:document.getElementById("snombre").innerHTML = "Nombre SubCadena";if(j == true){CrearPreSubCadena();}
			break;
		case 2:document.getElementById("snombre").innerHTML = "Nombre Corresponsal";if(j == true){CrearPreCorresponsal();}
			break;
	}
	
}

function BuscarPreCadenas(i){
	BuscarParametros("../../inc/Ajax/_Clientes/BuscarPreCadenas.php","","divRES",i);
}

function CrearPreCadena(){
	var nombre = txtValue("txtnombre");
	if ( nombre != '' && validaCadenaNumero(nombre) ) {
		MetodoAjax3("../../inc/Ajax/_Clientes/CrearPreCadena.php","nombre="+nombre,"Cadena/Crear.php");
	} else {
		alert("El nombre de la cadena es invalido");
	}
}

function CrearPreSubCadena(){
	var nombre = txtValue("txtnombre");
	if ( nombre != '' && validaCadenaNumero(nombre) ) {
		MetodoAjax3("../../inc/Ajax/_Clientes/CrearPreSubCadena.php","nombre="+nombre,"Subcadena/Crear.php");
	} else {
		alert("El nombre de la subcadena es invalido");
	}
}

function CrearPreCorresponsal(){	
	var nombre = txtValue("txtnombre");
	if ( nombre != '' && validaCadenaNumero(nombre) ) {
		MetodoAjax3("../../inc/Ajax/_Clientes/CrearPreCorresponsal.php","nombre="+nombre, "Corresponsal/Crear.php");
	} else {
		alert("El nombre del corresponsal es invalido");
	}
}

function BuscaPreCadena(){
	var nombre = txtValue("txtNombreCadena");
	if(nombre != "" && sel2 != -3){
		BuscarParametros("../../inc/Ajax/_Clientes/BuscaPreCadena.php","idCadena="+sel2);
	}
}

function BuscarPreSubCadenas(i){
	BuscarParametros("../../inc/Ajax/_Clientes/BuscarPreSubCadenas.php","","divRES",i);
}

function BuscaPreSubCadena(i){
	var nombre = txtValue("txtNombre");
	var idcad = "";
	if(sel2 > -1)
		idcad = sel2;
	if(nombre != "" || sel2 != -3){
		BuscarParametros("../../inc/Ajax/_Clientes/BuscaPreSubCadena.php","idCadena="+idcad+"&nombre="+nombre,"",i);
	}
}

function BuscarPreCorresponsal(i){
	BuscarParametros("../../inc/Ajax/_Clientes/BuscaPreCorresponsales.php","","divRES",i);
}

function BuscaPreCorresponsal1(){
	var nombre = txtValue("txtNombrePreCorr");
	if(nombre != "" && sel != -3){
		BuscarParametros("../../inc/Ajax/_Clientes/BuscaPreCorresponsales.php","idPreClave="+sel);
	}
}
function BuscaPreCorresponsal2(){
	var nombre = txtValue("txtNombreCadena");
	if(nombre != "" && sel2 != -3){
		BuscarParametros("../../inc/Ajax/_Clientes/BuscaPreCorresponsales.php","idCadena="+sel2);
	}
}
function BuscaPreCorresponsal3(){
	var nombre = txtValue("txtPreSubCorr");
	if(nombre != "" && sel3 != -3){
		BuscarParametros("../../inc/Ajax/_Clientes/BuscaPreCorresponsales.php","nombreSub="+nombre);
	}
}

/*  Funciones de Guardar y Editar Prealta Cadena */


function Guardar1(){
	alert("Guardar1")
}

function CambioPagina( i, existenCambios ) {
	var r;
	if ( existenCambios ) {
		r = confirm('Est\u00E1 a punto de ir a otro paso. Perder\u00E1 todos los cambios que no haya guardado. ¿Desea continuar?');
	} else {
		r = true;
	}
	if ( r ) {
		switch ( i ) {
			case 0:
				window.location = "Crear.php";
			break;
			case 1:
				window.location = "Crear1.php";
			break;
			case 2:
				window.location = "Crear2.php";
			break;
			case 3:
				window.location = "Crear3.php";
			break;
			case 4:
				window.location = "Crear4.php";
			break;
			case 5:
				window.location = "CrearResumen.php";
			break;
		}
	}
}

function VerificarGrls(){
	var permitirGuardarCambios = false;
	if(txtValue("ddlGrupo") > -1) {
		document.getElementById("grupook").style.visibility = "visible";
		permitirGuardarCambios = true;
	} else {
		document.getElementById("grupook").style.visibility = "hidden";
	}
	if(txtValue("ddlReferencia") > -1) {
		document.getElementById("refok").style.visibility = "visible";
		permitirGuardarCambios = true;
	} else {
		document.getElementById("refok").style.visibility = "hidden";
	}
	if (txtValue("txttel1") != '' && validaTelefono("txttel1")) {
		document.getElementById("tel1ok").style.visibility = "visible";
		permitirGuardarCambios = true;
	} else {
		document.getElementById("tel1ok").style.visibility = "hidden";
	}
	if(txtValue("txtmail") != '' && validarEmail('txtmail')) {
		document.getElementById("mailok").style.visibility = "visible";
		permitirGuardarCambios = true;
	} else {
		document.getElementById("mailok").style.visibility = "hidden";
	}
	if ( txtValue("txttel1") == '52-' ) {
		document.getElementById("txttel1").value = "";	
	}
	if ( permitirGuardarCambios ) {
		if ( document.getElementById("guardarCambios") ) {
			document.getElementById("guardarCambios").style.visibility = "visible";
		}
	} else {
		if ( document.getElementById("guardarCambios") ) {
			document.getElementById("guardarCambios").style.visibility = "hidden";
		}
	}
}

function RellenarTelefono() {
	if ( txtValue("txttel1") == '' ) {
		document.getElementById("txttel1").value = "52-";
		$("#txttel1").putCursorAtEnd();
	}
}

function EditarGrlsPreCadena(id){
	var grupo = txtValue("ddlGrupo");
	var ref = txtValue("ddlReferencia");
	var tel1 = txtValue("txttel1");
	var mail = txtValue("txtmail");
	var band = true;
	var parametros = "idpreclave="+id;
	if(grupo > -1){
		parametros+="&idgrupo="+grupo;
		if(ref > -1){
			parametros+="&idref="+ref;
			if(tel1 != ''){
				if(validaTelefono("txttel1")){
					parametros+="&tel1="+tel1;
					if(mail != ''){
						if(validarEmail("txtmail")){
							parametros+="&mail="+mail;							
						}else{
							band = false;
							alert("El Correo Electr\u00F3nico es incorrecto")
						}
					}
				}else{
					band = false;
					alert("El n\u00FAmero de Tel\u00E9fono no es correcto")
				}
			}
		}else{
			band = false;
			alert("Favor de seleccionar la Referencia de la Cadena");	
		}
	}else{
		band = false;
		alert("Favor de seleccionar el Grupo de la Cadena");
	}
	if(band){
		MetodoAjax2("../../inc/Ajax/_Clientes/EditarGrlsPreCadena.php",parametros);
	}
}

function EditarEjecutivosPreCadena(){
	
	var parametros = "f=0";
	if(sel3 > -1){
		parametros+="&idecuenta="+sel3;
	}
	if(sel2 > -1){
		parametros+="&ideventa="+sel2;
	}
	if(sel3 > -1 || sel2 > -1){
		MetodoAjax2("../../inc/Ajax/_Clientes/EditarEjecutivosPreCadena.php",parametros);
		window.setTimeout("Recargar()",100)
	}
	
}

function Recargar(){
	window.location.reload();
}

function BuscarPreContactos(){
	BuscarParametros2("../../inc/Ajax/_Clientes/BuscarPreContactos.php",'','divRES');
}

function BuscarPreContactos2(){
	BuscarParametros2("../../inc/Ajax/_Clientes/BuscarPreContactos2.php",'','divRES');
}

var bandedcont = 0;
function DesPreContactos(id){
	if(bandedcont == 0)
		AgregarPreContactos();
	if(bandedcont == 1)
		EditarPreContacto(id,1);
}

function LimpiarPreContactos(value){
	document.getElementById("txtnombre").value = "";
	document.getElementById("txtpaterno").value = "";
	document.getElementById("txtmaterno").value = "";
	document.getElementById("txttelefono").value = "";
	document.getElementById("txtext").value = "";
	document.getElementById("txtcorreo").value = "";
	document.getElementById("ddlTipoContacto").value = -1;
	bandedcont = 0;
	if ( value ) {
		$('#agregarcontacto').slideDown('normal');
		if ( document.getElementById("guardarCambios") ) {
			document.getElementById('guardarCambios').style.visibility = "visible";
		}
		if ( document.getElementById("nuevoContacto") ) {
			document.getElementById('nuevoContacto').style.display = "none";	
		}
	} else {
		$('#agregarcontacto').slideUp('normal');
		if ( document.getElementById("guardarCambios") ) {
			document.getElementById('guardarCambios').style.visibility = "hidden";
		}
	}
}

function AgregarPreContactos(){
	var nombre = txtValue("txtnombre");
	var paterno = txtValue("txtpaterno");
	var materno = txtValue("txtmaterno");
	var telefono = txtValue("txttelefono");
	var ext = txtValue("txtext");
	var correo = txtValue("txtcorreo");
	var tipocontacto = txtValue("ddlTipoContacto");
	var parametros = "";
	if(nombre != '' && paterno != '' && materno != '' && telefono != '' && correo != '' && txtValue("ddlTipoContacto") > -1){
		if(validaTelefono("txttelefono")){
			if(validarEmail("txtcorreo")){
				parametros+= "nombre="+nombre+"&paterno="+paterno+"&materno="+materno+"&telefono="+telefono+"&ext="+ext+"&correo="+correo+"&tipocontacto="+tipocontacto;
				MetodoAjax2("../../inc/Ajax/_Clientes/CrearPreContacto.php",parametros);
				
				window.setTimeout("VerificaContAd()",100);
				
			}else{
				alert("El correo electronico es incorrecto");
			}
			
		}else{
			alert("El telefono es incorrecto");	
		}
	}else{
		alert("Favor de llenar todos los datos requeridos marcados con asterisco (*)")
	}
}

function VerificaContAd(){
	if(contad == 0){
		window.setTimeout("LimpiarPreContactos(false)",40);
		window.setTimeout("BuscarPreContactos()",100);	
	}
}

function EliminarPreContacto(id){
	if(confirm("¿Esta seguro de eliminar el contacto?")){
		MetodoAjax2("../../inc/Ajax/_Clientes/EliminarPreContacto.php","id="+id)
		window.setTimeout("BuscarPreContactos()",100);
	}
	
}

var precontid = 0;

function EditarPreContacto(id,x,t){
	if(x == 0){
		precontid = id;
		var url = "../../inc/Ajax/_Clientes/EdPreContacto.php";
		if(t >= 0){
			
			if(t == 0)
				url = "../../inc/Ajax/_Clientes/EdPreContacto.php";
			if(t == 1)
				url = "../../inc/Ajax/_Clientes/EdPreContactoSubCadena.php";
			if(t == 2)
				url = "../../inc/Ajax/_Clientes/EdPreContactoCorresponsal.php";
			
			http.open("POST",url, true);
			http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				
			http.onreadystatechange=function() 
			{ 
				if (http.readyState==1)
				{
					//div para  [cargando....]
					Emergente();
				}
				if (http.readyState==4)
				{
					var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
					validaSession(RespuestaServidor);
					var valores = RespuestaServidor.split(",");
					document.getElementById("txtnombre").value = valores[0];
					document.getElementById("txtpaterno").value = valores[1];
					document.getElementById("txtmaterno").value = valores[2];
					document.getElementById("txttelefono").value = valores[3];
					document.getElementById("txtext").value = valores[4];
					document.getElementById("txtcorreo").value = valores[5];
					document.getElementById("ddlTipoContacto").value = valores[6];
					OcultarEmergente();
					$("#agregarcontacto").slideDown("normal");
				} 
			}
			http.send("id="+id);
		}
	}else{
		var nombre = txtValue("txtnombre");
		var paterno = txtValue("txtpaterno");
		var materno = txtValue("txtmaterno");
		var telefono = txtValue("txttelefono");
		var ext = txtValue("txtext");
		var correo = txtValue("txtcorreo");
		var tipocontacto = txtValue("ddlTipoContacto");
		var parametros = "id="+precontid;
		if(nombre != '' && paterno != '' && materno != '' && telefono != '' && correo != '' && txtValue("ddlTipoContacto") > -1){
			if(validaTelefono("txttelefono")){
				if(validarEmail("txtcorreo")){
					parametros+= "&nombre="+nombre+"&paterno="+paterno+"&materno="+materno+"&telefono="+telefono+"&ext="+ext+"&correo="+correo+"&tipocontacto="+tipocontacto;
					MetodoAjax2("../../inc/Ajax/_Clientes/EditarPreContacto.php",parametros);
					window.setTimeout("LimpiarPreContactos(false)",40);
					window.setTimeout("BuscarPreContactos()",100);
				}else{
					alert("El correo electronico es incorrecto");
				}
			}else{
				alert("El telefono es incorrecto")
			}
		}else{
			alert("Favor de llenar todos los datos requeridos marcados con asterisco (*)")
		}
	}
	
}


function CambioEstado(){
	BuscarParametros2("../../inc/Ajax/_Clientes/CambioEstado.php",'idpais='+txtValue('ddlPais'),'selectestados');
}

function CrearDirPreCadena( tipo ) {
	var calle = txtValue("txtcalle");
	var nint = txtValue("txtnint");
	var next = txtValue("txtnext");
	var pais = txtValue("ddlPais");
	if ( tipo == "nacional" ) {
		var edo = txtValue("ddlEstado");
		var ciudad = txtValue("ddlMunicipio");
		var colonia = txtValue("ddlColonia");
	} else if ( tipo == "extranjera" ) {
		var edo = txtValue("txtEstado");
		var ciudad = txtValue("txtMunicipio");
		var colonia = txtValue("txtColonia");
	}
	var  cp = txtValue("txtcp");
	var parametros = "f=0";
	var caracterVacio = /^\s$/i;
	
	if ( calle != '' ) {
		if ( !calle.match(caracterVacio) ) {
			parametros += "&calle="+calle;
		} else {
			alert("La Calle no puede estar vacía");
			return false;
		}
	} else {
		alert("Falta llenar la Calle");
		return false;
	}
		
	if ( !nint.match(caracterVacio) ) {
		parametros += "&nint="+nint;
	} else {
		alert("El Número Interior no puede estar vacío");
		return false;
	}
		
	if ( next != '' ) {
		if ( !next.match(caracterVacio) ) {
			parametros += "&next="+next;
		} else {
			alert("El Número Exterior no puede estar vacío");
			return false;
		}
	} else {
		alert("Falta llenar el Número Exterior");
		return false;
	}
		
	if ( pais != '' ) {
		if ( !pais.match(caracterVacio) ) {
			parametros += "&idpais="+pais;
		} else {
			alert("El País no puede estar vacío");
			return false;
		}
	} else {
		alert("Falta llenar el País");
		return false;
	}
		
	if ( edo != '' ) {
		if ( !edo.match(caracterVacio) ) {
			parametros += "&idestado="+edo;
		} else {
			alert("El Estado no puede estar vacío");
			return false;
		}
	} else {
		alert("Falta llenar el Estado");
		return false;
	}
		
	if ( ciudad != '' ) {
		if ( !ciudad.match(caracterVacio) ) {
			parametros += "&idciudad="+ciudad;
		} else {
			alert("La Ciudad no puede estar vacía");
			return false;
		}
	} else {
		alert("Falta llenar la Ciudad");
		return false;
	}

	if ( colonia != '' ) {
		if ( colonia == '-1' ) {
			alert("Falta seleccionar Colonia");
			return false;
		}
		if ( !colonia.match(caracterVacio) ) {
			parametros += "&idcolonia="+colonia;
		} else {
			alert("La Colonia no puede estar vacía");
			return false;
		}
	} else {
		alert("Falta llenar la Colonia");
		return false;
	}
		
	if ( cp != '' ) {
		if ( !cp.match(caracterVacio) ) {
			parametros += "&cp="+cp;
		} else {
			alert("El Código Postal no puede estar vacío");
			return false;
		}
	} else {
		alert("Falta llenar el Código Postal");
		return false;
	}
	parametros += "&tipodireccion=" + tipo;
	MetodoAjax2("../../inc/Ajax/_Clientes/EditarDireccionPreCadena.php",parametros);
}

//function UpdateDirPreCadena(){
//	var calle = txtValue("txtcalle");
//	var nint = txtValue("txtnint");
//	var next = txtValue("txtnext");
//	var pais = txtValue("ddlPais");
//	var edo = txtValue("ddlEstado");
//	var ciudad = txtValue("txtciudad");
//	var colonia = txtValue("txtcolonia");
//	var  cp = txtValue("txtcp");
//	var parametros = "f=0";
//	MetodoAjax2("../../inc/Ajax/_Clientes/EditarDireccionPreCadena.php",parametros);
//}


//******************** PRE SUBCADENA ********************//

function CambioPaginaSub(i){
	//verificar que se hayan guardado los cambios antes de redireccionar
	//mandar un confirm
	switch(i){
		case 0:window.location = "Crear.php"
			break;
		case 1:window.location = "Crear1.php"
			break;
		case 2:window.location = "Crear2.php"
			break;
		case 3:window.location = "Crear3.php"
			break;
		case 4:window.location = "Crear4.php"
			break
		case 5:window.location = "Crear5.php"
			break;
		case 6: window.location = "Crear6.php"
			break;
		case 7:window.location = "Crear7.php"
			break;
	}
}

function EditarGrlsPreSubCadena(){
	var idcadena = sel2;
	var giro = txtValue("ddlGiro");
	var grupo = txtValue("ddlGrupo");
	var ref = txtValue("ddlReferencia");
	var tel1 = txtValue("txttel1");
	var tel2 = txtValue("txttel2");
	var fax = txtValue("txtfax")
	var mail = txtValue("txtmail");
	var band = true;
	var parametros = "idcadena="+idcadena;
	
	if(txtValue("txtNombreCadena") != '' && sel2 > -1){
		if(giro > -1){
			parametros+="&idgiro="+giro;
			if(grupo > -1){
				parametros+="&idgrupo="+grupo;
				if(ref > -1){
					parametros+="&idref="+ref;
					if(tel1 != ''){
						if(validaTelefono("txttel1")){
							parametros+="&tel1="+tel1;
							if(mail != ''){
								if(validarEmail("txtmail")){
									parametros+="&mail="+mail;
								}else{
									band = false;
									alert("El Correo Electr\u00F3nico es incorrecto")
								}
							}else{
								band = false;
								alert("Favor de escribir el Correo Electr\u00F3nico de la Cadena");
							}
						}else{
							band = false;
							alert("El Tel\u00E9fono es incorrecto")
						}
					}else{
						band = false;
						alert("Favor de escribir el Tel\u00E9fono de la Cadena");	
					}
				}else{
					band = false;
					alert("Favor de seleccionar la Referencia de la Cadena");	
				}
			}else{
				band = false;
				alert("Favor de seleccionar el Grupo de la Cadena");
			}
		}else{
			band = false;
			alert("Favor de seleccionar el Giro de la Cadena");
		}
		if ( band ) {
			MetodoAjax2("../../inc/Ajax/_Clientes/EditarGrlsPreSubCadena.php",parametros);
			window.setTimeout("CambioNombreCadena()",100);
		}	
	}else{
		alert("Favor de seleccionar una cadena")
	}
	
}

function VerificarGrlsSub(){
	var permitirGuardarCambios = false;
	if ( txtValue("txtNombreCadena") != '' && sel > -1 ) {
		document.getElementById("cadok").style.visibility = "visible";
		permitirGuardarCambios = true;
	} else {
		document.getElementById("cadok").style.visibility = "hidden";
	}
	if ( txtValue("ddlGiro") > -1 ) {
		document.getElementById("girook").style.visibility = "visible";
		permitirGuardarCambios = true;
	} else {
		document.getElementById("girook").style.visibility = "hidden";
	}
	if ( txtValue("ddlGrupo") > -1 ) {
		document.getElementById("grupook").style.visibility = "visible";
		permitirGuardarCambios = true;
	} else {
		document.getElementById("grupook").style.visibility = "hidden";
	}
	if ( txtValue("ddlReferencia") > -1 ) {
		document.getElementById("refok").style.visibility = "visible";
		permitirGuardarCambios = true;
	} else {
		document.getElementById("refok").style.visibility = "hidden";
	}
	if ( txtValue("txttel1") != '' && validaTelefono("txttel1") ) {
		document.getElementById("tel1ok").style.visibility = "visible";
		permitirGuardarCambios = true;
	} else {
		document.getElementById("tel1ok").style.visibility = "hidden";
	}
	if ( validarEmail("txtmail") ) {
		document.getElementById("mailok").style.visibility = "visible";
		permitirGuardarCambios = true;
	} else {
		document.getElementById("mailok").style.visibility = "hidden";
	}
	if ( permitirGuardarCambios ) {
		if ( document.getElementById("guardarCambios") ) {
			document.getElementById("guardarCambios").style.visibility = "visible";
		}
	} else {
		if ( document.getElementById("guardarCambios") ) {
			document.getElementById("guardarCambios").style.visibility = "hidden";
		}
	}	
}

function VerificarDireccionSub( tipo ){
	var caracteresValidos = /^\d{5}$/i;
	var permitirGuardarCambios = false;
	if ( document.getElementById("calleok") ) {
		if ( txtValue("txtcalle") != '' ) {
			document.getElementById("calleok").style.display = "inline-block";
			permitirGuardarCambios = true;
		} else {
			document.getElementById("calleok").style.display = "none";
		}
	}
	if ( document.getElementById("nextok") ) {
		if ( txtValue("txtnext") !=  '' ) {
			document.getElementById("nextok").style.display = "inline-block";
			permitirGuardarCambios = true;
		} else {
			document.getElementById("nextok").style.display = "none";
		}
	}
	if ( tipo == "nacional" ) {
		if ( document.getElementById("ciudadok") ) {
			if ( txtValue("ddlMunicipio") > -2 && txtValue("ddlMunicipio") != "" ) {
				document.getElementById("ciudadok").style.display = "inline-block";
				permitirGuardarCambios = true;
			} else {
				document.getElementById("ciudadok").style.display = "none";
			}
		}
		if ( document.getElementById("estadook") ) {
			if ( txtValue("ddlEstado") > -2 && txtValue("ddlEstado") != "" ) {
				document.getElementById("estadook").style.display = "inline-block";
				permitirGuardarCambios = true;
			} else {
				document.getElementById("estadook").style.display = "none";
			}
		}
		if ( document.getElementById("paisok") ) {
			if ( txtValue("ddlPais") > -1 ) {
				document.getElementById("paisok").style.display = "inline-block";
				permitirGuardarCambios = true;
			} else {
				document.getElementById("paisok").style.display = "none";
			}
		}
		if ( document.getElementById("colok") ) {
			if ( txtValue("ddlColonia") > -1 ) {
				document.getElementById("colok").style.display = "inline-block";
				permitirGuardarCambios = true;
			} else {
				document.getElementById("colok").style.display = "none";
			}
		}
	}
	if ( document.getElementById("nintok") ) {
		if ( txtValue("txtnint") != '' ) {
			document.getElementById("nintok").style.display = "inline-block";
			permitirGuardarCambios = true;
		} else {
			document.getElementById("nintok").style.display = "none";
		}
	}
	if ( document.getElementById("cpok") ) {
		if ( txtValue("txtcp").match(caracteresValidos) ) {
			document.getElementById("cpok").style.display = "inline-block";
			permitirGuardarCambios = true;
		} else {
			document.getElementById("cpok").style.display = "none";
		}
	}
	if ( tipo == "extranjera" ) {
		if ( document.getElementById("colok") ) {
			if ( txtValue("txtColonia") != '' ) {
				document.getElementById("colok").style.display = "inline-block";
				permitirGuardarCambios = true;
			} else {
				document.getElementById("colok").style.display = "none";
			}
		}
		if ( document.getElementById("estadook") ) {
			if ( txtValue("txtEstado") != '' ) {
				document.getElementById("estadook").style.display = "inline-block";
				permitirGuardarCambios = true;
			} else {
				document.getElementById("estadook").style.display = "none";
			}
		}
		if ( document.getElementById("ciudadok") ) {
			if ( txtValue("txtMunicipio") != '' ) {
				document.getElementById("ciudadok").style.display = "inline-block";
				permitirGuardarCambios = true;
			} else {
				document.getElementById("ciudadok").style.display = "none";
			}
		}
	}
	if ( permitirGuardarCambios ) {
		if ( document.getElementById("guardarCambios") ) {
			document.getElementById("guardarCambios").style.visibility = "visible";
		}
	} else {
		if ( document.getElementById("guardarCambios") ) {
			document.getElementById("guardarCambios").style.visibility = "hidden";
		}
	}	
}

function VerificarCuentaSubCadena() {
	var permitirGuardarCambios = false;
	if ( txtValue("txtclabe") != '' ) {
		document.getElementById("clabeok").style.visibility = "visible";
		permitirGuardarCambios = true;
	} else {
		document.getElementById("clabeok").style.visibility = "hidden";
	}
	if ( txtValue("txtbeneficiario") !=  '' ) {
		document.getElementById("beneficiariook").style.visibility = "visible";
		permitirGuardarCambios = true;
	} else {
		document.getElementById("beneficiariook").style.visibility = "hidden";
	}
	if ( txtValue("ddlBanco") > -1 ) {
		document.getElementById("bancook").style.visibility = "visible";
		permitirGuardarCambios = true;
	} else {
		document.getElementById("bancook").style.visibility = "hidden";
	}
	if ( txtValue("txtcuenta") != '' ) {
		//document.getElementById("cuentaok").style.visibility = "visible";
		permitirGuardarCambios = true;
	} else {
		//document.getElementById("cuentaok").style.visibility = "hidden";
	}
	if ( txtValue("txtdescripcion") != '' ) {
		//document.getElementById("cuentaok").style.visibility = "visible";
		permitirGuardarCambios = true;
	} else {
		//document.getElementById("cuentaok").style.visibility = "hidden";
	}	
	if ( permitirGuardarCambios ) {
		if ( document.getElementById("guardarCambios") ) {
			document.getElementById("guardarCambios").style.visibility = "visible";
		}
	} else {
		if ( document.getElementById("guardarCambios") ) {
			document.getElementById("guardarCambios").style.visibility = "hidden";
		}
	}	
}

function CrearDirPreSubCadena( tipo ){
	var permitirGuardarCambios = true;
	var calle = txtValue("txtcalle");
	var nint = txtValue("txtnint");
	var next = txtValue("txtnext");
	var pais = txtValue("ddlPais");
	if ( tipo == "nacional" ) {
		var edo = txtValue("ddlEstado");
		var ciudad = txtValue("ddlMunicipio");
		var colonia = txtValue("ddlColonia");
	} else if ( tipo == "extranjera" ) {
		var edo = txtValue("txtEstado");
		var ciudad = txtValue("txtMunicipio");
		var colonia = txtValue("txtColonia");
	}
	var  cp = txtValue("txtcp");
	var parametros = "f=0";
	var caracterVacio = /^\s$/i;
	
	if ( calle != '' ) {
		if ( !calle.match(caracterVacio) ) {
			parametros += "&calle="+calle;
		} else {
			alert("La Calle no puede estar vacía");
			return false;
		}
	} else {
		alert("Falta llenar la Calle");
		return false;
	}
		
	if ( !nint.match(caracterVacio) ) {
		parametros += "&nint="+nint;
	} else {
		alert("El Número Interior no puede estar vacío");
		return false;
	}
		
	if ( next != '' ) {
		if ( !next.match(caracterVacio) ) {
			parametros += "&next="+next;
		} else {
			alert("El Número Exterior no puede estar vacío");
			return false;
		}
	} else {
		alert("Falta llenar el Número Exterior");
		return false;
	}
		
	if ( pais != '' ) {
		if ( !pais.match(caracterVacio) ) {
			parametros += "&idpais="+pais;
		} else {
			alert("El País no puede estar vacío");
			return false;
		}
	} else {
		alert("Falta llenar el País");
		return false;
	}
		
	if ( edo != '' ) {
		if ( !edo.match(caracterVacio) ) {
			parametros += "&idestado="+edo;
		} else {
			alert("El Estado no puede estar vacío");
			return false;
		}
	} else {
		alert("Falta llenar el Estado");
		return false;
	}
		
	if ( ciudad != '' ) {
		if ( !ciudad.match(caracterVacio) ) {
			parametros += "&idciudad="+ciudad;
		} else {
			alert("La Ciudad no puede estar vacía");
			return false;
		}
	} else {
		alert("Falta llenar la Ciudad");
		return false;
	}
		
	if ( colonia != '' ) {
		if ( colonia == '-1' ) {
			alert("Falta seleccionar Colonia");
			return false;
		}		
		if ( !colonia.match(caracterVacio) ) {
			parametros += "&idcolonia="+colonia;
		} else {
			alert("La Colonia no puede estar vacía");
			return false;
		}
	} else {
		alert("Falta llenar la Colonia");
		return false;
	}
		
	if ( cp != '' ) {
		if ( !cp.match(caracterVacio) ) {
			parametros += "&cp="+cp;
		} else {
			alert("El Código Postal no puede estar vacío");
			return false;
		}
	} else {
		alert("Falta llenar el Código Postal");
		return false;
	}
	parametros += "&tipodireccion=" + tipo;
	MetodoAjax2("../../inc/Ajax/_Clientes/EditarDireccionPreSubCadena.php",parametros);
	
}


function AgregarPreContactosSubCadena(){
	var nombre = txtValue("txtnombre");
	var paterno = txtValue("txtpaterno");
	var materno = txtValue("txtmaterno");
	var telefono = txtValue("txttelefono");
	var ext = txtValue("txtext");
	var correo = txtValue("txtcorreo");
	var tipocontacto = txtValue("ddlTipoContacto");
	var parametros = "";
	if(nombre != '' && paterno != '' && materno != '' && telefono != '' && correo != '' && txtValue("ddlTipoContacto") > -1){
		if(validaTelefono("txttelefono")){
			if(validarEmail("txtcorreo")){
				parametros+= "nombre="+nombre+"&paterno="+paterno+"&materno="+materno+"&telefono="+telefono+"&ext="+ext+"&correo="+correo+"&tipocontacto="+tipocontacto;
				MetodoAjax2("../../inc/Ajax/_Clientes/CrearPreContactoSubCadena.php",parametros);
				
				window.setTimeout("VerificaContAdSubCadena()",100);
				
			}else{
				alert("El correo electronico es incorrecto");
			}
		}else{
			alert("El Telefono es incorrecto");
		}	
	}else{
		alert("Favor de llenar todos los datos requeridos marcados con asterisco (*)")
	}
}

function VerificaContAdSubCadena(){
	if(contad == 0){
		window.setTimeout("LimpiarPreContactosSubCadena(false)",40);
		window.setTimeout("BuscarPreContactosSubCadena()",100);	
	}
}

function BuscarPreContactosSubCadena(){
	BuscarParametros2("../../inc/Ajax/_Clientes/BuscarPreContactosSubCadena.php",'','divRES');
}

function BuscarPreContactosSubCadena2(){
	BuscarParametros2("../../inc/Ajax/_Clientes/BuscarPreContactosSubCadena2.php",'','divRES');
}

var bandedcont2 = 0;
function DesPreContactosSubCadena(){
	if(bandedcont2 == 0)
		AgregarPreContactosSubCadena();
	if(bandedcont2 == 1)
		EditarPreContactoSubCadena();
}

function EliminarPreContactoSubCadena(id){
	if(confirm("¿Esta seguro de eliminar el contacto?")){
		MetodoAjax2("../../inc/Ajax/_Clientes/EliminarPreContactoSubCadena.php","id="+id)
		window.setTimeout("BuscarPreContactosSubCadena()",100);
	}
	
}

function LimpiarPreContactosSubCadena(){
	document.getElementById("txtnombre").value = "";
	document.getElementById("txtpaterno").value = "";
	document.getElementById("txtmaterno").value = "";
	document.getElementById("txttelefono").value = "";
	document.getElementById("txtext").value = "";
	document.getElementById("txtcorreo").value = "";
	document.getElementById("ddlTipoContacto").value = -1;
	bandedcont2 = 0;
	$('#agregarcontacto').slideDown('normal');
	document.getElementById('nuevoContacto').style.display = "none";
}

function EditarPreContactoSubCadena(id,x){
	if(x == 0){
		precontid = id;
		http.open("POST","../../inc/Ajax/_Clientes/EdPreContacto.php", true);
		http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			
		http.onreadystatechange=function() 
		{ 
			if (http.readyState==1)
			{
				//div para  [cargando....]
				Emergente();
			}
			if (http.readyState==4)
			{
				var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
				validaSession(RespuestaServidor);
				var valores = RespuestaServidor.split(",");
				document.getElementById("txtnombre").value = valores[0];
				document.getElementById("txtpaterno").value = valores[1];
				document.getElementById("txtmaterno").value = valores[2];
				document.getElementById("txttelefono").value = valores[3];
				document.getElementById("txtext").value = valores[4];
				document.getElementById("txtcorreo").value = valores[5];
				document.getElementById("ddlTipoContacto").value = valores[6];
				OcultarEmergente();
				$("#agregarcontacto").slideDown("normal");
			} 
		}
		http.send("id="+id);
		
		
	}else{
		var nombre = txtValue("txtnombre");
		var paterno = txtValue("txtpaterno");
		var materno = txtValue("txtmaterno");
		var telefono = txtValue("txttelefono");
		var ext = txtValue("txtext");
		var correo = txtValue("txtcorreo");
		var tipocontacto = txtValue("ddlTipoContacto");
		var parametros = "id="+precontid;
		if(nombre != '' && paterno != '' && materno != '' && telefono != '' && correo != '' && txtValue("ddlTipoContacto") > -1){
			if(validaTelefono("txttelefono")){
				if(validarEmail("txtcorreo")){
					parametros+= "&nombre="+nombre+"&paterno="+paterno+"&materno="+materno+"&telefono="+telefono+"&ext="+ext+"&correo="+correo+"&tipocontacto="+tipocontacto;
					MetodoAjax2("../../inc/Ajax/_Clientes/EditarPreContactoSubCadena.php",parametros);
					window.setTimeout("LimpiarPreContactos(false)",40);
					window.setTimeout("BuscarPreContactosSubCadena()",100);
				}else{
					alert("El correo electronico es incorrecto");
				}
			}else{
				alert("El telefono es incorrecto");
			}
			
			
		}else{
			alert("Favor de llenar todos los datos")
		}
	}
	
}

function CambioNombreCadena(){
	document.getElementById("dcadena").innerHTML = txtValue("txtNombreCadena");
}

function EditarCuentaBancoSubCadena(){
	var banco = txtValue("ddlBanco");
	var clabe = txtValue("txtclabe");
	var beneficiario = txtValue("txtbeneficiario");
	var cuenta = txtValue("txtcuenta");
	var descripcion = txtValue("txtdescripcion");
	var parametros = "f=0";
	var band = false;
	if(banco > -1){
		parametros+="&idbanco="+banco;
		if(clabe != ''){
			parametros+="&clabe="+clabe;
			if(beneficiario != ''){
				parametros+="&beneficiario="+beneficiario;
				band = true;
			}else{
				alert("Favor de escribir el nombre del Beneficiario");
			}
		}else{
			alert("Favor de escribir la CLABE");
		}
	}else{
		alert("Favor de seleccionar un Banco");
	}
	
	if(band){
		if(cuenta != '')
			parametros+="&cuenta="+cuenta;
		if(descripcion != '')
			parametros+="&descripcion="+descripcion
		MetodoAjax2("../../inc/Ajax/_Clientes/EditarCuentaPreSubCadena.php",parametros);
		
	}
	
}

function CargarArchivos(){
	var band = true;
	var equivocados = "";
	if(Existe("fudomicilio") && document.getElementById("fudomicilio").value != ''){
		if(!filtrarArchivos("fudomicilio")){
			band = false;
			equivocados+= "\n Comprobante de domicilio";
		}
	}
	if(Existe("fudfiscal") && document.getElementById("fudfiscal").value != ''){
		if(!filtrarArchivos("fudfiscal")){
			band = false;
			equivocados+= "\n Comprobante de domicilio fiscal";
		}
	}
	if(Existe("fucabanco") && document.getElementById("fucabanco").value != ''){
		if(!filtrarArchivos("fucabanco")){
			band = false;
			equivocados+= "\n Caratula de banco";
		}
	}
	if(Existe("fuidenrep") && document.getElementById("fuidenrep").value != ''){
		if(!filtrarArchivos("fuidenrep")){
			band = false;
			equivocados+= "\n Identificacion de representante legal";
		}
	}
	if(Existe("fursocial") && document.getElementById("fursocial").value != ''){
		if(!filtrarArchivos("fursocial")){
			band = false;
			equivocados+= "\n RFC razon social";
		}
	}
	if(Existe("fuactacons") && document.getElementById("fuactacons").value != ''){
		if(!filtrarArchivos("fuactacons")){
			band = false;
			equivocados+= "\n Acta constitutiva";
		}
	}
	if(Existe("fupoderes") && document.getElementById("fupoderes").value != ''){
		if(!filtrarArchivos("fupoderes")){
			band = false;
			equivocados+= "\n Poderes";
		}
	}
	if(band)
		document.getElementById("formulario").submit();
	else
		alert("Los documentos solo pueden ser PDF o JPG en los sig. archivos: "+equivocados)
}


function EditarContratoSubCadena( tipo ){
	var rfc = txtValue("txtrfc");
	var rsocial = document.getElementById("txtrazon").value;
	var fconst = txtValue("txtfecha");
	var regimen = txtValue("ddlRegimen");
	var parametros = "f=0";
	var band = false;
	
	var calle = txtValue("txtcalle");
	var nint = txtValue("txtnint");
	var next = txtValue("txtnext");
	var pais = txtValue("ddlPais");
	if ( tipo == "nacional" ) {
		var edo = txtValue("ddlEstado");
		var ciudad = txtValue("ddlMunicipio");
		var colonia = txtValue("ddlColonia");
	} else if ( tipo == "extranjera" ) {
		var edo = txtValue("txtEstado");
		var ciudad = txtValue("txtMunicipio");
		var colonia = txtValue("txtColonia");
	}

	var cp = txtValue("txtcp");
	var parametros = "f=0";
	
	var nombre = txtValue("txtnombre");
	var paterno = txtValue("txtpaterno");
	var materno = txtValue("txtmaterno");
	var numiden = txtValue("txtnumiden");
	var tipoiden = txtValue("ddlTipoIden");
	var rrfc = txtValue("txtrrfc");
	var curp = txtValue("txtcurp");
	var figura = (document.getElementById("chkfigura").checked) ? 0 : 1;
	var familia = (document.getElementById("chkfamilia").checked) ? 0 : 1;
	
	var dirGral = (document.getElementById("chkDirGral").checked) ? "false" : "true";
	
	if(validaRFC("txtrfc")){
		parametros+="&rfc="+rfc;
		if(rsocial != ''){
			parametros+="&rsocial="+rsocial;
			if(fconst != ''){
				parametros+="&fconstitucion="+fconst;
				if(regimen != ''){
					parametros+="&regimen="+regimen;
					band = true;
				}else{
					alert("Favor de seleccionar un R\u00E9gimen");
					return false;
				}
			}else{
				alert("Favor de seleccionar una Fecha de Constituci\u00F3n");
				return false;
			}
		}else{
			alert("Favor de escribir una Raz\u00F3n Social");
			return false;
		}
	}else{
		alert("El RFC es incorrecto. Favor de escribirlo en un formato v\u00E1lido.\nEjemplo: VECJ880326XXX para persona f\u00EDsica o ABC680524P76 para persona moral.");
		return false;
	}
	
	if(calle != '')
		parametros+="&calle="+calle;
	if(nint != '')
		parametros+="&nint="+nint;
	if(next != '')
		parametros+="&next="+next;
	if(pais != '')
		parametros+="&idpais="+pais;
	if(edo != '')
		parametros+="&idestado="+edo;
	if(ciudad != '')
		parametros+="&idciudad="+ciudad;
	if(colonia != '')
		parametros+="&idcolonia="+colonia;
	if(cp != '')
		parametros+="&cp="+cp;
		
	if(validaRFCPersona("txtrrfc")){
	    if(validaCURP("txtcurp")){
		if(nombre != '' && paterno != '' && materno != '' && numiden != '' && tipoiden > -1 && curp != ''){
		    parametros+="&nombre="+nombre+"&paterno="+paterno+"&materno="+materno+"&numiden="+numiden+"&tipoiden="+tipoiden+"&rrfc="+rrfc+"&curp="+curp+"&figura="+figura+"&familia="+familia;
		}else{
		    band = false;
		    alert("Favor de escribir los datos del Representante Legal");
			return false;
		}
	    }else{
			band = false;
			alert("El CURP del representante legal es incorrecto. Favor de escribirlo en un formato v\u00E1lido. Ejemplo: PUXB571021HNELXR00");
			return false;
	    }
	    
	}else{
	    band = false;
	    alert("El RFC del Representante Legal es incorrecto. Favor de escribirlo en un formato v\u00E1lido.\nEjemplo: VECJ880326XXX para persona f\u00EDsica o ABC680524P76 para persona moral.");
		return false;
	}	
	
	if ( pais < 0 ) {
		band = false;
		alert("Falta seleccionar Pa\u00EDs");
		return false;
	}
	
	if ( pais == '' ) {
		band = false;
		alert("Falta seleccionar Pa\u00EDs");
		return false;
	}
	
	if ( calle == '' ) {
		band = false;
		alert("Falta escribir Calle");
		return false;
	}
	
	if ( next == '' ) {
		band = false;
		alert("Falta escribir N\u00FAmero Exterior");
		return false;
	}
	
	if ( cp == '' ) {
		band = false;
		alert("Falta escribir C\u00F3digo Postal");
		return false;
	}	
	
	if ( pais == 164 ) {
		if ( colonia < 0 ) {
			band = false;
			alert("Falta seleccionar Colonia");
			return false;
		}		
		if ( edo < 0 ) {
			band = false;
			alert("Falta seleccionar Estado");
			return false;
		}
		if ( ciudad < 0 ) {
			band = false;
			alert("Falta seleccionar Ciudad");
			return false;
		}
	}	
	
	if ( pais != 164 && pais > 0 ) {
		if ( colonia == '' ) {
			band = false;
			alert("Falta escribir Colonia");
			return false;
		}
		if ( edo == '' ) {
			band = false;
			alert("Falta escribir Estado");
			return false;
		}		
		if ( ciudad == '' ) {
			band = false;
			alert("Falta escribir Ciudad");
			return false;
		}
	}
	
	if(band){
		parametros+="&dirGral="+dirGral;
		parametros += "&tipodireccion=" + tipo;
		MetodoAjax2("../../inc/Ajax/_Clientes/EditarContratoPreSubCadena.php",parametros);
	}
	
}

/*para el contrato de Subcadena*/
function RellenarContrato(){
	var RFC = document.getElementById("txtrfc").value;
	var permitirGuardarCambios = false;
	if ( RFC != '' ) {
		if ( validaRFC("txtrfc") ) {
			permitirGuardarCambios = true;	
			http.open("POST","../../inc/Ajax/_Clientes/RellenarContrato.php", true);
			http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			
			http.onreadystatechange=function() { 
				if ( http.readyState==1 ) {
					//div para  [cargando....]
					Emergente();
				}
				if ( http.readyState==4 ) {
					OcultarEmergente();
					var RespuestaServidor = http.responseText;
					var RESserv = RespuestaServidor.split("|");
				
					validaSession(RESserv[0]);
				
					if ( RESserv[0] == 0 ) {
						if ( RESserv[1] == "" ) {
							setValue("txtrazon","");
							Desbloquear("txtrazon");
						} else {
							setValue("txtrazon",RESserv[1]);
						}
						
						if ( RESserv[2] == "" ) {
							setValue("txtfecha","");
							Desbloquear("txtfecha");
						} else {
							setValue("txtfecha",RESserv[2]);
						}
						
					if ( RESserv[3] == "" ) {
						setValue("ddlRegimen","-1");
						Desbloquear("ddlRegimen");
					} else {
						setValue("ddlRegimen",RESserv[3]);
					}
					VerificarDireccionCorr();
				} else {
					alert("Error: "+RESserv[0]+" "+RESserv[1]);
					if(document.getElementById('daniel') != null)
						document.getElementById('daniel').innerHTML = RESserv[1];
				}			
			} 
		}
		http.send("RFC="+RFC+"&pemiso="+true);	
		}else{
			alert("El RFC no es v\u00E1lido. Favor de escribirlo en un formato v\u00E1lido.\nEjemplo: VECJ880326XXX para persona f\u00EDsica o ABC680524P76 para persona moral.");
		}
		if ( permitirGuardarCambios ) {
			if ( document.getElementById("guardarCambios") ) {
				document.getElementById("guardarCambios").style.visibility = "visible";
			}
		} else {
			if ( document.getElementById("guardarCambios") ) {
				document.getElementById("guardarCambios").style.visibility = "hidden";
			}
		}			
	}
} 

function EditarCuentaBancoCorresponsal(){
	var banco = txtValue("ddlBanco");
	var clabe = txtValue("txtclabe");
	var beneficiario = txtValue("txtbeneficiario");
	var cuenta = txtValue("txtcuenta");
	var descripcion = txtValue("txtdescripcion");
	var parametros = "f=0";
	var band = false;
	

	if(banco > -1){
		parametros+="&idbanco="+banco;
		if(clabe != ''){
			parametros+="&clabe="+clabe;
			if(beneficiario != ''){
				parametros+="&beneficiario="+beneficiario;
				band = true;
			}else{
				alert("Favor de escribir el nombre del beneficiario");
			}
		}else{
			alert("Favor de escribir la CLABE");
		}
	}else{
		alert("Favor de seleccionar un banco");
	}
	
	if(band){
		if(cuenta != '')
			parametros+="&cuenta="+cuenta;
		if(descripcion != '')
			parametros+="&descripcion="+descripcion
		
		MetodoAjax2("../../inc/Ajax/_Clientes/EditarCuentaPreCorresponsal.php",parametros);
		
	}
	
}

function BuscarPreContactosCorresponsal(){
	BuscarParametros2("../../inc/Ajax/_Clientes/BuscarPreContactosCorresponsal.php",'','divRES');
}

function BuscarPreContactosCorresponsal2(){
	BuscarParametros2("../../inc/Ajax/_Clientes/BuscarPreContactosCorresponsal2.php",'','divRES');
}

function UpdateHorariosPreCorr(idCorr){
		
	var parametros = "";
	var DE1 = txtValue("txt1");
	var DE2 = txtValue("txt3");
	var DE3 = txtValue("txt5");
	var DE4 = txtValue("txt7");
	var DE5 = txtValue("txt9");
	var DE6 = txtValue("txt11");
	var DE7 = txtValue("txt13");
	
	var A1 = txtValue("txt2");
	var A2 = txtValue("txt4");
	var A3 = txtValue("txt6");
	var A4 = txtValue("txt8");
	var A5 = txtValue("txt10");
	var A6 = txtValue("txt12");
	var A7 = txtValue("txt14");
	
	
	if(validaHorasDia(DE1,A1,"txt2","Lunes")){
		if(validaHorasDia(DE2,A2,"txt4","Martes")){
			if(validaHorasDia(DE3,A3,"txt6","Miercoles")){
				if(validaHorasDia(DE4,A4,"txt8","Jueves")){
					if(validaHorasDia(DE5,A5,"txt10","Viernes")){
						if(validaHorasDia(DE6,A6,"txt12","Sabado")){
							if(validaHorasDia(DE7,A7,"txt14","Domingo")){
								
								parametros += "&DE1="+DE1+"&DE2="+DE2+"&DE3="+DE3+"&DE4="+DE4+"&DE5="+DE5+"&DE6="+DE6+"&DE7="+DE7+"";
								parametros += "&A1="+txtValue("txt2")+"";
								parametros += "&A2="+txtValue("txt4")+"";
								parametros += "&A3="+txtValue("txt6")+"";
								parametros += "&A4="+txtValue("txt8")+"";
								parametros += "&A5="+txtValue("txt10")+"";
								parametros += "&A6="+txtValue("txt12")+"";
								parametros += "&A7="+txtValue("txt14")+"";
								
							}
						}
					}
				}
			}
		}
	}
	return parametros;
}

function CrearDirPreCorresponsal( tipo ){
	var calle = txtValue("txtcalle");
	var nint = txtValue("txtnint");
	var next = txtValue("txtnext");
	var pais = txtValue("ddlPais");
	if ( tipo == "nacional" ) {
		var edo = txtValue("ddlEstado");
		var ciudad = txtValue("ddlMunicipio");
		var colonia = txtValue("ddlColonia");
	} else if ( tipo == "extranjera" ) {
		var edo = txtValue("txtEstado");
		var ciudad = txtValue("txtMunicipio");
		var colonia = txtValue("txtColonia");
	}
	var cp = txtValue("txtcp");
	var parametros = "f=0";	
	var caracterVacio = /^\s$/i;
	
	if ( calle != '' ) {
		if ( !calle.match(caracterVacio) ) {
			parametros += "&calle="+calle;
		} else {
			alert("La Calle no puede estar vacía");
			return false;
		}
	} else {
		alert("Falta llenar la Calle");
		return false;
	}
		
	if ( !nint.match(caracterVacio) ) {
		parametros += "&nint="+nint;
	} else {
		alert("El Número Interior no puede estar vacío");
		return false;
	}
		
	if ( next != '' ) {
		if ( !next.match(caracterVacio) ) {
			parametros += "&next="+next;
		} else {
			alert("El Número Exterior no puede estar vacío");
			return false;
		}
	} else {
		alert("Falta llenar el Número Exterior");
		return false;
	}
		
	if ( pais != '' ) {
		if ( !pais.match(caracterVacio) ) {
			parametros += "&idpais="+pais;
		} else {
			alert("El País no puede estar vacío");
			return false;
		}
	} else {
		alert("Falta llenar el País");
		return false;
	}
		
	if ( edo != '' ) {
		if ( !edo.match(caracterVacio) ) {
			parametros += "&idestado="+edo;
		} else {
			alert("El Estado no puede estar vacío");
			return false;
		}
	} else {
		alert("Falta llenar el Estado");
		return false;
	}
		
	if ( ciudad != '' ) {
		if ( !ciudad.match(caracterVacio) ) {
			parametros += "&idciudad="+ciudad;
		} else {
			alert("La Ciudad no puede estar vacía");
			return false;
		}
	} else {
		alert("Falta llenar la Ciudad");
		return false;
	}
		
	if ( colonia != '' ) {
		if ( colonia == '-1' ) {
			alert("Falta seleccionar Colonia");
			return false;
		}		
		if ( !colonia.match(caracterVacio) ) {
			parametros += "&idcolonia="+colonia;
		} else {
			alert("La Colonia no puede estar vacía");
			return false;
		}
	} else {
		alert("Falta llenar la Colonia");
		return false;
	}
		
	if ( cp != '' ) {
		if ( !cp.match(caracterVacio) ) {
			parametros += "&cp="+cp;
		} else {
			alert("El Código Postal no puede estar vacío");
			return false;
		}
	} else {
		alert("Falta llenar el Código Postal");
		return false;
	}
	parametros += UpdateHorariosPreCorr();
	parametros += "&tipodireccion=" + tipo;
	MetodoAjax2("../../inc/Ajax/_Clientes/EditarDireccionPreCorresponsal.php",parametros);
}

var bandedcont3 = 0;
function DesPreContactosCorresponsal(){
	if(bandedcont3 == 0)
		AgregarPreContactosCorresponsal();
	if(bandedcont3 == 1)
		EditarPreContactoCorresponsal();
}

function AgregarPreContactosCorresponsal(){
	var nombre = txtValue("txtnombre");
	var paterno = txtValue("txtpaterno");
	var materno = txtValue("txtmaterno");
	var telefono = txtValue("txttelefono");
	var ext = txtValue("txtext");
	var correo = txtValue("txtcorreo");
	var tipocontacto = txtValue("ddlTipoContacto");
	var parametros = "";
	if(nombre != '' && paterno != '' && materno != '' && telefono != '' && correo != '' && txtValue("ddlTipoContacto") > -1){
		if(validaTelefono("txttelefono")){
			if(validarEmail("txtcorreo")){
				parametros+= "nombre="+nombre+"&paterno="+paterno+"&materno="+materno+"&telefono="+telefono+"&ext="+ext+"&correo="+correo+"&tipocontacto="+tipocontacto;
				MetodoAjax2("../../inc/Ajax/_Clientes/CrearPreContactoCorresponsal.php",parametros);
				
				window.setTimeout("VerificaContAdCorresponsal()",100);
				
			}else{
				alert("El correo electronico es incorrecto")
			}
		}else{
			alert("El Telefono es incorrecto");
		}
	}else{
		alert("Favor de llenar todos los datos requeridos marcados con asterisco (*)")
	}
}

function VerificaContAdCorresponsal(){
	if(contad == 0){
		window.setTimeout("LimpiarPreContactosCorresponsal(false)",40);
		window.setTimeout("BuscarPreContactosCorresponsal()",100);	
	}
}

function EliminarPreContactoCorresponsal(id){
	if(confirm("¿Esta seguro de eliminar el contacto?")){
		MetodoAjax2("../../inc/Ajax/_Clientes/EliminarPreContactoCorresponsal.php","id="+id)
		window.setTimeout("BuscarPreContactosCorresponsal()",100);
	}
	
}

function LimpiarPreContactosCorresponsal(value){
	document.getElementById("txtnombre").value = "";
	document.getElementById("txtpaterno").value = "";
	document.getElementById("txtmaterno").value = "";
	document.getElementById("txttelefono").value = "";
	document.getElementById("txtext").value = "";
	document.getElementById("txtcorreo").value = "";
	document.getElementById("ddlTipoContacto").value = -1;
	bandedcont3 = 0;
	if(value)
		$('#agregarcontacto').slideDown('normal');
	else
		$('#agregarcontacto').slideUp('normal');
}

function EditarPreContactoCorresponsal(id,x){
	if(x == 0){
		precontid = id;
		http.open("POST","../../inc/Ajax/_Clientes/EdPreContacto.php", true);
		http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			
		http.onreadystatechange=function() 
		{ 
			if (http.readyState==1)
			{
				//div para  [cargando....]
				Emergente();
			}
			if (http.readyState==4)
			{
				var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
				validaSession(RespuestaServidor);
				var valores = RespuestaServidor.split(",");
				document.getElementById("txtnombre").value = valores[0];
				document.getElementById("txtpaterno").value = valores[1];
				document.getElementById("txtmaterno").value = valores[2];
				document.getElementById("txttelefono").value = valores[3];
				document.getElementById("txtext").value = valores[4];
				document.getElementById("txtcorreo").value = valores[5];
				document.getElementById("ddlTipoContacto").value = valores[6];
				OcultarEmergente();
				$("#agregarcontacto").slideDown("normal");
			} 
		}
		http.send("id="+id);
		
		
	}else{
		var nombre = txtValue("txtnombre");
		var paterno = txtValue("txtpaterno");
		var materno = txtValue("txtmaterno");
		var telefono = txtValue("txttelefono");
		var ext = txtValue("txtext");
		var correo = txtValue("txtcorreo");
		var tipocontacto = txtValue("ddlTipoContacto");
		var parametros = "id="+precontid;
		if(nombre != '' && paterno != '' && materno != '' && telefono != '' && correo != '' && txtValue("ddlTipoContacto") > -1){
			if(validaTelefono("txttelefono")){
				if(validarEmail("txtcorreo")){
					parametros+= "&nombre="+nombre+"&paterno="+paterno+"&materno="+materno+"&telefono="+telefono+"&ext="+ext+"&correo="+correo+"&tipocontacto="+tipocontacto;
					MetodoAjax2("../../inc/Ajax/_Clientes/EditarPreContactoCorresponsal.php",parametros);
					window.setTimeout("LimpiarPreContactos(false)",40);
					window.setTimeout("BuscarPreContactosCorresponsal()",100);
				}else{
					alert("El correo electronico es incorrecto");
				}
			}else{
				alert("El telefono es incorrecto");
			}			
		}else{
			alert("Favor de llenar todos los datos requeridos marcados con asterisco (*)")
		}
	}
	
}

function BloquearFiscal(){
	if(document.getElementById("chkfiscal").checked == true){
		document.getElementById("fudfiscal").disabled = true;
		document.getElementById("hfiscal").value = "1";
	}
	else{
		document.getElementById("fudfiscal").disabled = false;
		document.getElementById("hfiscal").value = "0";
	}
}

function VerificarDireccionCad( tipo, primeraCarga ) {
	var caracteresValidos = /^\d{5}$/i;
	var permitirGuardarCambios = false;
	if ( document.getElementById("calleok") ) {
		if ( txtValue("txtcalle") != '' ) {
			document.getElementById("calleok").style.display = "inline-block";
			permitirGuardarCambios = true;
		} else {
			document.getElementById("calleok").style.display = "none";
		}
	}
	if ( document.getElementById("nextok") ) {
		if ( txtValue("txtnext") !=  '' ) {
			document.getElementById("nextok").style.display = "inline-block";
			permitirGuardarCambios = true;
		} else {
			document.getElementById("nextok").style.display = "none";
		}
	}
	if ( tipo == "nacional" ) {
		if ( document.getElementById("ciudadok") ) {
			if ( txtValue("ddlMunicipio") > -2 && txtValue("ddlMunicipio") != "" ) {
				document.getElementById("ciudadok").style.display = "inline-block";
				permitirGuardarCambios = true;
			} else {
				document.getElementById("ciudadok").style.display = "none";
			}
		}
		if ( document.getElementById("estadook") ) {
			if ( txtValue("ddlEstado") > -2 && txtValue("ddlEstado") != "" ) {
				document.getElementById("estadook").style.display = "inline-block";
				permitirGuardarCambios = true;
			} else {
				document.getElementById("estadook").style.display = "none";
			}
		}
		if ( document.getElementById("paisok") ) {
			if ( txtValue("ddlPais") > 0 ) {
				document.getElementById("paisok").style.display = "inline-block";
				permitirGuardarCambios = true;
			} else {
				document.getElementById("paisok").style.display = "none";
			}
		}
		if ( document.getElementById("colok") ) {
			if ( txtValue("ddlColonia") > -1 ) {
				document.getElementById("colok").style.display = "inline-block";
				permitirGuardarCambios = true;
			} else {
				document.getElementById("colok").style.display = "none";
			}
		}
	}
	if ( document.getElementById("nintok") ) {
		if ( txtValue("txtnint") != '' ) {
			document.getElementById("nintok").style.display = "inline-block";
			permitirGuardarCambios = true;
		} else {
			document.getElementById("nintok").style.display = "none";
		}
	}
	if ( document.getElementById("cpok") ) {
		if ( txtValue("txtcp").match(caracteresValidos) ) {
			document.getElementById("cpok").style.display = "inline-block";
			permitirGuardarCambios = true;
		} else {
			document.getElementById("cpok").style.display = "none";
		}
	}
	if ( tipo == "extranjera" ) {
		if ( document.getElementById("colok") ) {
			if ( txtValue("txtColonia") != '' ) {
				document.getElementById("colok").style.display = "inline-block";
				permitirGuardarCambios = true;
			} else {
				document.getElementById("colok").style.display = "none";
			}
		}
		if ( document.getElementById("estadook") ) {
			if ( txtValue("txtEstado") != '' ) {
				document.getElementById("estadook").style.display = "inline-block";
				permitirGuardarCambios = true;
			} else {
				document.getElementById("estadook").style.display = "none";
			}
		}
		if ( document.getElementById("ciudadok") ) {
			if ( txtValue("txtMunicipio") != '' ) {
				document.getElementById("ciudadok").style.display = "inline-block";
				permitirGuardarCambios = true;
			} else {
				document.getElementById("ciudadok").style.display = "none";
			}
		}
	}
	if ( permitirGuardarCambios && !primeraCarga ) {
		if ( document.getElementById("guardarCambios") ) {
			document.getElementById("guardarCambios").style.visibility = "visible";
		}
	} else {
		if ( document.getElementById("guardarCambios") ) {
			document.getElementById("guardarCambios").style.visibility = "hidden";
		}
	}
}

function RevisarSeccionesPreCadena(){
	var generales = document.getElementById("chkgenerales").checked ? "1" : "0";
	var documentos = document.getElementById("chkdireccion").checked ? "1" : "0";
	var contactos = document.getElementById("chkcontactos").checked ? "1" : "0";
	var ejecutivos = document.getElementById("chkejecutivos").checked ? "1" : "0";

	parametros = "generales="+generales+"&direccion="+documentos+"&contactos="+contactos+"&ejecutivos="+ejecutivos;
	
	MetodoAjax2("../../inc/Ajax/_Clientes/RevisarSeccionesPreCadena.php",parametros);
	window.setTimeout("Recargar()",100);
	
}

function CambiarAfiliacionPreCorresponsal(){
	var afiliacion = txtValue("txtafiliacion");
	var tipo = document.getElementById("ddlTipoAfiliacion").value;
	var parametros = "";
	if(afiliacion != ''){
		parametros = "afiliacion="+afiliacion+"&tipo="+tipo;
		MetodoAjax2("../../inc/Ajax/_Clientes/CambiarAfiliacionPreCorresponsal.php",parametros);
	}
}

function RevisarSeccionesPreCorresponsal(){
	var generales = document.getElementById("chkgenerales").checked ? "1" : "0";
	var documentos = document.getElementById("chkdireccion").checked ? "1" : "0";
	var contactos = document.getElementById("chkcontactos").checked ? "1" : "0";
	
	parametros = "generales="+generales+"&direccion="+documentos+"&contactos="+contactos;
	
	MetodoAjax2("../../inc/Ajax/_Clientes/RevisarSeccionesPreCorresponsal.php",parametros);
	
}

function RevisarContratoPreCorresponsal(){
	var contrato = document.getElementById("chkcontrato").checked ? "1" : "0";
	
	parametros = "contrato="+contrato;
		
	MetodoAjax2("../../inc/Ajax/_Clientes/RevisarContratoPreCorresponsal.php",parametros);
	
}

function RevisarCuentaPreCorresponsal(){
	var cuenta = document.getElementById("chkcuenta").checked ? "1" : "0";
	var forelo = txtValue("txtforelo");
	var descripcion = txtValue("txtdescripcion");
	var referencia = txtValue("txtreferencia");
	
	parametros = "cuenta="+cuenta+"&forelo="+forelo+"&descripcion="+descripcion+"&referencia="+referencia;
	
	MetodoAjax2("../../inc/Ajax/_Clientes/RevisarCuentaPreCorresponsal.php",parametros);
	
}

function RevisarEjecutivosPreCorresponsal(){
	var ejecutivos = document.getElementById("chkejecutivos").checked ? "1" : "0";
	var parametros = "f=0";
	
	if(sel2 > -1){
		parametros+="&ideventa="+sel2;
	} else {
		alert("Falta elegir Ejecutivo de Venta");
		return false;
	}	
	
	if(sel3 > -1){
		parametros+="&idecuenta="+sel3;
	} else {
		alert("Falta elegir Ejecutivo de Cuenta");
		return false;
	}
	
	parametros+= "&ejecutivos="+ejecutivos;
	
	MetodoAjax2("../../inc/Ajax/_Clientes/RevisarEjecutivosPreCorresponsal.php",parametros);
	window.setTimeout("Recargar()",100)
}

//function EditarEjecutivosPreCorresponsal(){
//	
//	var parametros = "f=0";
//	if(txtValue("txtejecutivocuenta") == ''){
//		sel3 = -1;
//		parametros = "f=0";
//	}
//	if(txtValue("txtejecutivoventa") == ''){
//		sel2 = -1;
//		parametros = "f=0";
//	}
//	if(sel3 > -1){
//		parametros+="&idecuenta="+sel3;
//	}
//	if(sel2 > -1){
//		parametros+="&ideventa="+sel2;
//	}
//	
//	MetodoAjax2("../../inc/Ajax/_Clientes/EditarEjecutivosPreCorresponsal.php",parametros);
//}

function RevisarSeccionesPreSubCadena(){
	var generales = document.getElementById("chkgenerales").checked ? "1" : "0";
	var documentos = document.getElementById("chkdireccion").checked ? "1" : "0";
	var contactos = document.getElementById("chkcontactos").checked ? "1" : "0";
	
	parametros = "generales="+generales+"&direccion="+documentos+"&contactos="+contactos;
	
	MetodoAjax2("../../inc/Ajax/_Clientes/RevisarSeccionesPreSubCadena.php",parametros);
	
}

function RevisarCuentaPreSubCadena(){
	var cuenta = document.getElementById("chkcuenta").checked ? "1" : "0";
	var forelo = txtValue("txtforelo");
	var descripcion = txtValue("txtdescripcion");
	var referencia = txtValue("txtreferencia");
	
	parametros = "cuenta="+cuenta+"&forelo="+forelo+"&descripcion="+descripcion+"&referencia="+referencia;
	
	MetodoAjax2("../../inc/Ajax/_Clientes/RevisarCuentaPreSubCadena.php",parametros);
	
}

function RevisarContratoPreSubCadena(){
	var contrato = document.getElementById("chkcontrato").checked ? "1" : "0";
	
	parametros = "contrato="+contrato;
		
	MetodoAjax2("../../inc/Ajax/_Clientes/RevisarContratoPreSubCadena.php",parametros);
	
}

function EditarEjecutivosPreSubCadena(){
	
	var parametros = "f=0";
	if(txtValue("txtejecutivocuenta") == ''){
		sel3 = -1;
		parametros = "f=0";
	}
	if(txtValue("txtejecutivoventa") == ''){
		sel2 = -1;
		parametros = "f=0";
	}
	if(sel3 > -1){
		parametros+="&idecuenta="+sel3;
	}
	if(sel2 > -1){
		parametros+="&ideventa="+sel2;
	}
	
	MetodoAjax2("../../inc/Ajax/_Clientes/EditarEjecutivosPreSubCadena.php",parametros);
	
	window.setTimeout("Recargar()",100)
}

function RevisarEjecutivosPreSubCadena(){
	var ejecutivos = document.getElementById("chkejecutivos").checked ? "1" : "0";
	var parametros = "f=0";
	
	if(sel2 > -1){
		parametros+="&ideventa="+sel2;
	} else {
		alert("Falta elegir Ejecutivo de Venta");
		return false;
	}	
	
	if(sel3 > -1){
		parametros+="&idecuenta="+sel3;
	} else {
		alert("Falta elegir Ejecutivo de Cuenta");
		return false;
	}
	
	parametros+= "&ejecutivos="+ejecutivos;
	
	MetodoAjax2("../../inc/Ajax/_Clientes/RevisarEjecutivosPreSubCadena.php",parametros);
	window.setTimeout("Recargar()",100)
	
}

function CambioPaginaAutSub(i,id){
	switch(i){
		case 1:window.location = "Aut1.php?id="+id;
			break;
		case 2:window.location = "Aut2.php"
			break;
		case 3:window.location = "Aut3.php"
			break;
		case 4:window.location = "Aut4.php"
			break;
		case 5:window.location = "Aut5.php?id="+id;
			break;
	}
}

function CambioPaginaAutCorr(i,id){
	switch(i){
		case 1:window.location = "Aut1.php?id="+id;
			break;
		case 2:window.location = "Aut2.php"
			break;
		case 3:window.location = "Aut3.php"
			break;
		case 4:window.location = "Aut4.php"
			break
		case 5:window.location = "Aut5.php?id="+id;
			break;
	}
}

function EliminarPreCadena(id){
	if(confirm("Esta seguro de eliminar la cadena?")){
		MetodoAjax2("../../inc/Ajax/_Clientes/EliminarPreCadena.php","id="+id);
		window.setTimeout("BuscarPreCadenas()",100);
	}
}

function EliminarPreCadena2(id){
	if(confirm("Esta seguro de eliminar la cadena?")){
		MetodoAjax2("../../inc/Ajax/_Clientes/EliminarPreCadena.php","id="+id);
		window.setTimeout("Recargar()",100)
	}
}

function EliminarPreSubCadena(id){
	if(confirm("Esta seguro de eliminar la subcadena?")){
		MetodoAjax2("../../inc/Ajax/_Clientes/EliminarPreSubCadena.php","id="+id);
		window.setTimeout("BuscarPreSubCadenas()",100);
	}
}

function EliminarPreSubCadena2(id){
	if(confirm("Esta seguro de eliminar la subcadena?")){
		MetodoAjax2("../../inc/Ajax/_Clientes/EliminarPreSubCadena.php","id="+id);
		window.setTimeout("Recargar()",100)
	}
}

function EliminarPreCorresponsal(id){
	if(confirm("Esta seguro de eliminar el corresponsal?")){
		MetodoAjax2("../../inc/Ajax/_Clientes/EliminarPreCorresponsal.php","id="+id);
		window.setTimeout("BuscarPreCorresponsal()",100);
	}
}

function EliminarPreCorresponsal2(id){
	if(confirm("Esta seguro de eliminar el corresponsal?")){
		MetodoAjax2("../../inc/Ajax/_Clientes/EliminarPreCorresponsal.php","id="+id);
		window.setTimeout("Recargar()",100)
	}
}

function BuscaCPColonia(){
	var idcolonia = document.getElementById("ddlColonia").value;
	var parametros = "idcolonia="+idcolonia;
	$.post( '../../inc/Ajax/_Clientes/CPColonia.php', { idcolonia: idcolonia } ).done( function(data) {
		validaSession(data);																								
		document.getElementById('txtcp').value = data;																	
	});	
}

$(document).ready(function(){
	$("#txtcp").numeric(
		{ decimal: false, negative: false },
		function() {
			alert("Numeros positivos solamente");
			this.value = "";
			this.focus(); });
	$("#txtnext").numeric(
		{ decimal: false, negative: false },
		function() {
			alert("Numeros positivos solamente");
			this.value = "";
			this.focus(); });
	$("#txtcalle").alphanum({
		allow: "-áéíóúÁÉÍÓÚñÑü",
		disallow: "¿¡°´¨~",
		allowOtherCharSets: false
	});
	$("#txtnint").alphanum({
		allow: "-",
		disallow: "¿¡°´¨~",
		allowOtherCharSets: false
	});
	$(".txthorario").alphanum({
		allow: ":",
		disallow: "¿¡°´¨~",
		allowLatin: false,
		allowOtherCharSets: false
	});
	$("#txtbeneficiario").alphanum({
		disallow: "¿¡°´¨~"			 
	});
	$("#txtdescripcion").alphanum({
		allowOtherCharSets: false							  
	});
	$("#txtColonia").alphanum({
		allow: "-áéíóúÁÉÍÓÚñÑü",
		disallow: "¿¡°´¨~",
		allowOtherCharSets: false
	});
	$("#txtEstado").alphanum({
		allow: "-áéíóúÁÉÍÓÚñÑü",
		disallow: "¿¡°´¨~",
		allowOtherCharSets: false
	});
	$("#txtMunicipio").alphanum({
		allow: "-áéíóúÁÉÍÓÚñÑü",
		disallow: "¿¡°´¨~",
		allowOtherCharSets: false
	});
	$("#txtnumiden").alphanum({
		allow: "-",
		disallow: "¿¡°´¨~",
		allowOtherCharSets: false
	});
	$("#txtrrfc").alphanum({
		allow: "-",
		disallow: "¿¡°´¨~",
		allowOtherCharSets: false
	});
	$("#txtcurp").alphanum({
		allow: "-",
		disallow: "¿¡°´¨~",
		allowOtherCharSets: false
	});
	$("#txtrfc").alphanum({
		allow: "-",
		disallow: "¿¡°´¨~",
		allowOtherCharSets: false
	});
	$("#txtNombreCadena").alphanum({
		allow: "-áéíóúÁÉÍÓÚñÑü",
		disallow: "¿¡°´¨~",
		allowOtherCharSets: false
	});
	$("#txtmail").alphanum({
		allow: "-._@",
		disallow: "¿¡°´¨~",
		allowOtherCharSets: false
	});
	$("#txtcorreo").alphanum({
		allow: "-._@",
		disallow: "¿¡°´¨~",
		allowOtherCharSets: false
	});
	$("#txtNomSucursal").alphanum({
		allow: "-._@áéíóúÁÉÍÓÚñÑü",
		disallow: "¿¡°´¨~",
		allowOtherCharSets: false
	});
	$("#txtnombre").alphanum({
		allow: "áéíóúÁÉÍÓÚñÑü",
		disallow: "¿¡°´¨~",
		allowOtherCharSets: false
	});
	$("#txtpaterno").alphanum({
		allow: "áéíóúÁÉÍÓÚñÑü",
		disallow: "¿¡°´¨~",
		allowOtherCharSets: false
	});
	$("#txtmaterno").alphanum({
		allow: "áéíóúÁÉÍÓÚñÑü",
		disallow: "¿¡°´¨~",
		allowOtherCharSets: false
	});
	$("#txttelefono").alphanum({
		allow: "-",
		disallow: "¿¡°´¨~",
		allowOtherCharSets: false
	});
	$("#txtext").alphanum({
		allow: "-",
		disallow: "¿¡°´¨~",
		allowOtherCharSets: false
	});
	$("#txtejecutivoventa, #txtEjecutivoAfiliacionIntermedia, #txtEjecutivoAfiliacionAvanzada").alphanum({
		allow				: "áéíóúÁÉÍÓÚñÑü",
		disallow			: "¿¡°´¨~",
		allowNumeric		: false,
		allowOtherCharSets	: false
	});
	$("#txtejecutivocuenta").alphanum({
		allow: "áéíóúÁÉÍÓÚñÑü",
		disallow: "¿¡°´¨~",
		allowOtherCharSets: false
	});
	$("#txttel1").alphanum({
		allow: "-",
		disallow: "¿¡°´¨~",
		allowLatin: false,
		allowOtherCharSets: false
	});
	$("#txttel2").alphanum({
		allow: "-",
		disallow: "¿¡°´¨~",
		allowLatin: false,
		allowOtherCharSets: false
	});
	$("#txtfax").alphanum({
		allow: "-",
		disallow: "¿¡°´¨~",
		allowLatin: false,
		allowOtherCharSets: false
	});
	$("#txtrazon").alphanum({
		allow: "-áéíóúÁÉÍÓÚñÑü",
		disallow: "¿¡°´¨~",
		allowOtherCharSets: false
	});
	$("#txtfecha").alphanum({
		allow: "-",
		disallow: "¿¡°´¨~",
		allowLatin: false,
		allowOtherCharSets: false
	});
	$("#txtclabe").alphanum({
		disallow: "¿¡°´¨~-",
		allowLatin: false,
		allowOtherCharSets: false
	});
	$("#txtbeneficiario").alphanum({
		allow: "áéíóúÁÉÍÓÚñÑü",
		disallow: "¿¡°´¨~",
		allowOtherCharSets: false
	});
	$("#txtcuenta").alphanum({
		disallow: "¿¡°´¨~-",
		allowLatin: false,
		allowOtherCharSets: false
	});
	$("#txtforelo").alphanum({
		disallow: "¿¡°´¨~-",
		allowLatin: true,
		allowOtherCharSets: false
	});
	$("#txtreferencia").alphanum({
		disallow: "¿¡°´¨~-",
		allowLatin: true,
		allowOtherCharSets: false
	});
	$("#txtNumSucursal").alphanum({
		disallow: "¿¡°´¨~-",
		allowLatin: false,
		allowOtherCharSets: false
	});
	$("#txtafilicacion").alphanum({
		allow: ".",
		disallow: "¿¡°´¨~-",
		allowLatin: false,
		allowOtherCharSets: false
	});
	$("#check4").click(function(){
		if ( $("#check4").is(":checked") && $("#txt2").val() != "" ) {
			$("#txt4").val( $("#txt2").val() );
		}
		if ( $("#check4").is(":checked") && $("#txt1").val() != "" ) {
			$("#txt3").val( $("#txt1").val() );
		}		
	});
	$("#check6").click(function(){
		if ( $("#check6").is(":checked") && $("#txt4").val() != "" ) {
			$("#txt6").val( $("#txt4").val() );
		}
		if ( $("#check6").is(":checked") && $("#txt3").val() != "" ) {
			$("#txt5").val( $("#txt3").val() );
		}		
	});
	$("#check8").click(function(){
		if ( $("#check8").is(":checked") && $("#txt6").val() != "" ) {
			$("#txt8").val( $("#txt6").val() );
		}
		if ( $("#check8").is(":checked") && $("#txt5").val() != "" ) {
			$("#txt7").val( $("#txt5").val() );
		}		
	});
	$("#check10").click(function(){
		if ( $("#check10").is(":checked") && $("#txt8").val() != "" ) {
			$("#txt10").val( $("#txt8").val() );
		}
		if ( $("#check10").is(":checked") && $("#txt7").val() != "" ) {
			$("#txt9").val( $("#txt7").val() );
		}		
	});
	$("#check12").click(function(){
		if ( $("#check12").is(":checked") && $("#txt10").val() != "" ) {
			$("#txt12").val( $("#txt10").val() );
		}
		if ( $("#check12").is(":checked") && $("#txt9").val() != "" ) {
			$("#txt11").val( $("#txt9").val() );
		}		
	});
	$("#check14").click(function(){
		if ( $("#check14").is(":checked") && $("#txt12").val() != "" ) {
			$("#txt14").val( $("#txt12").val() );
		}
		if ( $("#check14").is(":checked") && $("#txt11").val() != "" ) {
			$("#txt13").val( $("#txt11").val() );
		}		
	});

	if($("#txtEjecutivoAfiliacionIntermedia").length){
		autoCompletaEjecutivos("txtEjecutivoAfiliacionIntermedia", 9, "ddlEjecutivoAfIn");
	}
	// Bancarios
	if($("#txtEjecutivoAfiliacionAvanzada").length){
		autoCompletaEjecutivos("txtEjecutivoAfiliacionAvanzada", 10, "ddlEjecutivoAfAv");
	}
});

function buscarColonias() {
	if ( tipoDireccion == "nacional" ) {
		var codigoPostal = $("#txtcp").val();
		var caracteresValidos = /^\d{5}$/i;
		if ( codigoPostal != '' && codigoPostal != null ) {
			if ( codigoPostal.match(caracteresValidos) ) {
				$.post( '../../inc/Ajax/_Clientes/buscarColonia.php', { "codigoPostal": codigoPostal } ).done(
					function(data) {
						var colonia = jQuery.parseJSON( data );
						if ( colonia.codigoDeRespuesta == 0 ) {
							var option = [];
							option.push('<option value="-1" selected="selected">Seleccione colonia</option>');
							for ( var i = 0; i < colonia.idColonia.length; i++ ) {
								option.push( '<option value="' + colonia.idColonia[i] + '">' + colonia.nombre[i] + '</option>' );
							}
							$("#ddlColonia").html(option.join(''));
							$("#ddlColonia").prop( "disabled", false );
							$("#ddlEstado").attr( "value", colonia.idEntidad );
							$("#ddlMunicipio").attr( "value", colonia.idCiudad );
							cambiarCiudad( 164, colonia.idEntidad, 'divCd', colonia.idCiudad, true, "PreCadena" );
							window.setTimeout("VerificarDireccionCad(tipoDireccion)",100);
						} else {
							alert(colonia.mensajeDeRespuesta);
						}			
				} );					
			} else {
				var option = [];
				$("#ddlColonia").html('<option value="-1" selected="selected">Seleccione colonia</option>');
				$("#ddlColonia").prop( "disabled", true );
				$("#ddlMunicipio").val('');
				$("#ddlEstado").val('');
			}
	}
	} else {
		var option = [];
		$("#ddlColonia").html('<option value="-1" selected="selected">Seleccione colonia</option>');
		$("#ddlColonia").prop( "disabled", true );
	}		
}

function verificarEjecutivos() {
	if ( txtValue('txtejecutivoventa') == '' && txtValue('txtejecutivocuenta') == '' ) {
		if ( document.getElementById('guardarCambios') ) {
			document.getElementById('guardarCambios').style.visibility = "hidden";
		}
	}
}

function verificarRepresentanteLegal() {
	var permitirGuardarCambios = false;
	if ( txtValue('txtnombre') != '' ) {
		permitirGuardarCambios = true;
	}
	if ( txtValue('txtpaterno') != '' ) {
		permitirGuardarCambios = true;
	}
	if ( txtValue('txtmaterno') != '' ) {
		permitirGuardarCambios = true;
	}
	if ( txtValue('txtnumiden') != '' ) {
		permitirGuardarCambios = true;
	}
	if ( txtValue('ddlTipoIden') > -1 ) {
		permitirGuardarCambios = true;	
	}
	if ( txtValue('txtrrfc') != '' ) {
		permitirGuardarCambios = true;
	}
	if ( txtValue('txtcurp') != '' ) {
		permitirGuardarCambios = true;
	}
	if ( permitirGuardarCambios ) {
		if ( document.getElementById("guardarCambios") ) {
			document.getElementById("guardarCambios").style.visibility = "visible";
		}
	} else {
		if ( document.getElementById("guardarCambios") ) {
			document.getElementById("guardarCambios").style.visibility = "hidden";
		}
	}
}

function verificarArchivos() {
	var permitirGuardarCambios = false;
	if ( document.getElementById('fudomicilio').value ) {
		permitirGuardarCambios = true;	
	}
	if ( document.getElementById('fucabanco').value ) {
		permitirGuardarCambios = true;	
	}
	if ( document.getElementById('fuidenrep').value ) {
		permitirGuardarCambios = true;	
	}
	if ( document.getElementById('fursocial').value ) {
		permitirGuardarCambios = true;
	}
	if ( document.getElementById('fuactacons').value ) {
		permitirGuardarCambios = true;
	}
	if ( document.getElementById('fupoderes').value ) {
		permitirGuardarCambios = true;
	}
	if ( permitirGuardarCambios ) {
		if ( document.getElementById("guardarCambios") ) {
			document.getElementById("guardarCambios").style.visibility = "visible";
		}
	} else {
		if ( document.getElementById("guardarCambios") ) {
			document.getElementById("guardarCambios").style.visibility = "hidden";
		}
	}	
}

function tildes_unicode(str){
	str = str.replace('á','\u00e1');
	str = str.replace('é','\u00e9');
	str = str.replace('í','\u00ed');
	str = str.replace('ó','\u00f3');
	str = str.replace('ú','\u00fa');

	str = str.replace('Á','\u00c1');
	str = str.replace('É','\u00c9');
	str = str.replace('Í','\u00cd');
	str = str.replace('Ó','\u00d3');
	str = str.replace('Ú','\u00da');

	str = str.replace('ñ','\u00f1');
	str = str.replace('Ñ','\u00d1');
	return str;
}