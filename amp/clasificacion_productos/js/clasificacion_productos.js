var error = 0;
var msg = '';
$(function(){
    consultar_clasificacion();
    //chida();
});

function consultar_clasificacion(){
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
    $.ajax({
        url: "../ajax/clasificacion_productos.php",
        type: "post",
        dataType: "json"
    })
    .done(function(response){
        var obj = response['data'];
        $.each(obj, function(index, value) {
                
            tbody += '<tr>';
                tbody += '<td class="text-center">';
                    tbody += '<span class="badge light badge-'+obj[index]["statusComponente"]+'"><i class="fa fa-circle text-'+obj[index]["statusComponente"]+'"></i></span>';
                tbody += '</td>';
                tbody += '<td class="text-center">'+obj[index]['sEmisor']+'</td>';
                tbody += '<td class="text-center">$0.00</td>';
                tbody += '<td class="text-center">$0.00</td>';
                tbody += '<td class="text-center">$0.00</td>';
                tbody += '<td class="text-center">$0.00</td>';
                tbody += '<td class="text-center">';
                    tbody += '<select class="form-select form-control form-control-sm" id="cmbTipoServicio'+obj[index]["nIdEmisor"]+'" name="cmbTipoServicio[]" aria-label="Tipo Servicio">';
                        tbody += '<option value="">Seleccione una opción</option>';
                        tbody += '<option value="1">Telefonia</option>';
                        tbody += '<option value="2">Servicios</option></select>';
                tbody += '</td>';
            tbody += '</tr>';   
            $("#tbodyClasificaProductos").append(tbody);
            tbody = '';
            $("#cmbTipoServicio"+obj[index]["nIdEmisor"]+" option[value='"+obj[index]["nIdTipoClasificacion"]+"']").attr("selected","selected"); 
        }); 
        datos.DataTable(settings);
    }).fail(function(resp){
            alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
        }).always(function(){
            hideSpinner();
        });   
}
//function chida(){
//    $(document).on('change', 'name = "cmbTipoServicio"')
//}
function registrarClasificacion(){
    var data=[];
    $("select[name='cmbTipoServicio[]']").each(function() {
            data.push($(this).val());
    });
        //console.log(data);
/*    let formData = new FormData();
    formData.append('txtNombre', $("#txtNombre").val());
    formData.append('txtDescripcion', $("#txtDescripcion").val());
    formData.append('imgAnuncio', $('#imgAnuncio')[0].files[0]);

    $.ajax({
        url: "../ajax/guardar_conf_anuncio.php",
        type: "post",
        dataType: "json",
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    })
    .done(function(res){
            let dataResponse = res.data;
            if (dataResponse.data > 0 && dataResponse.responseAWS == 1) {
                alert('Anuncio guardado correctamente');
            }else{
                alert("Error al guardar archivo");
            }
    });  */ 
}
