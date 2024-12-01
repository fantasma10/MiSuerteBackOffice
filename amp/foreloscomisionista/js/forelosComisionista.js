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
function soloNumeros() {
    var regex = new RegExp("^[0-9]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
      event.preventDefault();
      return false;
    }
}
function resetbuscaModalComisionista() {
    $("#buscaComisionista").val('');
    resetbuscaComisionista();
}
function resetbuscaComisionista() {
    $("#BtnEdocuenta").hide();
    $("#BtnCredito").hide();
    $("#sNombreComisionista").val('');
    $("#TipoPerso").val('');
    $("#sNombreCadena").val('');
    $("#sRFC").val('');
    $("#sCalle").val('');
    $("#sNumExterior").val('');
    $("#sNumInterior").val('');
    $("#sColonia").val('');
    $("#sMunicipio").val('');
    $("#sEstado").val('');
    $("#nCodigoPostal").val('');
    $("#saldoCuenta").val('');
    $("#sNumeroTiendas").val('');
    $("#hnIdUsuario").val('');
    $("#hnIdSucursal").val('');
    $("#txtnIdForelo").val('');
    $("input[name='rangoReglas[]']").val('');
    $("input[name='nIdrangoReglas[]']").val('');
    $(".rangoReglas").val('');
    $(".rangoReglas").removeAttr('style');
    $(".tiendas").attr('id','');
    $("#sIdTipoCredito").val('');
}
function buscaComisionista() {   
    resetbuscaComisionista();
    if($("#buscaComisionista").length){              
        $("#buscaComisionista").autocomplete({
            source: function( request, respond ) {
                $.post(BASE_PATH+"/amp/foreloscomisionista/controllers/forelosComisionista.php",{ buscaComisionista : request.term },
                function( response ) {
                    respond(response.data.data);
                }, "json" );                    
            },
            minLength: 1,
            focus: function( event, ui ) {
                $("#buscaComisionista").val(ui.item.nIdCorresponsalRE+' : '+ui.item.sNombre+' '+ui.item.sApellidoPaterno+' '+ui.item.sApellidoMaterno);
                return false;
            },
            select: function( event, ui ) {
                $("#idComisionista").val(ui.item.nIdUsuario);
                buscaComisionistaDetalle(ui.item.nIdUsuario);
                return false;
            }
        })
        .data("ui-autocomplete")._renderItem = function( ul, item ) {
            return $('<li>')
            .append( "<a>" + item.nIdCorresponsalRE+' : '+item.sNombre+' '+item.sApellidoPaterno+' '+item.sApellidoMaterno + "</a>" )
            .appendTo( ul );
        }
    }    
}
function buscaComisionistaDetalle($nIdUsuario) { 
    resetbuscaComisionista();    
    var rutaForelosComisionista=BASE_PATH+"/amp/foreloscomisionista/controllers/forelosComisionistaDetalle.php";    
    let formData = new FormData();
    formData.append('nIdUsuario', $nIdUsuario);
    var producto="";
    $.ajax({
      url: rutaForelosComisionista,
      data: formData,
      type: "post",
      dataType: "json",
      cache: false,
      contentType: false,
      processData: false
    }).done(function(resp) {    
        var obj =  (resp.data.data);    console.log(obj);
        jQuery.each(obj, function(index, value) {
            $("#BtnEdocuenta").show();
            $("#TipoPerso").val(obj[index]["TipoPerso"]);
            $("#nIdUsuarioReporte").val(obj[index]["nIdUsuario"]);
            $("#hnIdUsuario").val(obj[index]["nIdUsuario"]);
            $("#hnIdSucursal").val(obj[index]["nIdSucursal"]);
            $(".tiendas").attr('id',obj[index]["nIdSucursal"]);
            $(".rangoReglasTienda").addClass('rangoReglasTienda'+obj[index]["nIdSucursal"]);
            ReglasNotificacionForelo( obj[index]["nIdUsuario"], obj[index]["nIdSucursal"] );
            if(obj[index]["idRegimen"]==1) {
                $("#slabelNombre").html('Nombre del Comisionista');
                $("#slabelCadena").html('Nombre de la Cadena');
                $("#sNombreComisionista").val(obj[index]["sNombre"]+' '+obj[index]["sApellidoPaterno"]+' '+obj[index]["sApellidoMaterno"]);
                $("#sNombreCadena").val(obj[index]["sNombreCadena"]);
                $("#hsNombreComisionista").val(obj[index]["sNombre"]+' '+obj[index]["sApellidoPaterno"]+' '+obj[index]["sApellidoMaterno"]);
                $("#hsNombreCadena").val(obj[index]["sNombreCadena"]);
            }
            if(obj[index]["idRegimen"]==2) {                    
                $("#slabelNombre").html('Razón social');
                $("#slabelCadena").html('Nombre Comercial');
                $("#sNombreComisionista").val(obj[index]["sRazonSocial"]);
                $("#sNombreCadena").val(obj[index]["sNombreCadena"]);
                $("#hsNombreComisionista").val(obj[index]["sRazonSocial"]);
                $("#hsNombreCadena").val(obj[index]["sNombreCadena"]);
            }               
            $("#sRFC").val(obj[index]["sRFC"]);
            $("#sCalle").val(obj[index]["sCalle"]);
            $("#sNumExterior").val(obj[index]["sNumExterior"]);
            $("#sNumInterior").val(obj[index]["sNumInterior"]);
            $("#sColonia").val(obj[index]["sColonia"]);
            $("#sMunicipio").val(obj[index]["sMunicipio"]);
            $("#sEstado").val(obj[index]["sEstado"]);
            $("#nCodigoPostal").val(obj[index]["nCodigoPostal"]);
            $("#saldoCuenta").val( '$'+formatMoney(obj[index]["saldoCuenta"], 2, ".", ",")  );
            $("#hnCuenta").val(obj[index]["numCuenta"]);
            $("#sNumeroTiendas").val(obj[index]["sNumeroTiendas"]);
            $("#hsRazonSocial").val(obj[index]["idCliente"] +' : '+obj[index]["RazonSocial"] );
            $("#hnsCuenta").val(obj[index]["numCuenta"]);
            $("#hnidCliente").val(obj[index]["idCliente"]);
            $("#hbCredito").val(obj[index]["bCredito"]);
            $("#hnIdTipoCredito").val(obj[index]["nIdTipoCredito"]);
            $("#nClabe").html(obj[index]["CLABE"]);
            if (obj[index]["DepositoComisiones"]=='FORELO') {
                $("#FORELO").show();
                $("#CLABE").hide();
                $("#Radio2").attr('checked','checked');
            }
            if (obj[index]["DepositoComisiones"]=='BANCO') {
                $("#FORELO").hide();
                $("#CLABE").show();
                $("#Radio1").attr('checked','checked');
            }
            if (obj[index]["bCredito"]=='1') {
                $("#BtnCredito").show();
                $("#sIdTipoCredito").val('Crédito');
            }else{
                $("#BtnCredito").hide();
                $("#sIdTipoCredito").val('Prepago');
            }
            if (obj[index]["bForeloIndividual"]=='1') {
                $("#bForeloIndividual").html('Individual');
            }else{
                $("#bForeloIndividual").html('Compartido');
            }   
            $("#sCFDI").val( obj[index]["sUsoCFDI"] );
            $("#nIVA").val( obj[index]["nIdIVA"] );
        });       
    });
}
function ReglasNotificacionForelo(nIdUsuario,nIdSucursal) {
    var rutaReglasNotificacionForelo=BASE_PATH+"/amp/foreloscomisionista/controllers/reglasNotificacionForelo.php";    
    let formData = new FormData();
    formData.append('nIdUsuario', nIdUsuario);
    var producto="";
    var bSmsAlerta =0;
    var bMostrarForelo =0;
    $.ajax({
      url: rutaReglasNotificacionForelo,
      data: formData,
      type: "post",
      dataType: "json",
      cache: false,
      contentType: false,
      processData: false
    }).done(function(resp) {
        console.log(resp);
        var obj =  (resp.data.data);
        jQuery.each(obj, function(index, value) {  
            if (obj[index]["nIdSucursal"]==nIdSucursal) {
                $("#nIdTipoForelo"+obj[index]["nIdTipoForelo"]).val( formatMoney(obj[index]["Valor"], 2, ".", "")  );
                obj[index]["nIdForeloDetalle"];
                obj[index]["nIdtxt"];
                obj[index]["nIdTipoForelo"];
                $("#txtnIdForelo").val(  obj[index]["nIdForelo"]  );
                $("#ids"+obj[index]["nIdTipoForelo"]).attr('name','nIdrangoReglas['+obj[index]["nIdTipoForelo"]+']['+obj[index]["nIdForeloDetalle"]+']'  );
                if(obj[index]["bSmsAlerta"] == 1){
                    $("#bS").attr('checked','checked');
                }else{
                    $("#bS").removeAttr('checked');
                }                
                if(obj[index]["bMostrarForelo"] == 1){
                    $("#bM").attr('checked','checked');    
                }else{
                    $("#bM").removeAttr('checked');
                }
            }            
        });       
    });
}
function validarRangos() {
    var rangosLlenos=true;    
    var myArrayCadenas = [];
    $(".rangoReglas").each(function() {        
        if ($(this).val().length<=0){
            $(this).attr('style'," border-color: #dc3545; ");
            rangosLlenos=false;
        }else{
            $(this).removeAttr('style');
            $(this).attr('style'," border-color: #01c6c4; ");
        }
    });
    $(".tiendas").each(function() {
        myArrayCadenas.push( $(this).attr('id') );
    });
    $.each(myArrayCadenas, function (ind, elem) { 
        var myArray = [];
        var myArrayIds = [];
        var linea=true;
        $(".rangoReglasTienda"+elem).each(function() {            
            if($(this).val()!=''){ myArray.push( $(this).val()); }
        });
        $(".rangoReglasTienda"+elem).each(function() {            
            if($(this).val()!=''){ myArrayIds.push( $(this).attr('id')); }
        });         
        $.each(myArray, function (ind, elem) {
            if (parseFloat(myArray[ind+1])>=parseFloat(myArray[ind]) ) { 
                linea=false;
                $("#"+myArrayIds[ind]).attr('style'," border-color: #dc3545; ");
                $("#"+myArrayIds[ind+1]).attr('style'," border-color: #dc3545; ");
                rangosLlenos=false;
            }else{
            }
            
        });         
    });    
    return rangosLlenos;    
}
function validarFormReglasOperacion() {
    var error=0;
    var msg="";
    var errorcontrasena=0;      

    if(validarRangos()==false){
        error=1;
        msg+="Por favor capture los valores correctamente.<br>";
    }
    if(error==0){
        ReglasNotificacionForeloRegistrar();
        
    }else{
        jAlert(msg, 'Mensaje');       
    }
}
function ReglasNotificacionForeloRegistrar() {
    showSpinner();
    var rutaForelosComisionista=BASE_PATH+"/amp/foreloscomisionista/controllers/reglasNotificacionForeloRegistrar.php";    
    $.ajax({
        url: rutaForelosComisionista,
        data:$("#formularioReglas").serialize(),
        method:'post'
    }).done(function(resp) {
        jAlert('Limites de Saldo Registrados', 'Mensaje');
        ReglasNotificacionForelo( $("#hnIdUsuario").val(),$("#hnIdSucursal").val() );
    }).fail(function(resp){
        jAlert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde', 'Mensaje');
    }).always(function(){
        hideSpinner();
    });
}