var error = 0;
var msg = '';
$(function(){
    foreloscomisionista();
});
function formatMoney(amount, decimalCount = 2, decimal = ".", thousands = ",") {
  try {
    decimalCount = Math.abs(decimalCount);
    decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

    const negativeSign = amount < 0 ? "-" : "";

    let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
    let j = (i.length > 3) ? i.length % 3 : 0;

    return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
  } catch (e) {
    console.log(e)
  }
}
function foreloscomisionista(){
    $("#tbodyConfiguracionComisionista").html('');
    var tbody = '';
    showSpinner();
    /*var settings = {"iDisplayLength": 10,
                        "oLanguage": {
                        "sZeroRecords": "No se encontraron registros",
                        "sInfo": "Mostrando _TOTAL_ registros (_START_ de _END_)",
                        "sLengthMenu": "Mostrar _MENU_ registros",
                        "sSearch": "Buscar:"  ,
                        "sInfoFiltered": " - filtrado de _MAX_ registros",
                            "oPaginate": {
                            "sNext": "Siguiente",
                            "sPrevious": " Anterior"
                            }
                        },
                        "bSort" :false
                        };
    $("#data tbody").empty();
    var datos = $("#data").DataTable();
    datos.fnClearTable();
    datos.fnDestroy();*/

    var rutaForelosMovimientos=BASE_PATH+"/amp/foreloscomisionista/controllers/configuracionComisionistas.php";    
    let formData = new FormData();
    formData.append('CksComisionista', $('#sComisionista').val() );
    formData.append('CkbCredito', $('input:radio[name=nIdTipoUsuario]:checked').val() );
    var producto="";
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
            var bCredito ='';
            var bPrepago ='';
            if (obj[index]['bCredito']==1) {  bCredito = 'selected'; }
            if (obj[index]['bCredito']==0) {  bPrepago = 'selected'; }
            var nIdTipoCredito = '';
            var bActivoGrafico="checked";
            if (obj[index]['bActivoGrafico']==0){ bActivoGrafico=""; }            
            if (obj[index]['bCredito']==1 && obj[index]['nIdTipoCredito']==1) { nIdTipoCredito = '<!-- <input class="form-check-input" type="checkbox" value="1" id="nIdTipoCredito'+obj[index]['nIdCadena']+'"  name="nIdTipoCredito'+obj[index]['nIdCadena']+'"   checked disabled   > --> Abierto'; }
            if (obj[index]['bCredito']==1 && obj[index]['nIdTipoCredito']==0) { nIdTipoCredito = ''; }
            if (obj[index]['bCredito']==1 && (obj[index]['nIdTipoCredito']==2 || obj[index]['nIdTipoCredito']==0) ) { nIdTipoCredito = '<!-- <input class="form-check-input" type="checkbox" value="2" id="nIdTipoCredito'+obj[index]['nIdCadena']+'"  name="nIdTipoCredito'+obj[index]['nIdCadena']+'" disabled   > --> Limitado'; }
            tbody += '<tr>';
                if(obj[index]['sNombre'] != '' && obj[index]['sNombre'] != null){
                    tbody += '<td class="text-left">'+obj[index]['nIdCorresponsalRE']+' : '+obj[index]['sNombre']+'</td>';
                }else{
                    tbody += '<td class="text-left">'+obj[index]['nIdCorresponsalRE']+' : '+obj[index]['sNombreRazonSocial']+'</td>';
                }
                tbody += '<td class="text-center"><input class="form-check-input" type="checkbox" value="1" id="bActivoGrafico'+obj[index]['nIdCadena']+'"  name="bActivoGrafico'+obj[index]['nIdCadena']+'" '+bActivoGrafico+' disabled ></td>';
                tbody += '<td class="text-center">'+nIdTipoCredito+'</td>';
                tbody += '<td class="text-center"><button class="btn habilitar btn-default btn-xs" data-toggle="modal" data-target="#Editar"  onclick="detalleForeloscomisionista('+obj[index]['nIdUsuario']+');"  ><span class="fa fa-search"></span></button></td>';
            tbody += '</tr>';            
        }); 
        $("#tbodyConfiguracionComisionista").html(tbody);
        tbody = '';
        //datos.DataTable(settings);
    }).fail(function(resp){
            alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
        }).always(function(){
            hideSpinner();
        });   
}

