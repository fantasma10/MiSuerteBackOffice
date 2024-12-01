function initViewConsultaCorte(){
	var Layout = {
        initBotones:function(){
            $('#btn_ExportarCorteExcel').on('click', function(e){
                var unaopcion=false;
                id_proveedor = $('#select_proveedor').val();
                fecha1 = $('#fecIni').val();
                fecha2 = $('#fecFin').val();

                if (id_proveedor !=''){unaopcion=true;}
                if (fecha1 !='' && fecha2!=''){unaopcion=true;}
                if (fecha2 < fecha1){jAlert('La Fecha Final debe ser igual o mayor que la Fecha Inicial');return;}
                if (unaopcion==false){
                    jAlert('Seleccione al menos una opción');
                    return;
                }else{                  
                    $('#id_proveedor_excel').val(id_proveedor);   
                    $('#fecha1_excel').val(fecha1);
                    $('#fecha2_excel').val(fecha2);
                    $('#tipo').val(1);
                    $('#todoexcel').submit();
                }
            }); 
        },
        buscarEmisor:function(){
			$("#p_sRazonSocial").autocomplete({
				source: function(request,respond){
					$.post( "../ajax/consultaRazonSocial.php", { "strBuscar": request.term },
					function( response ) {
						respond(response);
					}, "json" );
				},
				minLength: 1,
				focus: function(event,ui){
					$("#p_sRazonSocial").val(ui.item.snombreproveedor);
					$("#RFC").val(ui.item.RFC);
					return false;
				},
				select: function(event,ui){
					return false;
				},
				search: function(){
				}
			})
			.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
				return $( '<li>' )
				.append( "<a style=\"color:black\">"+ item.value + "</a>" )
				.appendTo( ul );
			};
		},
	}//Layout
    Layout.initBotones();
    Layout.buscarEmisor();
} // initViewAltaProducto


 $("#btn_buscar_cortes").click(function(){
    var unaopcion=false;
    if ($('#select_proveedor').val()!=''){unaopcion=true;}
    if ($('#fecIni').val()!='' && $('#fecFin').val()!=''){unaopcion=true;}
    if ($('#fecFin').val() < $('#fecIni').val()){jAlert('La Fecha Final debe ser igual o mayor que la Fecha Inicial');return;}
    if (unaopcion==false){
        jAlert('Seleccione al menos una opción');
        return;
    }else{  
        buscarDatos();            
    }
    
 });

 function buscarDatos(){
            var dataTableObj;
            var estatus = $("#p_nIdEstatus option:selected").val();
            var fechaIni = $("#fecIni").val();
            var fechaFin = $("#fecFin").val();
            var rfc = $("#RFC").val();

            dataTableObj = $('#tabla_productos').dataTable({          
               "iDisplayLength"  : 10,  //numero de columnas a desplegar
                "bProcessing"   : true,     // mensaje 
                "bServerSide"   : true,    //procesamiento del servidor
                "bFilter"     : true,       //no permite el filtrado caja de texto
                "bDestroy": true,           // reinicializa la tabla 
                "sAjaxSource"       : "../ajax/consultaOrdenPago.php", //ajax que consulta la informacion
                "sServerMethod"     : 'POST', //Metodo para enviar la informacion
                "oLanguage"         : {
                    "sLengthMenu"       : "Mostrar _MENU_",
                    "sZeroRecords"      : "No se ha encontrado información",
                    "sInfo"             : "Mostrando _START_ a _END_ de _TOTAL_ Registros",
                    "sInfoEmpty"        : "Mostrando 0 a 0 de 0 Registros",
                    "sInfoFiltered"     : "(filtrado de _MAX_ total de Registros)",
                    "sProcessing"       : "<img src='../../../img/cargando3.gif'> Loading...",
                    "sSearch"           : "Buscar",
                    "oPaginate"         : {
                        "sPrevious"     : "Anterior", // This is the link to the previous page
                        "sNext"         : "Siguiente"
                    }
                },
                "aoColumnDefs"    : [ //Desplegado de informacion  target es la posicion en la que viene en la respuesta
                    {
                        'aTargets'  : [0,1,2,3,4,5,6,7,8,9,10],
                        "bSortable": false
                    },
                    {
                        "mData"   : 'nIdOrdenPago',
                        'aTargets'  : [0]
                    },
                    {
                        "mData"   : 'dFechaRegistro',
                        'aTargets'  : [1]
                    },
                    {
                        "mData"   : 'dFechaPago',
                        'aTargets'  : [2]
                    },
                    {
                        "mData"   : 'nIdTipoPago',
                        'aTargets'  : [3]
                    },
                    {
                        "mData"   : 'sCuentaOrigen',
                        'aTargets'  : [4]
                    },
                    {
                        "mData"   : 'sCuentaBeneficiario',
                        'aTargets'  : [5]
                    },
                    {
                        "mData"   : 'importe',
                        'aTargets'  : [6]
                    },
                    {
                        "mData"   : 'importe_transferencia',
                        'aTargets'  : [7]
                    },
                    {
                        "mData"   : 'nTotal',
                        'aTargets'  : [8]
                    },
                    {
                        "mData"   : 'sBeneficiario',
                        'aTargets'  : [9]
                    },
                    {
                        "mData"   : 'sCorreoDestino',
                        'aTargets'  : [10]
                    }

                ],
                "fnDrawCallback" : function(aoData) {
                    if(aoData._iRecordsDisplay>0){
                        mostrarBotones();
						$("#rfc_excel").val(rfc);
                        $("#estatus_excel").val(estatus);
						$("#fecha1_excel").val(fechaIni);
						$("#fecha2_excel").val(fechaFin);

                    }else{
                        ocultarBotones();
                    }
                },
                "fnPreDrawCallback" : function() {            
                },
                
                "fnServerParams" : function (aoData){//Funcion que se activa al buscar infromacion en la tabla o cambiar de pagina aoData contiene l ainfo del datatable                
                    var params = {};
                    params['tipo'] =  2;
                    params['estatus']  =  estatus;
                    params['fechaIni'] =  fechaIni;
                    params['fechaFin']   =  fechaFin;
                    params['rfc'] = rfc;
                    $.each(params, function(index, val){
                        aoData.push({name : index, value : val });
                    });
                },   
            });

            $("#tabla_productos").css("display", "inline-table");
            $("#tabla_productos").css("width", "100%");   
        
 }

function mostrarBotones(){
    $(".excel").fadeIn("normal");
} 

function ocultarBotones(){
    $(".excel").hide();
} 
