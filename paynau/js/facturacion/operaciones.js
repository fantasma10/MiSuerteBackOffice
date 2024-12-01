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
                var nIdProveedor = 0;
            }else{
                
                operaciones.cargarLista(1);
                $('#busquedaFiltro').show();
            }
        });
        $('#selcetBusqueda').on('change',function(){
            if ($('#selcetBusqueda').val()!= 0) {
                operaciones.nIdProveedor = $('#selcetBusqueda').val();
                $('#btnBuscarOperaciones').click();
            }
        })
    },
    cargarLista: function(IdBusqueda){
        if (IdBusqueda == 1) {
            $('#selcetBusqueda').customLoadStore({
                url             : BASE_PATH + '/paynau/ajax/facturacion/getProveedores.php',
                labelField      : 'sRazonSocial',
                idField         : 'nIdProveedor',
                firstItemId     : '0',
                firstItemValue  : 'Selecciona un proveedor'
            });
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
    },
    initTable : function(){
        var dataTableObj;
        var fechaIni = $("#dFechaInicio").val();
        var fechaFin = $("#dFechaFin").val();

        dataTableObj = $('#ventaFolios').dataTable({          
                "iDisplayLength"  : 10,  //numero de columnas a desplegar
                    "bProcessing"   : true,     // mensaje 
                    "bServerSide"   : false,    //procesamiento del servidor
                    "bFilter"     : false,       //no permite el filtrado caja de texto
                    "bDestroy": true,           // reinicializa la tabla 
                    "sAjaxSource"       : "../../ajax/facturacion/getOperaciones_ventaFolios.php", //ajax que consulta la informacion
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
                            'aTargets'  : [0,1,2,3,4,5,6,7,8,9,10,12],
                            "bSortable": false
                        },
                        {
                            "mData"   : 'dFechaCompra',
                            'aTargets'  : [0]
                        },
                        {
                            "mData"   : 'sRazonSocial',
                            'aTargets'  : [1]
                        },
                        {
                            "mData"   : 'sRFC',
                            'aTargets'  : [2]
                        },
                        {
                            "mData"   : 'nCantidadFolios',
                            'aTargets'  : [3]
                        },
                        {
                            "mData"   : 'nPrecioCompra',
                            'aTargets'  : [4]
                        },
                        {
                            "mData"   : 'costoProveedorCFDI',
                            'aTargets'  : [5]
                        },
                        {
                            "mData"   : 'nPrecioVenta',
                            'aTargets'  : [6]
                        },

                        {
                            "mData"   : 'nCostoFolios',
                            'aTargets'  : [7]
                        },
                        {
                            "mData"   : 'sMetodoPago',
                            'aTargets'  : [8]
                        },
                        {
                            "mData"   : 'nCostoMetodo',
                            'aTargets'  : [9]
                        },
                        {
                            "mData"   : 'nComision',
                            'aTargets'  : [10]
                        },
                        {
                            "mData"   : 'nTotalCobrado',
                            'aTargets'  : [11]
                        },
                        {
                            "mData"   : 'nUtilidad',
                            'aTargets'  : [12]
                        }
                    ],
                    "fnDrawCallback" : function(aoData) {
                        
                            if(aoData.aiDisplayMaster.length>0){
                            $('#fechaIni_excel').val($("#dFechaInicio").val());
                            $('#fechaFin_excel').val($("#dFechaFin").val());
                            $('#nIdProveedor_excel').val(operaciones.nIdProveedor);
                            $('#fechaIni_pdf').val($("#dFechaInicio").val());
                            $('#fechaFin_pdf').val($("#dFechaFin").val());
                            $('#nIdProveedor_pdf').val(operaciones.nIdProveedor);
                            
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
                        $.each(params, function(index, val){
                            aoData.push({name : index, value : val });
                        });
                    },   
                });
                $("#ventaFolios").css("display", "inline-table");
                $("#ventaFolios").css("width", "100%");
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