function configuraComisionista(){
    var rutaForelosMovimientos=BASE_PATH+"/amp/foreloscomisionista/controllers/configurarComisionistas.php";    
    let formData = new FormData();
    formData.append('CknIdCadena', $("#hnIdCadena").val() );
    formData.append('CkbCredito', 1 );
    formData.append('CkbActivoGrafico',  $('input:radio[name=despGrafico]:checked').val()  );
    formData.append('CknIdTipoCredito', $('input:radio[name=tipocredito]:checked').val()  );
    showSpinner();
    var producto="";
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
        jAlert(resp.sMensaje, 'Mensaje');
        foreloscomisionista();        
        $("#Editar").modal('hide');
    }).fail(function(resp){
        alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
    }).always(function(){
        hideSpinner();
    });  
}


function detalleForeloscomisionista(nIdUsuario){
    var rutaForelosMovimientos=BASE_PATH+"/amp/foreloscomisionista/controllers/forelosComisionistaDetalle.php";    
    let formData = new FormData();
    formData.append('nIdUsuario', nIdUsuario );   
    showSpinner();
    var producto="";
    $.ajax({
      url: rutaForelosMovimientos,
      data: formData,
      type: "post",
      dataType: "json",
      cache: false,
      contentType: false,
      processData: false
    }).done(function(resp) {
        var obj =  (resp.data.data);
        jQuery.each(obj, function(index, value) {
            $("#hnIdCadena").val(obj[index]["nIdCadena"])
            $("#sNombreComisionista").val('');
            $("#sNombreCadena").val('');
            $("#hsNombreComisionista").val('');
            $("#hsNombreCadena").val('');
            $("#TipoPerso").html('');
            $("#sIdTipoCredito").html(''); 
            if(obj[index]["idRegimen"]==1) {
                $("#sNombreComisionista").val(obj[index]["sNombre"]+' '+obj[index]["sApellidoPaterno"]+' '+obj[index]["sApellidoMaterno"]);
                $("#sNombreCadena").val(obj[index]["sNombreCadena"]);
                $("#hsNombreComisionista").val(obj[index]["sNombre"]+' '+obj[index]["sApellidoPaterno"]+' '+obj[index]["sApellidoMaterno"]);
                $("#hsNombreCadena").val(obj[index]["sNombreCadena"]);
            }
            if(obj[index]["idRegimen"]==2) {
                $("#sNombreComisionista").val(obj[index]["sRazonSocial"]);
                $("#sNombreCadena").val(obj[index]["sNombreCadena"]);
                $("#hsNombreComisionista").val(obj[index]["sRazonSocial"]);
                $("#hsNombreCadena").val(obj[index]["sNombreCadena"]);
            }
            // $("#TipoPerso").html(obj[index]["TipoPerso"]);  
            $("#TipoPerso").val(obj[index]["TipoPerso"]);  
            if (obj[index]["bCredito"]=='1') {
                // $("#sIdTipoCredito").html('Crédito');
                $("#sIdTipoCredito").val('Crédito');
            }else{
                // $("#sIdTipoCredito").html('Prepago');
                $("#sIdTipoCredito").val('Prepago');
            }
            if (obj[index]['bActivoGrafico']==1){
                $("#despGraficos1").attr('checked','checked');
            }else{
                $("#despGraficos2").attr('checked','checked');
            }
            if (obj[index]['nIdTipoCredito']==1){
                $("#tipocreditoa1").attr('checked','checked');
            }
            if (obj[index]['nIdTipoCredito']==2){
                $("#tipocreditoa2").attr('checked','checked');
            }
        }); 
    }).fail(function(resp){
        alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
    }).always(function(){
        hideSpinner();
    });  
}
function resetdatosUsuarioNotifica() {    
    $("#notifidUsuario option").each(function(){
            if ($(this).data('telefono') != "" && $(this).data('telefono') != undefined ){
                $(this).prop('selected', 'selected');
            }   
    });
}
function datosUsuarioNotifica() {
    $('#notifnombre').val('');
    $('#notifapellidoPaterno').val('');
    $('#notifapellidoMaterno').val('');
    $('#notifCorreoRedEfect').val('');
    $('#notifCorreoPersonal').val('');
    $('#notifTelefono').val('');    
    $('#notifnombre').val($("#notifidUsuario option:selected").data('nombre'));
    $('#notifapellidoPaterno').val($("#notifidUsuario option:selected").data('apellidopaterno'));
    $('#notifapellidoMaterno').val($("#notifidUsuario option:selected").data('apellidomaterno'));
    $('#notifCorreoRedEfect').val($("#notifidUsuario option:selected").data('email'));
    $('#notifCorreoPersonal').val($("#notifidUsuario option:selected").data('correo'));
    $('#notifTelefono').val($("#notifidUsuario option:selected").data('telefono'));
}
function formValidaRegistro() {
    var error=0;
    var msg="";
    var errorcontrasena=0;
    if(validarCorreoPersonal()==false){
        error=1;
        msg+="Correo Personal Inválido \n";        
    }else{

    }
    if(validarTelefono()==false){
        error=1;
        msg+="Teléfono Inválido \n";
    }else{

    }
 if(error==0){
        RegistrarConfiguracion();
    }else{
        jAlert(msg, 'Mensaje');
    }
}
function validarCorreoPersonal() {
    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
        if (regex.test($('#notifCorreoPersonal').val().trim())) {
            return true;
        }else{
            return false;
        }
}
function validarTelefono() {
    if(  $("#notifTelefono").val().trim()!="" && $("#notifTelefono").val().length>9 && $("#notifTelefono").val().length<=13    ){
        return true;
    }else{
        return false;
    }       
}
function RegistrarConfiguracion() {
    var rutaCredito=BASE_PATH+"/amp/foreloscomisionista/controllers/configuracionComisionistasCorreos.php";    
    let formData = new FormData();
    formData.append('CknIdUsuarioRE', $('#notifidUsuario').val() );
    formData.append('CknIdTipoCredito', 1);
    formData.append('Cknombre', $('#notifnombre').val() );
    formData.append('CkapellidoPaterno', $('#notifapellidoPaterno').val() );
    formData.append('CkapellidoMaterno', $('#notifapellidoMaterno').val() );
    formData.append('CkCorreoRedEfect', $('#notifCorreoRedEfect').val() );
    formData.append('CkCorreoPersonal', $('#notifCorreoPersonal').val() );
    formData.append('CkTelefono', $('#notifTelefono').val() );
    var producto="";
    var operadores = '';
    showSpinner();
    $.ajax({
      url: rutaCredito,
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

function formValidaRegistroAutorizadores() {
    var obj = $('input[name^="telefonos"]');
    var count=1;
    var msg="";
    $("#hRespuestaCorreo").val(0);
    // *** saber si estan repetidos los correos ***
    jQuery.each(obj, function(index, value) {
        // if( $('#nombres'+count).val().trim()!="" && $('#nombres'+count).val().length>2){
        //     $('#nombres'+count).removeAttr('style');
        //     $('#nombres'+count).attr('style'," border-color: #01c6c4; ");            
        // }else{
        //     msg+="Nombre Inválido Autorizante "+count+" \n";
        //     $('#nombres'+count).attr('style'," border-color: #dc3545; ");
        // }
        // if( $('#apellidosP'+count).val().trim()!="" && $('#apellidosP'+count).val().length>2){
        //     $('#apellidosP'+count).removeAttr('style');
        //     $('#apellidosP'+count).attr('style'," border-color: #01c6c4; ");
        // }else{
        //     msg+="Apellido Paterno Inválido Autorizante "+count+" \n";
        //     $('#apellidosP'+count).attr('style'," border-color: #dc3545; ");
        // }
        var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
        if (regex.test($('#correos'+count).val().trim())) {
            $('#correos'+count).removeAttr('style');
            $('#correos'+count).attr('style'," border-color: #01c6c4; ");
        }else{
            msg+="Correo Inválido Autorizante "+count+" \n";
            $('#correos'+count).attr('style'," border-color: #dc3545; ");
        }
        // if( $('#telefonos'+count).val().trim()!="" && $('#telefonos'+count).val().length>9 && $('#telefonos'+count).val().length<=13 ){
        //     $('#telefonos'+count).removeAttr('style');
        //     $('#telefonos'+count).attr('style'," border-color: #01c6c4; ");
        // }else{
        //     msg+="Teléfono Inválido Autorizante "+count+" \n";
        //     $('#telefonos'+count).attr('style'," border-color: #dc3545; ");
        // }
        if (msg!="") {
           jAlert(msg, 'Mensaje'); 
        }
        else{
            var rutaCredito=BASE_PATH+"/amp/foreloscomisionista/controllers/configuracionComisionistasCorreos.php";   
            let formData = new FormData();
            formData.append('CknIdUsuarioRE',count );
            formData.append('CknIdTipoCredito', 2);
            formData.append('Cknombre', $('#nombres'+count).val() );
            formData.append('CkapellidoPaterno', $('#apellidosP'+count).val() );
            formData.append('CkapellidoMaterno', $('#apellidosM'+count).val() );
            formData.append('CkCorreoRedEfect', $('#correos'+count).val() );
            formData.append('CkCorreoPersonal', $('#correos'+count).val() );
            formData.append('CkTelefono', $('#telefonos'+count).val() );
            formData.append('CknIdTipoCreditoNoticacion', $('#hnIdTipoCreditoNoticacion'+count).val() );    
            formData.append('CkIdentificador',1);

            showSpinner();
            $.ajax({
                async:false,
                url: rutaCredito,
                data: formData,
                type: "post",
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false
            }).done(function(resp) {
                if(resp.data.data[0].Correo != ''){  
                    $("#hRespuestaCorreo").val(1);
                    jAlert("El correo electronico "+ resp.data.data[0].Correo +" ya se encuentra registrado."); 
                }
            }).fail(function(resp){
                jAlert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
            }).always(function(){
                hideSpinner();
            });
        }
        count++;
    });


    if( ($("#hRespuestaCorreo").val()) == 0 )
    {
        count=1;
        jQuery.each(obj, function(index, value) {
            if( $('#nombres'+count).val().trim()!="" && $('#nombres'+count).val().length>2){
                $('#nombres'+count).removeAttr('style');
                $('#nombres'+count).attr('style'," border-color: #01c6c4; ");            
            }else{
                msg+="Nombre Inválido Autorizante "+count+" \n";
                $('#nombres'+count).attr('style'," border-color: #dc3545; ");
            }
            if( $('#apellidosP'+count).val().trim()!="" && $('#apellidosP'+count).val().length>2){
                $('#apellidosP'+count).removeAttr('style');
                $('#apellidosP'+count).attr('style'," border-color: #01c6c4; ");
            }else{
                msg+="Apellido Paterno Inválido Autorizante "+count+" \n";
                $('#apellidosP'+count).attr('style'," border-color: #dc3545; ");
            }
            var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
            if (regex.test($('#correos'+count).val().trim())) {
                $('#correos'+count).removeAttr('style');
                $('#correos'+count).attr('style'," border-color: #01c6c4; ");
            }else{
                msg+="Correo Inválido Autorizante "+count+" \n";
                $('#correos'+count).attr('style'," border-color: #dc3545; ");
            }
            if( $('#telefonos'+count).val().trim()!="" && $('#telefonos'+count).val().length>9 && $('#telefonos'+count).val().length<=13 ){
                $('#telefonos'+count).removeAttr('style');
                $('#telefonos'+count).attr('style'," border-color: #01c6c4; ");
            }else{
                msg+="Teléfono Inválido Autorizante "+count+" \n";
                $('#telefonos'+count).attr('style'," border-color: #dc3545; ");
            }
            if (msg!="") {
               jAlert(msg, 'Mensaje'); 
            }
            else{
                var rutaCredito=BASE_PATH+"/amp/foreloscomisionista/controllers/configuracionComisionistasCorreos.php";   
                let formData = new FormData();
                formData.append('CknIdUsuarioRE',count );
                formData.append('CknIdTipoCredito', 2);
                formData.append('Cknombre', $('#nombres'+count).val() );
                formData.append('CkapellidoPaterno', $('#apellidosP'+count).val() );
                formData.append('CkapellidoMaterno', $('#apellidosM'+count).val() );
                formData.append('CkCorreoRedEfect', $('#correos'+count).val() );
                formData.append('CkCorreoPersonal', $('#correos'+count).val() );
                formData.append('CkTelefono', $('#telefonos'+count).val() );
                formData.append('CknIdTipoCreditoNoticacion', $('#hnIdTipoCreditoNoticacion'+count).val() );    
                formData.append('CkIdentificador',2);
    
                showSpinner();  
                $.ajax({
                  async:false,
                  url: rutaCredito,
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
        count++;
        });
    }
}



function formRegistroAutorizadores() {
    let obj2 = $('input[name^="telefonos"]');
    let count=1;
    jQuery.each(obj2, function(index, value) {
        if ($('#telefonos'+count).val()!='') {
            console.log($('#apellidosP'+count).val());
        }
        
    /*
        var rutaCredito=BASE_PATH+"/amp/foreloscomisionista/controllers/configuracionComisionistasCorreos.php";    
        let formData = new FormData();
        formData.append('CknIdUsuarioRE', 0 );
        formData.append('CknIdTipoCredito', 2);
        formData.append('Cknombre', $('#nombres'+count).val() );
        formData.append('CkapellidoPaterno', $('#apellidosP'+count).val() );
        formData.append('CkapellidoMaterno', $('#apellidosM'+count).val() );
        formData.append('CkCorreoRedEfect', $('#correos'+count).val() );
        formData.append('CkCorreoPersonal', $('#correos'+count).val() );
        formData.append('CkTelefono', $('#telefonos'+count).val() );
        showSpinner();
        $.ajax({
          url: rutaCredito,
          data: formData,
          type: "post",
          dataType: "json",
          cache: false,
          contentType: false,
          processData: false
        }).done(function(resp) {
            jAlert(resp.sMensaje, 'Mensaje');
        }).fail(function(resp){
            jAlert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
        }).always(function(){
            hideSpinner();
        });*/
     count++;
    });
}

function ResetConfiguracionAut() {
$('#nombres1').val($('#hsNombre0').val());
$('#apellidosP1').val($('#hsApellidoPaterno0').val());
$('#apellidosM1').val($('#hsApellidoMaterno0').val());
$('#correos1').val($('#hsCorreo0').val());
$('#telefonos1').val($('#hnTelefono0').val());

$('#nombres2').val($('#hsNombre1').val());
$('#apellidosP2').val($('#hsApellidoPaterno1').val());
$('#apellidosM2').val($('#hsApellidoMaterno1').val());
$('#correos2').val($('#hsCorreo1').val());
$('#telefonos2').val($('#hnTelefono1').val());

$('#nombres3').val($('#hsNombre2').val());
$('#apellidosP3').val($('#hsApellidoPaterno2').val());
$('#apellidosM3').val($('#hsApellidoMaterno2').val());
$('#correos3').val($('#hsCorreo2').val());
$('#telefonos3').val($('#hnTelefono2').val());
}
