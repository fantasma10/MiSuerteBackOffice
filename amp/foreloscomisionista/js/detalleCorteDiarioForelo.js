var error = 0;
var msg = '';
$(function(){ 
    corteDiarioForelo();
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
function exportarExcel(){
    let errorExcel = 0;
    let nidUsuarioReporte = $("#excel_hnIdUsuarioReporte").val($("#nIdUsuarioReporte").val());
    let nCuenta = $("#excel_hnCuenta").val($("#hnCuenta").val());
    let NombreCadena = $("#excel_NombreCadena").val();
    let fecha1og = $("#fecha1").val();
    let dFecha1 = $("#excel_hfecha1").val(fecha1og);
    let fecha2og = $("#fecha2").val();
    let dFecha2 = $("#excel_hfecha2").val(fecha2og);
    if (nidUsuarioReporte =="" || nCuenta == "") {
        alert('Datos de usuario o número de cuenta no encontrados');
        errorExcel = 1;
    }
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
    let nidUsuarioReporte = $("#pdf_hnIdUsuarioReporte").val($("#nIdUsuarioReporte").val());
    let nCuenta = $("#pdf_hnCuenta").val($("#hnCuenta").val());
    let NombreCadena = $("#pdf_NombreCadena").val();
    let fecha1og = $("#fecha1").val();
    let dFecha1 = $("#pdf_hfecha1").val(fecha1og);
    let fecha2og = $("#fecha2").val();
    let dFecha2 = $("#pdf_hfecha2").val(fecha2og);
    if (nidUsuarioReporte =="" || nCuenta == "") {
        alert('Datos de usuario o número de cuenta no encontrados');
        errorPDF = 1;
    }
    if (fecha1og > fecha2og) {
        alert('La fecha inicial no puede ser mayor a la final');
        errorPDF = 1;
    }
    if (errorPDF == 0) {
        $("#pdfex").submit();
    }
}
function corteDiarioForelo(){   
    let fecha1og = $("#fecha1").val();
    let fecha2og = $("#fecha2").val();
    if (fecha1og > fecha2og) {
        alert('La fecha inicial no puede ser mayor a la final');
    }else{

        var tbody = '';
        showSpinner();
        var settings = {"iDisplayLength": 10,
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
        datos.fnDestroy();
    
        var rutaForelosMovimientos=BASE_PATH+"/amp/foreloscomisionista/controllers/detalleCorteDiarioForelo.php";    
        let formData = new FormData();
        formData.append('Ck_nNumCuenta', $('#hnCuenta').val() );
        formData.append('Ck_dFechaInicio', $('#fecha1').val() );
        formData.append('Ck_dFechaFinal', $('#fecha2').val() );
        formData.append('Ck_nIdUsuario', $('#nIdUsuarioReporte').val() );
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
            $.each(obj, function(index, value) {
                tbody += '<tr>';
                    tbody += '<td class="text-center">'+obj[index]['fecAppMov']+'</td>';
                    tbody += '<td class="text-center">$'+formatMoney(obj[index]['saldoInicial'], 2, ".", ",")+'</td>';
                    tbody += '<td class="text-center">$'+formatMoney(obj[index]['cargoMov'], 2, ".", ",")+'</td>';
                    tbody += '<td class="text-center">$'+formatMoney(obj[index]['abonoMov'], 2, ".", ",")+'</td>';
                    tbody += '<td class="text-center">$'+formatMoney(obj[index]['saldoFinal'], 2, ".", ",")+'</td>';
                    
                tbody += '</tr>';   
                $("#tbodyReporteCorteDiarioForelo").append(tbody);
                tbody = '';
            }); 
            datos.DataTable(settings);
        }).fail(function(resp){  
                alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
            }).always(function(){
                hideSpinner();
            });   
    }

}