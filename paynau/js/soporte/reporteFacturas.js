var operaciones = {
    nIdProveedor : 0,
    nIdEmpresa : 0,
    initInPuts : function(){
        var date    = new Date();
        var dia = date.getDate() <10 ? '0'+date.getDate() : date.getDate();
        var mesI = date.getMonth() <10 ? '0'+date.getMonth() : date.getMonth();
        var mesF = (date.getMonth()+1) <10 ? '0'+(date.getMonth()+1) : date.getMonth()+1;
		fechaInicio = date.getFullYear()+'-'+ mesI+'-'+dia;
        fechaFin    = date.getFullYear()+'-'+ mesF+'-'+dia;
        $('#dFechaInicio').val(fechaInicio);
        $('#dFechaFin').val(fechaFin);
        
        $('#opcionBusqueda').on('change',function(){
            var opcionBusqueda = $('#opcionBusqueda').val();
            if(opcionBusqueda ==1){
                $('#busquedaFiltro').hide();
                $('#divEmpresas').hide();
                var nIdProveedor = 0;
            }else{
                
                operaciones.cargarListas(1);
                $('#busquedaFiltro').show();
            }
        });
        $('#selcetBusqueda').on('change',function(){
            if ($('#selcetBusqueda').val()!= 0) {
                operaciones.nIdProveedor = $('#selcetBusqueda').val();
                $('#btnBuscarOperaciones').click();
                operaciones.cargarListas(0);
            }
        });
        $('#divEmpresas').on('change',function(){
            if ($('#cmbEmpresas').val()!= 0) {
                operaciones.nIdProveedor = 0 ;
                operaciones.nIdEmpresa = $('#cmbEmpresas').val();
                $('#btnBuscarOperaciones').click();
            }
        });

    },
    cargarListas: function(nIdBusqueda){
            if (nIdBusqueda != 0) {
                 
                 $('#selcetBusqueda').customLoadStore({
                    url             : BASE_PATH + '/paynau/ajax/facturacion/getProveedores.php',
                    labelField      : 'sRazonSocial',
                    idField         : 'nIdProveedor',
                    firstItemId     : '0',
                    firstItemValue  : 'Selecciona un proveedor'
                });
            }
            else{
                $('#cmbEmpresas').customLoadStore({
                    url             : BASE_PATH + '/paynau/ajax/facturacion/getProveedores.php',
                    params          : {nIdProveedor : operaciones.nIdProveedor},
                    labelField      : 'sRazonSocial',
                    idField         : 'nIdEmpresa',
                    firstItemId     : '0',
                    firstItemValue  : 'Selecciona un proveedor'
                });
                $('#divEmpresas').show();
            }
            
        
            
        
    },
    initButtons : function(){
        $('#btnBuscarOperaciones').on('click',function(){
            fechaInicio = $("#dFechaInicio").val();
            fechaFinal = $("#dFechaFin").val();

            validacionFecha = validarFechas(fechaInicio, fechaFinal);
            if(validacionFecha){
                operaciones.cargarDatos();
            }else{
                jAlert('La fecha inicial no puede ser mayor a la decha final');
            }

        });

        $("#dFechaInicio").on('change',function(){
            $('#btnBuscarOperaciones').click();
        });
        $("#dFechaFin").on('change',function(){
            $('#btnBuscarOperaciones').click();
        });
        $('#exportar_excel').on('click', function(e){
            $('#exportar_excel').submit();
            
        });
    },
    cargarDatos: function(){
        var settings = {"iDisplayLength": 10, // configuracion del lenguaje del plugin de la tabla
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


        $("#foliosFacturas tbody").empty();
        var datos = $("#foliosFacturas").DataTable();
        datos.fnClearTable();
        datos.fnDestroy();


        var fechaIni = $("#dFechaInicio").val();
        var fechaFin = $("#dFechaFin").val();
        $.post(BASE_PATH +"/paynau/ajax/soporte/reporteFacturas.php",
        {

            fechaIni : fechaIni,
            fechaFin : fechaFin,
            nIdProveedor : operaciones.nIdProveedor,
            nIdEmpresa : operaciones.nIdEmpresa
        }, 
        function(response){
            $('#foliosFacturas tbody').empty();
             var obj = jQuery.parseJSON(response);
              jQuery.each(obj, function(index,value) {

            nombreEstado = obj[index]['nombreEstado'].split('-')[0];
            fechaOperaciones = obj[index]['dPeticion'];
            sRazonSocialEmisor = obj[index]['sRazonSocialEmisor'];
            clasePDF = 'sucsses';
            claseIcon = 'fade';
            FolioFiscal = obj[index]['strFolioFiscal'];
             $('#foliosFacturas tbody').append('<tr>'+
                    '<td > '+obj[index]['sRazonSocialEmisor']+'</td>'+
                    '<td > '+obj[index]['sRFCEmisor']+'</td>'+
                    '<td > '+obj[index]['strSerie']+'</td>'+
                    '<td > '+obj[index]['dFechaRegistro']+'</td>'+
                    '<td > '+obj[index]['totTotal']+'</td>'+
                    '<td > '+obj[index]['strRFC']+'</td>'+
                    '<td > '+obj[index]['strRazonSocial']+'</td>'+
                    

                    '<td > '+nombreEstado+'</td>'+

                    '<td> <a href="#" name="'+obj[index]['nStatus']+'" onclick="verPDF(this);" id ="'+obj[index]['strFolioFiscal'] +'" class="'+clasePDF+'" ><span class="'+claseIcon+'"></span>descargar</a></td>'+
                    // '<td> <button name="verFactura" onclick="verPDF(this);" data-factura='+obj[index]['strFolioFiscal']+' data-nombreProveedor ="'+obj[index]['sRazonSocialEmisor']+'";  data-placement="top" rel="tooltip" title="Ver Factura" class="btn habilitar btn-default btn-xs" data-title="Ver Informacion"><span class="fa fa-search"></span></button></td>'+
                    '</tr>');
              });
            datos.DataTable(settings); 
        })
        .fail(function(response) {
            console.log('error' +response);
        })
        .always(function() {
            console.log("complete");
        });
        
    }
}


var settings = {"iDisplayLength": 10, // configuracion del lenguaje del plugin de la tabla
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
function initOperaciones(){
    //operaciones.cargarLista();
    operaciones.initInPuts();
    operaciones.initButtons();
}
initOperaciones();

function validarFechas(fechaInicio, fechaFin){
    if(fechaInicio <= fechaFin){
      return true;
    }
    else{
      return false;
    }
  }

function verPDF(registro){
   
    UUID = registro.id;
    estadoFactura = registro.name;
    generar = estadoFactura == 0 ? 1 : 0;
    
    generar > 0 ? (
        showSpinner(),
        $.post(BASE_PATH + '/paynau/ajax/soporte/getEnlaceFactura.php',{UUID:UUID},
            function(response){
                var obj = jQuery.parseJSON(response);   
                urlFactura = obj['url'];
                hideSpinner();
                if (urlFactura != null) {
                    window.open(urlFactura, 'Factura');
                }else{
                    jAlert('Error al obtener el archivo, vuelva a intentar mas tarde');
                } 
            }
        )
    ) : (UUID = '', jAlert('La factura no se encuentra timbrada, espere a que el estatus sea Timbrada y vuelva a intentar'))
}

