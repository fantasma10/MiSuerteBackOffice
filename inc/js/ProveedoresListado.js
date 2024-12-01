

function initProveedoresListado(){
	$('#radioConsulta, #radioCrear').on('click', seleccionarPantalla);
}

function seleccionarPantalla(radio){
	var valorSeleccioando = radio.currentTarget.value; // 1 Consulta	2 Crear

	if(valorSeleccioando == 1){// Cargar la pantalla de Consulta
		cargarContenidoHtml(BASE_PATH + '/_Comercial/Proveedores/consultaProveedor.php', 'htmlContent', 'initProveedorConsulta()', '');
	}
	if(valorSeleccioando == 2){
		cargarContenidoHtml(BASE_PATH + '/_Comercial/Proveedores/crearProveedor.php', 'htmlContent', 'initProveedorCrear();', '');
	}
}


/*
**	Consulta de Proveedores
*/
function initProveedorConsulta(){
	$('#txtProveedorCom').keyup(function(){
		var value = event.target.value;

		if(value.trim() == ''){
			$('#idProveedorCom').val("-1");
		}
	});
	// Autocompletar caja de texto de proveedores
	autoCompletaGeneral('txtProveedorCom', 'idProveedorCom', BASE_PATH + '/inc/Ajax/stores/storeProveedores.php', 'nombreProveedor', 'idProveedor', {tipoProv : -1}, renderItemsProvs)
}

function renderItemsProvs(ul, item){
	return $( '<li>' )
	.append("<a>" + item.idProveedor + ": " + item.nombreProveedor + "</a>" )
	.appendTo(ul);
}

function buscaProveedores(){
	var params = getParams($('#formBusqueda').serialize());
	var table = "<table id='tblGridBox' class='display table table-bordered table-striped dataTable'>";
	table += "<thead><th>Id</th><th>Nombre</th><th>Tipo</th><th>Tel&eacute;fono</th><th>Cuenta</th><th>Estatus</th><th>Ver</th><th>Eliminar</th></thead>";
	table += "<tbody></tbody></table>";

	$('#gridbox').empty().html(table).show();

	llenaDataTable('tblGridBox', params, BASE_PATH + '/inc/Ajax/_Comercial/Proveedores/TablaProveedores.php');
}


/*
**	Creación y Edición de Proveedores
*/
function initProveedorCrear(){

	cargarStore(BASE_PATH + '/inc/Ajax/stores/storeTipoProveedor.php', 'idTipoProveedor', {}, {text : 'descTipoProveedor', value : 'idTipoProveedor'}, {}, 'tiposcargados');

	$("#txtNombreProveedor").alphanum({
		allow				: 'ñáéíóúÁÉÍÓÚÑ',
		maxLength			: 50,
		allowOtherCharSets	: false
	});

	$("#txtRazonSocial").alphanum({
		allow				: 'ñáéíóúÁÉÍÓÚÑ',
		maxLength			: 255,
		allowOtherCharSets	: false
	});

	$("#RFC").alphanum({
		allowOtherCharSets	: false,
		maxLength			: 14,
		forceUpper			: false,
	});

	$("#numCuenta").numeric({
		disallow			: '.-',
		allowPlus           : false, // Allow the + sign
		allowMinus          : false,  // Allow the - sign
		allowThouSep        : false,  // Allow the thousands separator, default is the comma eg 12,000
		allowDecSep			: false,
		maxDigits			: 10,
		allowOtherCharSets	: false
	});

	$('#telefono').prop("maxLength", 15);

	$("#telefono").on('keyup', function(event){
		validaTelefono2(event, 'telefono');
	});

	$("#telefono").on('keypress', function(event){
		validaTelefono1(event, 'telefono');
	});

}

/*
**	CRUD Proveedor
*/
function proveedorEliminar(){
	var row		= $(event.target).attr('row');
	var aData	= dataTableObj.fnGetData(row);
	var params	= eval("(" + aData[8] + ")");

	if(confirm("\u00BFEliminar el Proveedor?")){
		$.post(BASE_PATH + '/inc/Ajax/_Comercial/Proveedores/ProveedorEliminar.php',
			params,
			function(response){
				if(showMsg(response)){
					alert(response);
				}
				else{
					buscaProveedores();
				}
			},
			"json"
		);
	}
}

