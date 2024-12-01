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
                operaciones.initTable();
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
    initTable : function(){
        var dataTableObj;
        var fechaIni = $("#dFechaInicio").val();
        var fechaFin = $("#dFechaFin").val();

        dataTableObj = $('#foliosFacturas').dataTable({          
                "iDisplayLength"  : 10,  //numero de columnas a desplegar
                    "bProcessing"   : true,     // mensaje 
                    "bServerSide"   : false,    //procesamiento del servidor
                    "bFilter"     : false,       //no permite el filtrado caja de texto
                    "bDestroy": true,           // reinicializa la tabla 
                    "sAjaxSource"       : "../../ajax/facturacion/getRegistrosFacturas.php", //ajax que consulta la informacion
                    "sServerMethod"     : 'POST', //Metodo para enviar la informacion
                    "oLanguage"         : {
                        "sLengthMenu"       : "Mostrar _MENU_",
                        "sZeroRecords"      : "No se ha encontrado información",
                        "sInfo"             : "Mostrando _START_ a _END_ de _TOTAL_ Registros",
                        "sInfoEmpty"        : "Mostrando 0 a 0 de 0 Registros",
                        "sInfoFiltered"     : "(filtrado de _MAX_ total de Registros)",
                        // "sProcessing"       : "<img src='../../../img/cargando3.gif'> Loading...",
                        "sProcessing"       : "Cargando...",
                        "sSearch"           : "Buscar",
                        "oPaginate"         : {
                            "sPrevious"     : "Anterior", // This is the link to the previous page
                            "sNext"         : "Siguiente"
                        }
                    },
                    "aoColumnDefs"    : [ //Desplegado de informacion  target es la posicion en la que viene en la respuesta
                        {
                            'aTargets'  : [0,1,2,3,4,5,6,7,8],
                            "bSortable": false
                        },
                        {
                            "mData"   : 'sRazonSocial',
                            'aTargets'  : [0]
                        },
                        {
                            "mData"   : 'sRFC',
                            'aTargets'  : [1]
                        },
                        {
                            "mData"   : 'strSerie',
                            'aTargets'  : [2]
                        },
                        {
                            "mData"   : 'dPeticion',
                            'aTargets'  : [3]
                        },
                        {
                            "mData"   : 'totTotal',
                            'aTargets'  : [4],
                            "fnRender": function ( data, type, row ) {
                                                        monto =+ data.aData.totTotal;
                                                        var montoTotal = accounting.formatMoney(accounting.toFixed(monto,2),'$');
                                                    return montoTotal;        				
                                                }
                        },
                        {
                            "mData"   : 'strRFC',
                            'aTargets'  : [5]
                        },
                        {
                            "mData"   : 'strRazonSocial',
                            'aTargets'  : [6]
                        },
                        {
                            "mData"   : 'nCantidadFolios',
                            'aTargets'  : [7]
                        },
                        {
                            "mData"   : 'dFechaVigencia',
                            'aTargets'  : [8]
                        }
                    ],
                    "fnDrawCallback" : function(aoData) {
                        
                        if(aoData.aiDisplayMaster.length>0){
                            $('#fechaIni_excel').val($("#dFechaInicio").val());
                            $('#fechaFin_excel').val($("#dFechaFin").val());
                            $('#nIdProveedor_excel').val(operaciones.nIdProveedor);
                            $('#nIdEmpresa_excel').val(operaciones.nIdEmpresa);
                            $("#div_Exportar").fadeIn("normal");
                        }else{
                            $("#div_Exportar").hide();
                        }
                    },
                    "fnPreDrawCallback" : function() {            
                    },
                    
                    "fnServerParams" : function (aoData){//Funcion que se activa al buscar infromacion en la tabla o cambiar de pagina aoData contiene l ainfo del datatable                
                        var params = {};
                        params['fechaIni'] =  fechaIni;
                        params['fechaFin']   =  fechaFin;
                        params['nIdProveedor'] = operaciones.nIdProveedor;
                        params['nIdEmpresa'] = operaciones.nIdEmpresa;

                        $.each(params, function(index, val){
                            aoData.push({name : index, value : val });
                        });
                    },   
                });
                $("#divReportes").show();
                $("#foliosFacturas").css("display", "inline-table");
                $("#foliosFacturas").css("width", "100%");
    },
    cargarDatos: function(){
        var fechaIni = $("#dFechaInicio").val();
        var fechaFin = $("#dFechaFin").val();
        $.ajax({
            url: BASE_PATH + '/paynau/ajax/facturacion/getRegistrosFacturas.php',
            type: 'POST',
            dataType: 'json',
            data: {fechaIni : fechaIni,
                   fechaFin : fechaFin,
                   nIdProveedor : operaciones.nIdProveedor,
                   nIdEmpresa : operaciones.nIdEmpresa
                  },
        })
        .done(function(response) {
            console.log(response);
        })
        .fail(function(response) {
            console.log('error' +response);
        })
        .always(function() {
            console.log("complete");
        });
        
    }
}
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

