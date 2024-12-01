function initView(){
	var tablaReporte;
	var detalle = 0;
	var Layout = {
		buscarReportePorProveedor : function(){
			var idProveedor=$('#cmb_proveedor').val();
			var idFamilia=$('#cmb_familia').val();
			var fecha1=$('#fecha1').val();
			var fecha2=$('#fecha2').val();

			tablaReporte = $('#tabla_reporte_proveedores').dataTable({
				"iDisplayLength"	: 10, 	//numero de columnas a desplegar
		        "bProcessing"		: true, 	// mensaje 
		       	"bServerSide"		: true, 	//procesamiento del servidor
		        "bFilter"			: false, 		//quita la caja de texto Busqueda
		        "bDestroy"			: true, 			// reinicializa la tabla 
		        "sAjaxSource"   	: "../../inc/Ajax/_Reportes/Proveedores/proveedores_data_log.php", //ajax que consulta la informacion
		        "sServerMethod"   	: 'POST', //Metodo para enviar la informacion
		        "oLanguage"     	: {
		        	"sLengthMenu"   	: "Mostrar _MENU_",
		          	"sZeroRecords"    	: "No se ha encontrado nada",
		          	"sInfo"       		: "Mostrando _START_ a _END_ de _TOTAL_ Registros",
		          	"sInfoEmpty"    	: "Mostrando 0 a 0 de 0 Registros",
		          	"sInfoFiltered"   	: "(filtrado de _MAX_ total de Registros)",	          	
		          	"sProcessing"   	: "<img src='../../img/cargando3.gif'> Loading...",
		          	"sSearch" 			: "Buscar",
		          	"oPaginate"			: {
		            	"sPrevious"		: "Anterior", // This is the link to the previous page
		            	"sNext"			: "Siguiente"
		          	}
        		},
        		"aoColumnDefs"    : [ //Desplegado de informacion  target es la posicion en la que viene en la respuesta
		        	{
		        		'aTargets'  : [0,1,2],
		        		"bSortable": false
		        	},
			      	{
			        	"mData"   : 'total',
	          			'aTargets'  : [0]
			        },
			        {
			        	"mData"   : 'NOMPROVEEDOR',
	          			'aTargets'  : [1]
			        },
			        {
			        	"mData"   : 'IMPOP',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [2]
			        }
			    ],
			    "fnDrawCallback" : function(aoData) {
		      		if(aoData._iRecordsDisplay>0){
		      			mostrarBotones();
		      		}else{
		      			ocultarBotones();
		      		}
		        },
		        "fnFooterCallback": function ( tfoot, data, start, end, display) {
		        	if(data.length>0){
			        	$.post("../../inc/Ajax/_Reportes/Proveedores/proveedores_data_log.php",{tipo : 3,idProveedor:idProveedor,idFamilia:idFamilia,fecha1:fecha1,fecha2:fecha2},
							function(response){
								var obj = jQuery.parseJSON(response);
								$(tfoot).find('th').eq(0).html(obj.totalOperacion);
					            $(tfoot).find('th').eq(1).html("TOTAL");
					            $(tfoot).find('th').eq(2).html(obj.totalImporte);		            
							}
						);
		        	}else{
		        		$(tfoot).find('th').eq(0).html("");
					    $(tfoot).find('th').eq(1).html("");
					    $(tfoot).find('th').eq(2).html("");	
		        	}
		       	},
        		"fnServerParams" : function (aoData){//Funcion que se activa al buscar infromacion en la tabla o cambiar de pagina aoData contiene l ainfo del datatable		          
		         	var params = {};
		          	params['tipo'] =  3;
		          	params['idProveedor']  =  idProveedor;
		          	params['idFamilia'] =  idFamilia;
		          	params['fecha1']   =  fecha1;
		          	params['fecha2']  =  fecha2;
		          	params['tipo_res'] =  0;
		          	$.each(params, function(index, val){
		            	aoData.push({name : index, value : val });
		          	});
		        }   
        	});
        	$("#tabla_reporte_proveedores").css("display", "inline-table");
			$("#tabla_reporte_proveedores").css("width", "100%"); 
		},

		proveedores:function(){
			$("#cmb_proveedor").empty();
			$.post("../../inc/Ajax/_Reportes/Proveedores/proveedores_data_log.php",{tipo : 1},
				function(response){
					var obj = jQuery.parseJSON(response);
					if(obj !== null){
						$('#cmb_proveedor').append('<option value="-2">Todos</option>');
						jQuery.each(obj,function(index,value){
							$('#cmb_proveedor').append('<option value="'+obj[index]['idProveedor']+'">'+obj[index]['nombreProveedor']+'</option>');
						});
					}
				}
			).fail(function(resp){alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');})
		},
		
		familias:function(){
			$("#cmb_familia").empty();
			$.post("../../inc/Ajax/_Reportes/Proveedores/proveedores_data_log.php",{tipo : 2},
				function(response){
					var obj = jQuery.parseJSON(response);
					if(obj !== null){
						$('#cmb_familia').append('<option value="-2">Todos</option>');
						jQuery.each(obj,function(index,value){
							$('#cmb_familia').append('<option value="'+obj[index]['idFamilia']+'">'+obj[index]['descFamilia']+'</option>');
						});
					}
				}
			).fail(function(resp){alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');})
		},

		initBotones : function(){
			$('#btn_buscar_reporte_proveedores').on('click', function(e){
				detalle = 0;
				var unaopcion=false;
				if ($('#cmb_proveedor').val()!=''){unaopcion=true;}
				if ($('#fecha1').val()!='' && $('#fecha2').val()!=''){unaopcion=true;}
				if ($('#fecha2').val() < $('#fecha1').val()){jAlert('La Fecha Final debe ser igual o mayor que la Fecha Inicial');return;}
				if (unaopcion==false){
					jAlert('Seleccione al menos una opción');
					return;
				}else{	
					Layout.buscarReportePorProveedor();			    
				}
				 
			});
			
			$('#btn_ExportarProvExcel').on('click', function(e){
				var unaopcion=false;
				id_proveedor = $('#cmb_proveedor').val();
				id_familia = $('#cmb_familia').val();
				fecha1 = $('#fecha1').val();
				fecha2 = $('#fecha2').val();

				if (id_proveedor !=''){unaopcion=true;}
				if (fecha1 !='' && fecha2!=''){unaopcion=true;}
				if (fecha2 < fecha1){jAlert('La Fecha Final debe ser igual o mayor que la Fecha Inicial');return;}
				if (unaopcion==false){
					jAlert('Seleccione al menos una opción');
					return;
				}else{					
					$('#id_proveedor_excel').val(id_proveedor);					
					$('#id_familia_excel').val(id_familia);
					$('#fecha1_excel').val(fecha1);
					$('#fecha2_excel').val(fecha2);
					$('#tipo_excel').val(detalle);
					$('#todoexcel').submit();
				}
			});					
		}
	}
	
	Layout.initBotones();
	Layout.proveedores();
	Layout.familias();
}

function mostrarBotones(){
	$(".excel").fadeIn("normal");
} 

function ocultarBotones(){
	$(".excel").hide();
} 
