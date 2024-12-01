var error = 0;
var msg = '';
$(function(){
    consultar_prospectos();
});

function consultar_prospectos(){
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
        url: "../ajax/getAutorizacionProspecto.php",
        type: "post",
        dataType: "json"
    })
    .done(function(response){
        var obj = response['data'];
        $.each(obj, function(index, value) {
            tbody += '<tr>';
                tbody += '<td class="text-center">'+obj[index]['sRFC']+'</td>';
                tbody += '<td class="text-center">'+obj[index]['sCURP']+'</td>';
                tbody += '<td class="text-center">'+obj[index]['sUsuario']+'</td>';
                tbody += '<td class="text-center">';
                    tbody += '<button class="btn btn-primary" onclick="autorizarProspecto('+obj[index]['nIdUsuario']+')" >Autorizar</button>';
                tbody += '</td>';
            tbody += '</tr>';   
            $("#tbodyAutorizacionProspecto").append(tbody);
            tbody = '';
        }); 
        datos.DataTable(settings);
    }).fail(function(resp){
            alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
        }).always(function(){
            hideSpinner();
        });   
}

function autorizarProspecto(nIdUsuario){
    showSpinner();
    $.ajax({
        url: "../ajax/guardarAutorizacionProspecto.php",
        type: "post",
        dataType: "json",
        data: {"nIdUsuario":nIdUsuario}
    })
    .done(function(res){
        let dataResponse = res.data;
        if (dataResponse.code == 1) {
            alert(dataResponse.msg);
            consultar_prospectos();
        }else{
            alert(dataResponse.msg);
        }
    }).fail(function(resp){
            alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
        }).always(function(){
            hideSpinner();
        });
}
