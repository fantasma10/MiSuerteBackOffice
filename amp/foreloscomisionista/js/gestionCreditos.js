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
function gestionCreditos() {
    var statusCredito = $("#statusCredito").val();
    var flag = 0;
    if(statusCredito.trim() == ''){
        alert("Por favor, seleccione una opcion de 'Estado de Credito'");
        flag = 1;
    }

    if(flag == 0)
    {
        var tbody = '';
        showSpinner();
        var rutaForelosComisionista=BASE_PATH+"/amp/foreloscomisionista/controllers/gestionCreditos.php";    
        let formData = new FormData();
        formData.append('fecha1', $("#fecha1").val() );
        formData.append('fecha2', $("#fecha2").val() );
        formData.append('statusCredito', statusCredito );
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
            if(resp.data.length == 0){ alert("No se encontraron resultados"); }
            else
            {
                var obj =  (resp.data.data);
                jQuery.each(obj, function(index, value){            
                    var nIdEstatus = obj[index]['IdEstatus'];
                    var btnReg='';
                    var flag
                    if (nIdEstatus==1){ flag=1; btnReg='<a data-toggle="modal" data-target="#consultarComisionista" onclick="gestionCreditosDetalle('+obj[index]['IdsMovimiento']+');" class="btn btn-primary btn-block">Reg.</a>'; }
                    tbody += '<tr>';
                        tbody += '<td class="text-center">'+obj[index]['FechaSolicitud']+'</td>'; 
                        tbody += '<td class="text-center">'+obj[index]['RazonSocialNombre']+'</td>'; 
                        tbody += '<td class="text-center">$'+formatMoney(obj[index]['CreditoOtorgado'], 2, ".", ",")+'</td>'; 
                        tbody += '<td class="text-center">'+obj[index]['NombreSolicitante']+'</td>'; 
                        tbody += '<td class="text-center">'+obj[index]['NombreAutorizo']+'</td>'; 
                        tbody += '<td class="text-center">'+obj[index]['Cobrado']+'</td>'; 
                        tbody += '<td class="text-center">'+btnReg+'</td>';
                    tbody += '</tr>';   
                });
                $("#tbodyReporteCreditosComisionistas").html(tbody);
                tbody = '';  
            }
        }).fail(function(resp){
            alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
        }).always(function(){
            hideSpinner();
        });  
    }
}
function resetgestionCreditosDetalle() {
    $("#idsMovimiento").val('');
    $("#sRazonSocial").val('');
    $("#sNombreCadena").val('');
    $("#nMontoCredito").val('');
    $("#dFecRegistro").val('');
    $("#sNombreAutorizo").val('');
    $("#sSaldoCredito").val('');
    $("#sMontoPago").val('');
    $("#sSaldoDespuesPago").val('');
    $("#nFolioRecibo").val('');
    $("#fecha").val('');
}
function gestionCreditosDetalle(idsMovimiento) {
    resetgestionCreditosDetalle();
    $("#idsMovimiento").val(idsMovimiento);
    var rutaForelosComisionista=BASE_PATH+"/amp/foreloscomisionista/controllers/gestionCreditosDetalle.php";    
    let formData = new FormData();
    formData.append('idsMovimiento', idsMovimiento);
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
        var obj =  (resp.data.data);
        jQuery.each(obj, function(index, value) {
            $("#sRazonSocial").val(obj["RazonSocial"]);
            $("#sNombreCadena").val(obj["Nombre"]);
            $("#nMontoCredito").val('$'+formatMoney(obj["MontoCredito"], 2, ".", ",") );
            $("#dFecRegistro").val(obj["FecRegistro"].substr(0,10));
            $("#sNombreAutorizo").val(obj["NombreAutorizo"]);
            $("#sSaldoCredito").val(obj["SaldoCredito"]);
        });       
    }).fail(function(resp){
        jAlert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde', 'Mensaje');
    }).always(function(){
        hideSpinner();
    });  
}
function gestionCreditosValidaPago() {
    var error=0;
    var msg="";
    var errorcontrasena=0;      
    if(validarMonto()==false){
        error=1;
        msg+="Monto Inválido ";        
    }else{

    }
    if(validarFolio()==false){
        error=1;
        msg+="Folio Inválido "; 
    }else{

    }
    if(validarFechaPago()==false){
        error=1;
        msg+="Fecha Inválida ";
    }else{

    }

    if(error==0){
        gestionCreditosRegistrarPago();
    }else{
        jAlert(msg, 'Mensaje');
    }

}
function validarMonto() {
    if($("#sMontoPago").val().length>=1){
        return true;
    }else{
        return false;
    }       
}
function validarFolio() {
    if($("#nFolioRecibo").val().length>=1){
        return true;
    }else{
        return false;
    }       
}
function validarFechaPago() {
    if($("#fecha").val().length==10){
        return true;
    }else{
        return false;
    }       
}
function gestionCreditosRegistrarPago() {
    showSpinner();
    var rutaForelosComisionista=BASE_PATH+"/amp/foreloscomisionista/controllers/gestionCreditosRegistrarPago.php";    
    let formData = new FormData();
    formData.append('idsMovimiento', $("#idsMovimiento").val() );
    formData.append('CksMontoPago', $("#sMontoPago").val() );
    formData.append('CksSaldoDespuesPago', $("#sSaldoDespuesPago").val() );
    formData.append('CknFolioRecibo', $("#nFolioRecibo").val() );
    formData.append('Ckfecha', $("#fecha").val() );
    formData.append('CknIdusuarioRE', $("#nIdusuarioRE").val() );
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
            var obj =  (resp.data.data);
            jAlert(resp.sMensaje, 'Mensaje');
            if(resp.nCodigo == 0){
              $('#consultarComisionista').modal('hide');
              resetgestionCreditosDetalle();
            }
    }).fail(function(resp){
        jAlert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde', 'Mensaje');
    }).always(function(){
        hideSpinner();
    });  
}

function exportarExcel(){
    let errorExcel = 0;
    $("#excel_hnstatusCredito").val($("#statusCredito option:selected").val());
    let fecha1og = $("#fecha1").val();
    let dFecha1 = $("#excel_hfecha1").val(fecha1og);
    let fecha2og = $("#fecha2").val();
    let dFecha2 = $("#excel_hfecha2").val(fecha2og);
    if (fecha1og > fecha2og) {
        alert('La fecha inicial no puede ser mayor a la final');
        errorExcel = 1;
    }
    if (errorExcel == 0) {
        $("#excel").submit();
    }
}
function exportarPDF(){
    let errorPDF = 0;
    $("#pdf_hnstatusCredito").val($("#statusCredito option:selected").val());
    let fecha1og = $("#fecha1").val();
    let dFecha1 = $("#pdf_hfecha1").val(fecha1og);
    let fecha2og = $("#fecha2").val();
    let dFecha2 = $("#pdf_hfecha2").val(fecha2og);
    if (fecha1og > fecha2og) {
        alert('La fecha inicial no puede ser mayor a la final');
        errorPDF = 1;
    }
    if (errorPDF == 0) {
        $("#pdfex").submit();
    }
}