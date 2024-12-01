function mostarTiendas() {
	var nCadenas = $('#nCadenas').val();
	var rutaForelosMovimientos=BASE_PATH+"/amp/notificacion/controllers/tiendas.php";    
    let formData = new FormData();
    formData.append('CknCadenas', nCadenas );
    var producto="";
    var tiendas = '<option value="-1" >Todas</option>';
    //showSpinner();
    $.ajax({
      url: rutaForelosMovimientos,
      data: formData,
      type: "post",
      dataType: "json",
      cache: false,
      contentType: false,
      processData: false
    }).done(function(resp) {
		var obj = (resp.data.data);
	    $.each(obj, function(index, value) {
			tiendas += '<option value="'+obj[index]['nIdSucursal']+'"  >'+obj[index]['sNombre']+'</option>';
		}); 
		$("#nTiendas").html(tiendas);
	    tiendas = '';
    }).fail(function(resp){
       // jAlert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
    }).always(function(){
        hideSpinner();
    });  
}
function mostarOperadores() {
    $("#hnOperadores").val('');
	var nTiendas = $('#nTiendas').val();
	var rutaForelosMovimientos=BASE_PATH+"/amp/notificacion/controllers/operadores.php";    
    let formData = new FormData();
    formData.append('CknTiendas', nTiendas );
    formData.append('CknTipoUsuario', $('input:radio[name=nTipoUsuario]:checked').val() );
    var producto="";
    var operadoresALL="";
    var operadores = '<option value="-1" >Todos</option>';
    //showSpinner();
    $.ajax({
      url: rutaForelosMovimientos,
      data: formData,
      type: "post",
      dataType: "json",
      cache: false,
      contentType: false,
      processData: false
    }).done(function(resp) {
		var obj = (resp.data.data);
	    $.each(obj, function(index, value) {
            operadoresALL+=obj[index]['nIdUsuario']+", ";
			operadores += '<option value="'+obj[index]['nIdUsuario']+'"  >'+obj[index]['sNombre']+' '+obj[index]['sApellidoPaterno']+' '+obj[index]['sApellidoMaterno']+'</option>';
		}); 
		// $("#nOperadores").html(operadores);
	    operadores = '';
        operadoresALL = operadoresALL.substring( 0,operadoresALL.length - 2)
        $("#hnOperadores").val(operadoresALL);
    }).fail(function(resp){
       // jAlert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
    }).always(function(){
        hideSpinner();
    });  
}
function notificacionValidaRegistro() {
    var error=0;
    var msg="";
    var errorcontrasena=0;      

	if(validarnCadenas()==false){
        error=1;
        msg+="Cadenas Inválidas \n";        
    }else{

    }
	if(validarnTiendas()==false){
        error=1;
        msg+="Tiendas Inválidas \n";        
    }else{

    }
	if(validarnOperadores()==false){
        error=1;
        msg+="Seleccione Usuarios\n";        
    }else{

    }
    if(validarfechas()==false){
        error=1;
        msg+="Seleccione Fechas\n";
    }else{

    }
    /*
    if(validarnIdPeriodo()==false){
        error=1;
        msg+="Periodo Inválido \n";        
    }else{

    }
    if(validarfecha1()==false){
        error=1;
        msg+="Fecha Inicial Inválido \n";        
    }else{

    }
    if(validarfecha2()==false){
        error=1;
        msg+="Fecha Final Inválida \n";        
    }else{

    }

    if(validarnVecesEnviar()==false){
        error=1;
        msg+="# de Veces a Enviar Inválido \n";        
    }else{

    }    
*/
    if(validarsTituloMensaje()==false){
        error=1;
        msg+="Titulo de Notificación Inválido \n";        
    }else{

    }    

    if(validarsMensaje()==false){
        error=1;
        msg+="Mensaje por notificar Inválido \n";        
    }else{

    }    

    if(error==0){
     	notificacionRegistrar();
    }else{
        jAlert(msg, 'Mensaje');
    }

}
function validarnCadenas() {
    if($("select[name='nCadenas[]']").val() === null){
        return false;
    }else{
        return true;
    }       
}
function validarnTiendas() {
    if($("select[name='nTiendas[]']").val() === null){
        return false;
    }else{
        return true;
    }      
}
function validarnOperadores() {
    if($('input:radio[name=nTipoUsuario]:checked').val() === undefined){
        return false;
    }else{
        return true;
    }       
}
function validarfechas() {
    if($("#dFechasEnvio").val().length>=1){
        return true;
    }else{
        return false;
    }       
}
/*
function validarnIdPeriodo() {
    if($("#nIdPeriodo").val().length>=1){
        return true;
    }else{
        return false;
    }       
}
function validarfecha1() {
    if($("#fecha1").val().length>=1){
        return true;
    }else{
        return false;
    }       
}
function validarfecha2() {
    if($("#fecha2").val().length>=1){
        return true;
    }else{
        return false;
    }       
}
function validarnVecesEnviar() {
    if($("#nVecesEnviar").val().length>=1){
        return true;
    }else{
        return false;
    }       
}
*/
function validarsTituloMensaje() {
    if($("#sTituloMensaje").val().length>=1){
        return true;
    }else{
        return false;
    }       
}
function validarsMensaje() {
    if($("#sMensaje").val().length>=1){
        return true;
    }else{
        return false;
    }       
}

function notificacionRegistrar() {
	var rutaForelosMovimientos=BASE_PATH+"/amp/notificacion/controllers/notificacionOperadores.php";    
    let formData = new FormData();
    formData.append('CksTituloMensaje', $('#sTituloMensaje').val() );
    formData.append('CksMensaje', $('#sMensaje').val() );
    formData.append('CknOperadores', $('#nOperadores').val() );
	formData.append('usuario_logueado', $('#usuario_logueado').val() );
    formData.append('CkdFechasEnvio', $('#dFechasEnvio').val() );
    formData.append('hnOperadores', $('#hnOperadores').val() );
    var producto="";
    var operadores = '';
    showSpinner();
    $.ajax({
      url: rutaForelosMovimientos,
      data: formData,
      type: "post",
      dataType: "json",
      cache: false,
      contentType: false,
      processData: false
    }).done(function(resp) {
 		jAlert(resp.sMensaje, 'Mensaje');
        location.reload();
    }).fail(function(resp){
        jAlert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
    }).always(function(){
        hideSpinner();
    });  
}