function proveedorGuardar(){

	var params = getParams($('#formProvCrear').serialize());

	var error = "";
	if(params.nombreProveedor.trim() == ""){
		error = "- Nombre Proveedor\n";
	}
	if(params.razonSocial.trim() == ""){
		error += "- Raz\u00F3n Social\n";
	}
	if(params.idTipoProveedor == -1){
		error += "- Tipo de Proveedor\n";
	}
	if(params.RFC.trim() == ""){
		error += "- RFC\n"
	}
	else{
		if(!validaRFC('RFC') && !validaRFCPersona('RFC')){
			error += "- Formato de RFC Incorrecto\n";
		}
	}
	if(params.numCuenta.trim() == ""){
		error += "- N\u00FAmero de Cuenta\n";
	}
	if(params.telefono.trim() == ""){
		error += "- Tel\u00E9fono\n";
	}
	else{
		if(!validaTelefono('telefono')){
			error += "- Tel\u00E9fono Incorrecto";
		}
	}

	if(error != ""){
		alert(error);
		event.preventDefault();
		return false;
	}
	else{
		$.post(BASE_PATH + '/inc/Ajax/_Comercial/Proveedores/ProveedorGuardar.php',
			params,
			function(response){
				if(showMsg(response)){
					alert(response.msg);
				}
				//si es respuesta exitosa y es un proveedor nuevo
				if(response.success == true && params.idProveedor <= 0){
					//limpiaForm();
					simpleFillForm({'idProveedor' : response.idProveedor}, 'formProvCrear');
					$('.secondstep').show();

				}//si es respuesta exitosa y se está editando un proveedor
				else if(response.success == true && params.idProveedor > 0){
					buscaProveedores();	
				}
			}
			,
			'json'
		);
	}
}

function proveedorConsulta(){
	var row		= $(event.target).attr('row');
	var aData	= dataTableObj.fnGetData(row);
	var params	= eval("(" + aData[8] + ")");

	cargarContenidoHtml(BASE_PATH + '/_Comercial/Proveedores/crearProveedor.php', 'divTbl', 'customConsultaProveedor(' + aData[8] + ');', params);
}

function customConsultaProveedor(par){
	initProveedorCrear();
	cargaDatosProveedor(par);

	$('.secondstep').show();
	proveedorCargarContactos(par);

	cargarStore(BASE_PATH + '/inc/Ajax/stores/storeTipoProveedor.php', 'idTipoProveedor', {}, {text : 'descTipoProveedor', value : 'idTipoProveedor'}, {}, 'tiposcargados');
}

function cargaDatosProveedor(params){
	$.post(BASE_PATH + '/inc/Ajax/_Comercial/Proveedores/ProveedorCargar.php',
		params,
		function(response){
			simpleFillForm(response.data, 'formProvCrear');
			//$("#formProvCrear [name='idProveedor']").val(response.data.idProveedor)
		},
		'json'
	)
}


/*
**	Funciones para los Contactos
*/
clicnuevo = 0;
// inicializar el div de la captura de nuevos contactos
function initNuevoContacto(){
	$("#txtContacNom, #txtContacAP, #txtContacAM").alphanum({
		allow				: 'áéíóúñÁÉÍÓÚÑ',
		allowNumeric		: false,
		allowOtherCharSets	: false
	});

	$("#txtMailContac").alphanum({
		allow				: '@_.-123456790',
		allowOtherCharSets	: false
	});

	$('#txtTelContac').prop("maxLength", 15);

	cargarStore(BASE_PATH + '/inc/Ajax/stores/storeTipoContacto.php', 'ddlTipoContac', {}, {text : 'descTipoContacto', value : 'idTipoContacto'}, {}, 'tipoContactoLoaded');

	$('#txtExtTelContac').numeric({
		allowPlus           : false,
		allowMinus          : false,
		allowThouSep        : false,
		allowDecSep         : false,
		allowLeadingSpaces  : false,
	});
}

// mostrar e inicializar el div para la captura de un nuevo contacto
function proveedorNuevoContacto(){
	//mostrar el div que contiene el formulario de los contactos
	thirdstep(true);
	//contar las veces que se ha hecho clic en el boton de nuevo y de editar
	clicnuevo++;
	//si es la primera vez que se hace clic se inicializa el formulario
	// ****nota****
	// no se debe inicializar el formulario cada vez que se haga clic, porque por cada vez se agregarían los listeners
	if(clicnuevo == 1){
		initNuevoContacto();
	}
}

