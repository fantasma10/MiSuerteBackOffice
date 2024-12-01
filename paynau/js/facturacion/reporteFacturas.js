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
        
        $('#opcionBusqueda').customLoadStore({
            url             : BASE_PATH + '/paynau/ajax/facturacion/getEmpresas.php',
            labelField      : 'strRazonSocial',
            idField         : 'nIdUnidadNegocio',
            firstItemId     : '0', 
            firstItemValue  : 'General'
        });

        $('#opcionBusqueda').on('change',function(){
            var opcionBusqueda = $('#opcionBusqueda').val();
            if(opcionBusqueda <= 0){
                $('#busquedaFiltro').hide();
                var nIdProveedor = 0;
                operaciones.nIdEmpresa = 0;
                operaciones.nIdProveedor = 0;
                $('#btnBuscarOperaciones').click();
            }else{
                operaciones.nIdProveedor = $('#opcionBusqueda').val();
                $('#btnBuscarOperaciones').click();
                operaciones.cargarLista(1);
                $('#busquedaFiltro').show();
            }
        });
        $('#selcetBusqueda').on('change',function(){
            if ($('#selcetBusqueda').val()!= 0) {
                operaciones.nIdEmpresa = $('#selcetBusqueda').val();
                operaciones.nIdProveedor = 0;
                $('#btnBuscarOperaciones').click();
            }
        })
    },
    cargarLista: function(IdBusqueda){
        if (IdBusqueda == 1) {
            nIdUnidadNegocio = $('#opcionBusqueda').val();
            $('#selcetBusqueda').customLoadStore({
                url             : BASE_PATH + '/paynau/ajax/facturacion/getEmpresas.php',
                params          : {nIdUnidadNegocio : nIdUnidadNegocio},
                labelField      : 'strRazonSocial',
                idField         : 'nIdEmpresa',
                firstItemId     : '0', 
                firstItemValue  : '--'
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
                    "sAjaxSource"       : "../../ajax/facturacion/getfacturasGeneral.php", //ajax que consulta la informacion
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
                            'aTargets'  : [0,1,2,3,4,5,6],
                            "bSortable": false
                        },
                        {
                            "mData"   : 'sRazonSocialEmisor',
                            'aTargets'  : [0]
                        },
                        {
                            "mData"   : 'sRFCEmisor',
                            'aTargets'  : [1]
                        },
                        {
                            "mData"   : 'sFolioFiscal',
                            'aTargets'  : [2]
                        },
                        {
                            "mData"   : 'dFechaEmision',
                            'aTargets'  : [3]
                        },
                        {
                            "mData"   : 'nTotalFactura',
                            'aTargets'  : [4]
                        },
                        {
                            "mData"   : 'sRazonSocialReceptor',
                            'aTargets'  : [5]
                        },
                        {
                            "mData"   : 'sRFCReceptor',
                            'aTargets'  : [6]
                        }
                    ],
                    "fnDrawCallback" : function(aoData) {
                        
                            if(aoData.aiDisplayMaster.length>0){
                            $('#fechaIni_excel').val($("#dFechaInicio").val());
                            $('#fechaFin_excel').val($("#dFechaFin").val());
                            $('#nIdEmpresa_excel').val(operaciones.nIdEmpresa);
                            $('#nIdProveedor_excel').val(operaciones.nIdProveedor);
                            
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
                        params['nIdUnidadNegocio'] = operaciones.nIdProveedor;
                        params['nIdEmpresa'] = operaciones.nIdEmpresa
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