//validaciones y envío de información para guardar un nuevo contacto y editar uno existente
function proveedorGuardarContacto(){
	//obtener los datos del contacto
	var params = getParams($('#formContactos').serialize());
	// el id del proveedor al que pertenece el contacto lo tomamos del formulario de captura de datos generales del proveedor
	params.idProveedor = $("#formProvCrear [name='idProveedor").val();
	// si el id del proveedor esta vacio o es 0 no se puede continuar a guardar el contacto
	if(params.idProveedor == undefined || params.idProveedor == '' || params.idProveedor == 0){
		console.log('sin proveedor asignado', $('#idProveedor').val());
		return false;
	}
	//variables para guardar los errors que se van encontrando en el formulario, como campos vacios o invalidos
	var lackT = 'Los siguientes datos son Obligatorios : \n';
	var lack = '';
	var error = '';

	if(params.nombreContacto == ''){
		lack += '- Nombre de Contacto\n';
	}
	if(params.aPaternoContacto == ''){
		lack += '- Apellido Paterno\n'
	}
	if(params.aMaternoContacto == ''){
		lack += '- Apellido Materno\n'
	}
	if(params.telefono == ''){
		lack += '- Tel\u00E9fono'
	}
	if(params.correoContacto == ''){
		lack += '- Correo\n';
	}
	else{
		if(!validarEmail('txtMailContac')){
			error += 'El formato del Correo es Inv\u00E1lido\n';
		}
	}
	if(params.tipoContacto == -1){
		lack += '- Tipo de Contacto\n';
	}
	if(lack != '' || error != ''){

		if(lack  != ''){lack = lackT + lack;}
		if(error != ''){error = '\nError\n' + error;}

		alert(lack +  error);
		event.preventDefault();
	}
	else{
		$.post(BASE_PATH + '/inc/Ajax/_Comercial/Proveedores/ContactoGuardar.php',
			params,
			function(response){
				if(showMsg(response)){
					alert(response.msg);
					event.preventDefault();
				}
				//si el contacto se guardo exitosamente se esconde el div del formulario de captura de datos de los contactos y se refresca la tabla para mostrar el contacto recien creado
				if(response.success == true){
					thirdstep(false);
					proveedorCargarContactos();
				}
				
			}
			,
			"json"
		);
	}
}

// mostrar la tabla con la lista de contactos, par solamente contiene el id del proveedor par = {idProveedor : valor}
function proveedorCargarContactos(par){

	if(par == undefined){
		var params = getParams($('#formProvCrear').serialize());
	}
	else{
		var params = par;
	}
	//cargar la lista de los contactos
	$.post(BASE_PATH + '/inc/Ajax/_Comercial/Proveedores/ContactosCargarLista.php',
		params,
		function(response){
			$('#tblContactos').empty().html(response);
		}
	);
}

//mostrar el div para editar el contacto y llenar los campos con la ingormacion del contacto a editar
function proveedorEditarContacto(){
	var targ = event.target;
	// obtenemos los valores de los atributos del elemento <i>
	var params = {
		idContacto	: $(targ).attr('idcontacto'),
		idInf		: $(targ).attr('idinf'),
		idProveedor	: $(targ).attr('idproveedor')
	}
	//cargar la informacion del contacto
	$.post(BASE_PATH + '/inc/Ajax/_Comercial/Proveedores/ContactosCargar.php',
		params,
		function(response){
			//mostrar un mensaje en caso de que en la respuesta venga que se tiene que mostrar
			if(showMsg(response)){
				alert(response.msg);
			}
			//si fue exitosa la consulta entonces se muestra el div con el formulario de captura y se muestra la información del contacto
			if(response.success == true){
				//mostrar e inicializar el formulario de los contactos
				proveedorNuevoContacto();
				// cuando se termine de cargar el combo de los tipos de contacto, se carga la informacion en el formulario
				$('#ddlTipoContac').on('tipoContactoLoaded', function(){
					simpleFillForm(response.data, 'formContactos');
				});
			}
		},
		'json'
	);
}
/*
**	Funciones Generales
*/
//muestra|oculta el div donde se capturan los datos del contacto
function thirdstep(bool){
	$('#formContactos').get(0).reset();
	$('#idContacto').val('0');

	if(bool){
		$('.thirdstep').show();
	}
	else{
		$('.thirdstep').hide();
	}
}

function limpiaForm(){
	$('#formProvCrear').get(0).reset();
}

function cerrarModal(){
	$('#divTbl').empty();
}
