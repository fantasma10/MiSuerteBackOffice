function initView(){
	var tablaReporte;
	var tablaReporte_detalle;
	var detalle = 0;
	var producto = 0;
	var Layout = {
		buscarReportePorProveedor : function(){ 
			$("#reporte").show(); //oculatamos la tabla detalle
			$("#reporte_detalle").hide(); //oculatamos la tabla detalle
			$("#reporte_producto").hide(); //oculatamos la tabla detalle
			var idProveedor=$('#cmb_proveedor').val();
			var idFamilia=$('#cmb_familia').val();
			var fecha1=$('#fecha1').val();
			var fecha2=$('#fecha2').val();
			var banderaFooter=0;
			var pagoProveedor = 0.0;

			tablaReporte = $('#tabla_reporte_proveedores').dataTable({
				"iDisplayLength"	: 10, 	//numero de columnas a desplegar
		        "bProcessing"		: true, 	// mensaje 
		       	"bServerSide"		: false, 	//procesamiento del servidor
		        "bFilter"			: true, 		//quita la caja de texto Busqueda
		        "bDestroy"			: true, 			// reinicializa la tabla 
		        "sAjaxSource"   	: "../../inc/Ajax/_Reportes/Proveedores/proveedores.php", //ajax que consulta la informacion
		        "sServerMethod"   	: 'POST', //Metodo para enviar la informacion
				"aaSorting"     	: [[11, 'asc']],
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
		        		'aTargets'  : ['_all'],
		        		"bSortable": false
		        	},
			      	{
			        	"mData"   : 'total',
	          			'aTargets'  : [0]
			        },
					{
						'mData': 'RFC',
						'aTargets': [1]
					},
					{
			        	"mData"   : 'RAZON_SOCIAL',
	          			'aTargets'  : [2]
			        },
			        {
			        	"mData"   : 'IMPORTE',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [3],
			        },
			        {
			        	"mData"   : 'COMISION_CLIENTE',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [4]
			        },
			        {
			        	"mData"   : 'IMPORTE_TOTAL',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [5]
			        },
			        {
			        	"mData"   : 'COMISION_X_PAGAR',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [6]
			        },
			        {
			        	"mData"   : 'COMISION_X_COBRAR',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [7]
			        },
			        {
			        	"mData"   : 'COMISION_X_PAGAR_CLI',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [8]
			        },
			        {
			        	"mData"   : 'COMISION_X_COBRAR_CLI',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [9]
			        },
			        {
			        	"mData"   : 'MARGEN_UTILIDAD',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [10]
			        },
			        {
			        	"mData"   : 'PAGO_PROVEEDOR',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [11]
			        },
			       {
			        	"mData"   : 'idProveedor',
	          			'aTargets'  : [12],
	          			'sClass'  	: 'align-right',
	          			mRender: function(data, type, row){
	          				boton_detalle='<button id="botonDetalle" onclick="verDetalleProveedor('+row.idProveedor+');" data-placement="top" rel="tooltip" title="Ver Informacion" class="btn habilitar btn-default btn-xs" data-title="Ver Detalle"><span class="fa fa-search"></span></button>';
	          				botones = "<center>"+boton_detalle+"</center>";
	          				return botones;
	          			}
			        },
					/*{
			        	"mData"   : 'NOMBRE_PROVEEDOR',
	          			'aTargets'  : [12],
						'bVisible'	: false
			        },*/
			    ],
			    "fnRowCallback": function( nRow, aData, iDisplayIndex ) { 
			    	pagoProveedor = parseFloat(pagoProveedor) + parseFloat(aData["PAGO_PROVEEDOR2"]);	
		        },
		        "fnPreDrawCallback" : function() {          
		        },
			    "fnDrawCallback" : function(oSettings) {	
		      		if(oSettings.aiDisplay.length>0){
		      			mostrarBotones();
		      			banderaFooter=1;
		      		}else{
		      			ocultarBotones();
		      			banderaFooter=0;
		      		}
		        },
		        "fnFooterCallback": function (tfoot, data, start, end, display, nRow) {
		        	var nTotal = 0;
		            var nImporte = 0;
		            var nComUsuario = 0;
		            var nImporteTotal = 0;
		            var nCxPProv = 0;
		            var nCxCProv=0;
		            var nCxPCli = 0;
		            var nCxCCli=0;
		            var nMargen=0;
		            var nPago=0;

		            for (var i = 0; i < data.length; i++) {
		                nTotal = nTotal + parseFloat(data[i]['total']);
		                nImporte = nImporte + parseFloat(data[i]['IMPORTE2']);
		                nComUsuario = nComUsuario + parseFloat(data[i]['COMISION_CLIENTE2']);
		                nImporteTotal = nImporteTotal + parseFloat(data[i]['IMPORTE_TOTAL2']);
		                nCxPProv = nCxPProv + parseFloat(data[i]['COMISION_X_PAGAR2']);
		                nCxCProv = nCxCProv + parseFloat(data[i]['COMISION_X_COBRAR2']);
		                nCxPCli = nCxPCli + parseFloat(data[i]['COMISION_X_PAGAR_CLI2']);
		                nCxCCli = nCxCCli + parseFloat(data[i]['COMISION_X_COBRAR_CLI2']);
		                nMargen = nMargen + parseFloat(data[i]['MARGEN_UTILIDAD2']);
		                nPago = nPago + parseFloat(data[i]['PAGO_PROVEEDOR2']);
		            }  
		                 
		            if(data.length>0){                
		                $("#footDetalle").show(); 
		               
		                var options = {minimumFractionDigits:2}
		                $(tfoot).find('th').eq(0).html(nTotal.toLocaleString("en-US"));
		                $(tfoot).find('th').eq(1).html();
		                $(tfoot).find('th').eq(2).html();
		                $(tfoot).find('th').eq(3).html("$"+nImporte.toLocaleString("en-US",options));
		                $(tfoot).find('th').eq(4).html("$"+nComUsuario.toLocaleString("en-US",options));
		                $(tfoot).find('th').eq(5).html("$"+nImporteTotal.toLocaleString("en-US",options)); 
		                $(tfoot).find('th').eq(6).html("$"+nCxPProv.toLocaleString("en-US",options));   
		                $(tfoot).find('th').eq(7).html("$"+nCxCProv.toLocaleString("en-US",options));		                
		                $(tfoot).find('th').eq(8).html("$"+nCxPCli.toLocaleString("en-US",options));
		                $(tfoot).find('th').eq(9).html("$"+nCxCCli.toLocaleString("en-US",options));
		                $(tfoot).find('th').eq(10).html("$"+nMargen.toLocaleString("en-US",options));
		                $(tfoot).find('th').eq(11).html("$"+nPago.toLocaleString("en-US",options));    
		            }else{
		                $("#footDetalle").hide();
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
		buscarReportePorProducto : function(){
			$("#reporte_producto").show();//mostrar la tabla por producto
			$("#reporte").hide(); //oculatamos la tabla detalle
			$("#reporte_detalle").hide(); //oculatamos la tabla detalle
			
			var idProveedor=$('#cmb_proveedor').val();
			var idFamilia=$('#cmb_familia').val();
			var fecha1=$('#fecha1').val();
			var fecha2=$('#fecha2').val();
			var banderaFooter=0;
			var pagoProveedor = 0.0;

			tablaReporte = $('#tabla_reporte_productos').dataTable({
				"iDisplayLength"	: 10, 	//numero de columnas a desplegar
		        "bProcessing"		: true, 	// mensaje 
		       	"bServerSide"		: false, 	//procesamiento del servidor
		        "bFilter"			: true, 		//quita la caja de texto Busqueda
		        "bDestroy"			: true, 			// reinicializa la tabla 
		        "sAjaxSource"   	: "../../inc/Ajax/_Reportes/Proveedores/proveedores.php", //ajax que consulta la informacion
		        "sServerMethod"   	: 'POST', //Metodo para enviar la informacion
				"aaSorting"     	: [[1, 'asc']],
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
		        		'aTargets'  : [0,1,2,3,4,5,6,7,8,9,10,11],
		        		"bSortable": false
		        	},
			      	{
			        	"mData"   : 'total',
	          			'aTargets'  : [0]
			        },
					{
			        	"mData"   : 'NOMBRE_PRODUCTO',
	          			'aTargets'  : [1]
			        },
					{
			        	"mData"   : 'RETENCION',
	          			'aTargets'  : [2]
			        },
			        {
			        	"mData"   : 'IMPORTE',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [3]
			        },
			        {
			        	"mData"   : 'COMISION_CLIENTE',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [4]
			        },
			        {
			        	"mData"   : 'IMPORTE_TOTAL',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [5]
			        },
			        {
			        	"mData"   : 'COMISION_X_PAGAR',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [6]
			        },
			        {
			        	"mData"   : 'COMISION_X_COBRAR',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [7]
			        },
			        {
			        	"mData"   : 'COMISION_X_PAGAR_CLI',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [8]
			        },
			        {
			        	"mData"   : 'COMISION_X_COBRAR_CLI',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [9]
			        },
			        {
			        	"mData"   : 'MARGEN_UTILIDAD',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [10]
			        },
			        {
			        	"mData"   : 'PAGO_PROVEEDOR',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [11]
			        },
					{
			        	"mData"   : 'NOMBRE_PRODUCTO',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [12],
						'bVisible' : false
			        }
			    ],
				/*"aoColumns" :[
					{"sWidth": "40%"},
					{"sWidth": "120%"}
				],*/
			    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
			    	pagoProveedor = parseFloat(pagoProveedor) + parseFloat(aData["PAGO_PROVEEDOR2"]);
		        },
		        "fnPreDrawCallback" : function() {          
		        },
			    "fnDrawCallback" : function(oSettings ) {
		      		if(oSettings.aiDisplay.length>0){
		      			mostrarBotones();
		      			banderaFooter=1;
		      		}else{
		      			ocultarBotones();
		      			banderaFooter=0;
		      		}
		        },
		        "fnFooterCallback": function (tfoot, data, start, end, display, nRow) {
		        	var nTotal = 0;
		            var nImporte = 0;
		            var nComUsuario = 0;
		            var nImporteTotal = 0;
		            var nCxPProv = 0;
		            var nCxCProv=0;
		            var nCxPCli = 0;
		            var nCxCCli=0;
		            var nMargen=0;
		            var nPago=0;

		            for (var i = 0; i < data.length; i++) {
		                nTotal = nTotal + parseFloat(data[i]['total']);
		                nImporte = nImporte + parseFloat(data[i]['IMPORTE2']);
		                nComUsuario = nComUsuario + parseFloat(data[i]['COMISION_CLIENTE2']);
		                nImporteTotal = nImporteTotal + parseFloat(data[i]['IMPORTE_TOTAL2']);
		                nCxPProv = nCxPProv + parseFloat(data[i]['COMISION_X_PAGAR2']);
		                nCxCProv = nCxCProv + parseFloat(data[i]['COMISION_X_COBRAR2']);
		                nCxPCli = nCxPCli + parseFloat(data[i]['COMISION_X_PAGAR_CLI2']);
		                nCxCCli = nCxCCli + parseFloat(data[i]['COMISION_X_COBRAR_CLI2']);
		                nMargen = nMargen + parseFloat(data[i]['MARGEN_UTILIDAD2']);
		                nPago = nPago + parseFloat(data[i]['PAGO_PROVEEDOR2']);
		            }  
		                 
		            if(data.length>0){                
		                $("#footDetalle").show(); 
		               
		                var options = {minimumFractionDigits:2}
		                $(tfoot).find('th').eq(0).html(nTotal.toLocaleString("en-US"));
		                $(tfoot).find('th').eq(1).html();
		                $(tfoot).find('th').eq(2).html();
		                $(tfoot).find('th').eq(3).html("$"+nImporte.toLocaleString("en-US",options));
		                $(tfoot).find('th').eq(4).html("$"+nComUsuario.toLocaleString("en-US",options));
		                $(tfoot).find('th').eq(5).html("$"+nImporteTotal.toLocaleString("en-US",options)); 
		                $(tfoot).find('th').eq(6).html("$"+nCxPProv.toLocaleString("en-US",options));   
		                $(tfoot).find('th').eq(7).html("$"+nCxCProv.toLocaleString("en-US",options));		                
		                $(tfoot).find('th').eq(8).html("$"+nCxPCli.toLocaleString("en-US",options));
		                $(tfoot).find('th').eq(9).html("$"+nCxCCli.toLocaleString("en-US",options));
		                $(tfoot).find('th').eq(10).html("$"+nMargen.toLocaleString("en-US",options));
		                $(tfoot).find('th').eq(11).html("$"+nPago.toLocaleString("en-US",options));    
		            }else{
		                $("#footDetalle").hide();
		            }

		        },
        		"fnServerParams" : function (aoData){//Funcion que se activa al buscar infromacion en la tabla o cambiar de pagina aoData contiene l ainfo del datatable		          
		         	var params = {};
		          	params['tipo'] =  11;
		          	params['idProveedor']  =  idProveedor;
		          	params['idFamilia'] =  idFamilia;
		          	params['fecha1']   =  fecha1;
		          	params['fecha2']  =  fecha2;
		          	params['tipo_res'] =  4;
		          	$.each(params, function(index, val){
		            	aoData.push({name : index, value : val });
		          	});
		        }   
        	});
        	$("#tabla_reporte_productos").css("display", "inline-table");
			$("#tabla_reporte_productos").css("width", "100%"); 
		},
		buscarReportePorProveedorDetallado : function(){
			$("#reporte").hide(); //oculatamos la tabla detalle
			$("#reporte_producto").hide();//ocultar la tabla por producto
			$("#reporte_detalle").show(); //oculatamos la tabla detalle
			var idProveedor=$('#cmb_proveedor').val();
			var idFamilia=$('#cmb_familia').val();
			var fecha1=$('#fecha1').val();
			var fecha2=$('#fecha2').val();

			tablaReporte_detalle = $('#tabla_reporte_proveedores_detalle').dataTable({			
				"iDisplayLength"	: 10, 	//numero de columnas a desplegar
		        "bProcessing"		: true, 	// mensaje 
		       	"bServerSide"		: true, 	//procesamiento del servidor
		        "bFilter"			: false, 		//quita la caja de texto Busqueda
		        "bDestroy"			: true, 			// reinicializa la tabla 
		        "sAjaxSource"   	: "../../inc/Ajax/_Reportes/Proveedores/proveedores.php", //ajax que consulta la informacion
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
		        		'aTargets'  : [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16],
		        		"bSortable": false
		        	},
			      	{
			        	"mData"   : 'idsOperacion',
	          			'aTargets'  : [0]	          			
			        },
			        {
			        	"mData"   : 'AUTORIZACION',
	          			'aTargets'  : [1]
			        },
			         {
			        	"mData"   : 'REFERENCIA',
	          			'aTargets'  : [2]
			        },
			        {
			        	"mData"   : 'PRODUCTO',
	          			'aTargets'  : [3]
			        },
			        {
			        	"mData"   : 'IMPORTE',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [4]
			        },
			        {
			        	"mData"   : 'COMISION_CLIENTE',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [5]
			        },
			        {
			        	"mData"   : 'IMPORTE_TOTAL',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [6]
			        },
			        {
			        	"mData"   : 'COMISION_X_PAGAR',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [7]
			        },
			        {
			        	"mData"   : 'COMISION_X_COBRAR',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [8]
			        },
			        {
			        	"mData"   : 'COMISION_X_PAGAR_CLI',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [9]
			        },
			        {
			        	"mData"   : 'COMISION_X_COBRAR_CLI',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [10]
			        },
			        {
			        	"mData"   : 'MARGEN_UTILIDAD',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [11]
			        },
			        {
			        	"mData"   : 'PAGO_PROVEEDOR',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [12]
			        },
			        {
			        	"mData"   : 'FECHA',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [13]
			        },
			        {
			        	"mData"   : 'CUENTACONTABLE',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [14]
			        },	
			        {
			        	"mData"   : 'NOMCORR',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [15]
			        },
			        {
			        	"mData"   : 'NOMBRE_PROVEEDOR',
			        	'sClass'  : 'align-right',
	          			'aTargets'  : [16]
			        }


			    ],
        		"fnServerParams" : function (aoData){//Funcion que se activa al buscar infromacion en la tabla o cambiar de pagina aoData contiene l ainfo del datatable		          
		         	var params = {};
		          	params['tipo'] =  4;
		          	params['idProveedor']  =  idProveedor;
		          	params['idFamilia'] =  idFamilia;
		          	params['fecha1']   =  fecha1;
		          	params['fecha2']  =  fecha2;
		          	$.each(params, function(index, val){
		            	aoData.push({name : index, value : val });
		          	});
		        }   
        	});
        	$("#tabla_reporte_proveedores_detalle").css("display", "inline-table");
			$("#tabla_reporte_proveedores_detalle").css("width", "100%"); 	
		},

		proveedores:function(){
			$("#cmb_proveedor").empty();
			$.post("../../inc/Ajax/_Reportes/Proveedores/proveedores.php",{tipo : 1},
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
			$.post("../../inc/Ajax/_Reportes/Proveedores/proveedores.php",{tipo : 2},
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
				$("#tipo_excel").val(detalle);				
				if (unaopcion==false){
					jAlert('Seleccione al menos una opción');
					return;
				}else{
					if($('#producto').prop('checked')==true){
						detalle=3;// en detalle 3 indica que la tabla es por producto
						Layout.buscarReportePorProducto();
					}else{
						detalle=0;
						Layout.buscarReportePorProveedor();
					}								    
				}
				 
			});

			$('#btn_ver_detalle_proveedor').on('click', function(e){
				detalle=1;
				var unaopcion=false;
				if ($('#cmb_proveedor').val()!=''){unaopcion=true;}
				if ($('#fecha1').val()!='' && $('#fecha2').val()!=''){unaopcion=true;}
				if ($('#fecha2').val() < $('#fecha1').val()){jAlert('La Fecha Final debe ser igual o mayor que la Fecha Inicial');return;}
				if (unaopcion==false){jAlert('Seleccione al menos una opción');return;}
				$("#tipo_excel").val(detalle);
				Layout.buscarReportePorProveedorDetallado();
			});
			
			$('#btn_ExportarProvExcel').on('click', function(e){
				var unaopcion=false;
				id_proveedor = $('#cmb_proveedor').val();
				id_familia = $('#cmb_familia').val();
				fecha1 = $('#fecha1').val();
				fecha2 = $('#fecha2').val();
				tipo = $("#tipo_excel").val();

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
					if(tipo==2){
						$('#tipo_excel').val(tipo);
					}else{
						$('#tipo_excel').val(detalle);	
					}
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
	$(".verDetalle").fadeIn("normal");
	$(".excel").fadeIn("normal");
} 

function ocultarBotones(){
	$(".verDetalle").hide();
	$(".excel").hide();
} 

function verReporteDetalleEspecifico(){

	var idProveedor = $("#cmb_proveedor option:selected").val();
	var idFamilia=$('#cmb_familia option:selected').val();
	var fecha1=$('#fecha1').val();
	var fecha2=$('#fecha2').val();


			tablaReporte = $('#tabla_reporte_proveedores').dataTable({			
				"iDisplayLength"	: 10, 	//numero de columnas a desplegar
		        "bProcessing"		: true, 	// mensaje 
		       	"bServerSide"		: true, 	//procesamiento del servidor
		        "bFilter"			: false, 		//quita la caja de texto Busqueda
		        "bDestroy"			: true, 			// reinicializa la tabla 
		        "sAjaxSource"   	: "../../inc/Ajax/_Reportes/Proveedores/proveedores.php", //ajax que consulta la informacion
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
		        		'aTargets'  : [23,24,25,26,27,28,29,30,31,32],
		        		"bSortable": false
		        	},
		        	{	
		        		"mData"   	: 'IDSOPERACION',	        		
		        		'aTargets'  : [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22],
		        		"bVisible"	: false
		        	},
		        	{
			        	"mData"   : 'IDSOPERACION',
	          			'aTargets'  : [23]
			        },
			        {
			        	"mData"   : 'FECHA_OP',
	          			'aTargets'  : [24]
			        },
			        {
			        	"mData"   : 'HORA_OP',
	          			'aTargets'  : [25]
			        },
			        {
			        	"mData"   : 'IMPORTE_UFINAL_VALOR',
	          			'aTargets'  : [26]
			        },
			        {
			        	"mData"   : 'COMISION_ENTIDAD_VALOR',
	          			'aTargets'  : [27]
			        },
			        {
			        	"mData"		: 'IVA_COMISION',
	          			'aTargets'  : [28]
			        },
			        {
			        	"mData"   : 'ID_COMERCIO',
	          			'aTargets'  : [29]
			        },
			        {
			        	"mData"   : 'NOMBRE_COMERCIO',
	          			'aTargets'  : [30]
			        },
			        {
			        	"mData"   : 'NO_AUTORIZACION',
	          			'aTargets'  : [31]
			        },
			        {
			        	"mData"   : 'LIQUIDACION',
	          			'aTargets'  : [32]
			        }
			        
			    ],
        		"fnServerParams" : function (aoData){
		         	var params = {};
		          	params['tipo'] =  7;
		          	params['idProveedor']  =  idProveedor;
		          	params['idFamilia'] =  idFamilia;
		          	params['fecha1']   =  fecha1;
		          	params['fecha2']  =  fecha2;
		          	$.each(params, function(index, val){
		            	aoData.push({name : index, value : val });
		          	});

		          	$('#id_proveedor_excel').val(idProveedor);					
					$('#id_familia_excel').val(idFamilia);
					$('#fecha1_excel').val(fecha1);
					$('#fecha2_excel').val(fecha2);
					$('#tipo_excel').val(2);
		          	

		        }   
        	});
        	$("#tabla_reporte_proveedores").width('100%');


}

var listaFechas =[];
function verDetalleProveedor(id){
	lista = [];
	var idProveedor = id;
	var idFamilia=$('#cmb_familia option:selected').val();
	var fecha1=$('#fecha1').val();
	var fecha2=$('#fecha2').val();

 		$("#li_detalle").addClass('active');
		$("#li_semanal").removeClass('active');
		$("#div_detalle").show();
		$("#div_semanal").hide();


			tablaReporte = $('#tablaDetalle').dataTable({			
				"iDisplayLength"	: 10, 	//numero de columnas a desplegar
		        "bProcessing"		: true, 	// mensaje 
		       	"bServerSide"		: true, 	//procesamiento del servidor
		        "bFilter"			: false, 		//quita la caja de texto Busqueda
		        "bDestroy"			: true, 			// reinicializa la tabla 
		        "sAjaxSource"   	: "../../inc/Ajax/_Reportes/Proveedores/proveedores.php", //ajax que consulta la informacion
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
		        		'aTargets'  : [0,1,2,3,4,5,6,7,8,9,10,11],
		        		"bSortable": false
		        	},
		        	{
			        	"mData"   : 'IDSOPERACION',
	          			'aTargets'  : [0]
			        },
			        {
			        	"mData"   : 'REFERENCIA',
	          			'aTargets'  : [1]
			        },
			        {
			        	"mData"   : 'FECHA_OP',
	          			'aTargets'  : [2]
			        },
			        {
			        	"mData"   : 'HORA_OP',
	          			'aTargets'  : [3]
			        },
			        {
			        	"mData"   : 'IMPORTE_UFINAL_VALOR',
	          			'aTargets'  : [4]
			        },
			        {
			        	"mData"		: 'COMISION_ENTIDAD_VALOR',
	          			'aTargets'  : [5]
			        },
			        {
			        	"mData"   : 'IVA_COMISION',
	          			'aTargets'  : [6]
			        },
			        {
			        	"mData"   : 'ID_COMERCIO',
	          			'aTargets'  : [7]
			        },
			        {
			        	"mData"   : 'NOMBRE_COMERCIO',
	          			'aTargets'  : [8]
			        },
			        {
			        	"mData"   : 'NO_AUTORIZACION',
	          			'aTargets'  : [9]
			        },
			        {
			        	"mData"   : 'LIQUIDACION',
	          			'aTargets'  : [10]
			        },
			        {
                        "mData"   : 'FECHA_OP',
                        'aTargets'  : [11],
                        mRender: function(data, type, row){
                        	var fecha = row.FECHA_OP;
                        	if(fecha.length>0){
                        		listaFechas.push(fecha);
                        	}
                        	boton="";                            
                            return boton;
                        }
                    }
			    ],
        		"fnServerParams" : function (aoData){
        			var params = {};
		          	params['tipo'] =  7;
		          	params['idProveedor']  =  id;
		          	params['idFamilia'] =  idFamilia;
		          	params['fecha1']   =  fecha1;
		          	params['fecha2']  =  fecha2;
		          	$.each(params, function(index, val){
		            	aoData.push({name : index, value : val });
		          	});


        			$('#id_proveedor_exceldetalle').val(id);					
					$('#id_familia_exceldetalle').val(idFamilia);
					$('#fecha1_exceldetalle').val(fecha1);
					$('#fecha2_exceldetalle').val(fecha2);
					$('#tipo_exceldetalle').val(4);

		        }   
        	});
			
			setTimeout(function(){ 
					remove_duplicates(listaFechas);
			}, 2000);



        	
			$("#tablaDetalle").show();
        	$("#modalDetalle").modal('show');
        	$("#id_proveedor_detalle").val(id);
        	$("#tablaDetalle").css("display", "inline-table");
			$("#tablaDetalle").css("width", "100%"); 

        	$.ajax({
            data:{
              tipo : 9,
              idProveedor: id
            },
            type: 'POST',
            url: "../../inc/Ajax/_Reportes/Proveedores/proveedores.php",
			beforeSend: function(){
				$("#btn_liquidar").attr('disabled', true);
			},
            success: function(response){
            	var nTipoTiempoAire="";
                var obj = jQuery.parseJSON(response);
                jQuery.each(obj,function(index,value){
                     nTipoTiempoAire = obj[index]['nTipoTiempoAire'];
                });

                if(nTipoTiempoAire==1){
                	$("#btn_liquidar").show();
					tablaReporte.fnGetData().forEach(function(row){
						var valor = row["LIQUIDACION"];
						if(!isNaN(valor)){
							//$("#btn_liquidar").show();
							$("#btn_liquidar").attr('disabled', false);
						}else{
							//$("#btn_liquidar").hide();
							$("#btn_liquidar").attr('disabled', true);
						}
					})
                }else{
                	$("#btn_liquidar").hide();
                }
            }
        });

}

var listaFechasUnicas=[];
function remove_duplicates(arr) {
	listaFechasUnicas=[];
    var obj = {};
    var ret_arr = [];
    for (var i = 0; i < arr.length; i++) {
        obj[arr[i]] = true;
    }
    for (var key in obj) {
        ret_arr.push(key);
        listaFechasUnicas.push(key);
    }
    return ret_arr;
}

function modalLiquidar(){
	$("#modalFechaPago").modal('show');
}

function liquidar(){

	var fechas_op = tablaReporte.fnGetNodes().map(function(i) {
		return tablaReporte.fnGetData(i, 2);
	});
	var array_fechas = [];
	$.each(fechas_op, function(i, valor){
		array_fechas.push(valor)
	});
	remove_duplicates(array_fechas);

	var idProveedor = $("#id_proveedor_detalle").val();
	var fechaPago = $("#fecha3").val();

	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1;
	var yyyy = today.getFullYear();

	if(dd<10) {
    	dd='0'+dd
	} 
	if(mm<10) {
	    mm='0'+mm
	} 
	today = yyyy+'-'+mm+'-'+dd;
	var fechaHoy = new Date(today);
	var fechaParametro = new Date(fechaPago);

	if(fechaParametro>fechaHoy){
		jAlert("La fecha liquidacion no puede ser mayor al dia de hoy");
	}else{
	$.ajax({
            data:{
              tipo : 8,
              idProveedor: idProveedor,
              listaFechasUnicas : listaFechasUnicas,
              fechaPago : fechaPago
            },
            type: 'POST',
            url: "../../inc/Ajax/_Reportes/Proveedores/proveedores.php",
			beforeSend: function(){
				$("#loading-liquidacion").show();
				$("#btn-cerrar-modal-liquidar").attr('disabled', true);
				$("#btn-sp-liquidar").attr('disabled', true);
			},
            success: function(response){
				$("#loading-liquidacion").hide();
				tablaReporte.fnGetData().forEach(function(row){
					var valor = row["LIQUIDACION"];
					if(!isNaN(valor)){
						$("#btn_liquidar").attr('disabled', false);
					}else{
						$("#btn_liquidar").attr('diabled', true);
					}
				})
				$("#btn-cerrar-modal-liquidar").attr('disabled', false);
				$("#btn-sp-liquidar").attr('disabled', false);
            	if(response>0){
            		jAlert("Actualizacion correcta");
            		$("#modalFechaPago").modal('hide');
            		$("#modalDetalle").modal('hide');

            		setTimeout(function(){ 
						verDetalleProveedor(idProveedor);
					}, 2000);
            		
            	}
            }
        });
	}
}

var banderaTabConsultaSemanal=0;
function SetTab(id){

	if(id=="li_detalle"){
		$("#li_detalle").addClass('active');
		$("#li_semanal").removeClass('active');
		$("#div_detalle").show();
		$("#div_semanal").hide();
	}

	if(id=="li_semanal"){
		$("#li_semanal").addClass('active');
		$("#li_detalle").removeClass('active');
		$("#div_semanal").show();
		$("#div_detalle").hide();
		buscarQuerySemanal();
	}
}

function buscarQuerySemanal(){

	var idProveedor = $("#id_proveedor_detalle").val();
	var idFamilia=$('#cmb_familia option:selected').val();
	var fecha1=$('#fecha1').val();
	var fecha2=$('#fecha2').val();
	$("#tablaDetalleSemanal").show();
	$("#tablaDetalleSemanal").css("display", "inline-table");
	$("#tablaDetalleSemanal").css("width", "100%"); 

	tablaReporte = $('#tablaDetalleSemanal').dataTable({			
				"iDisplayLength"	: 10, 	//numero de columnas a desplegar
		        "bProcessing"		: true, 	// mensaje 
		       	"bServerSide"		: true, 	//procesamiento del servidor
		        "bFilter"			: false, 		//quita la caja de texto Busqueda
		        "bDestroy"			: true, 			// reinicializa la tabla 
		        "sAjaxSource"   	: "../../inc/Ajax/_Reportes/Proveedores/proveedores.php", //ajax que consulta la informacion
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
		        		'aTargets'  : [0,1,2,3,4,5],
		        		"bSortable": false
		        	},
		        	{
			        	"mData"   : 'FECHA',
	          			'aTargets'  : [0]
			        },
			        {
			        	"mData"   : 'TOTAL',
	          			'aTargets'  : [1]
			        },
			        {
			        	"mData"   : 'IMPORTE_COBRANZA',
	          			'aTargets'  : [2]
			        },
			        {
			        	"mData"   : 'COMISION',
	          			'aTargets'  : [3]
			        },
			        {
			        	"mData"   : 'IMPORTE_LIQUIDACION',
	          			'aTargets'  : [4]
			        },
			        {
			        	"mData"   : 'DIA_SIGUIENTE',
	          			'aTargets'  : [5]
			        }
			    ],
        		"fnServerParams" : function (aoData){
        			var params = {};
		          	params['tipo'] =  10;
		          	params['idProveedor']  =  idProveedor;
		          	params['idFamilia'] =  idFamilia;
		          	params['fecha1']   =  fecha1;
		          	params['fecha2']  =  fecha2;
		          	$.each(params, function(index, val){
		            	aoData.push({name : index, value : val });
		          	});

        			$('#id_proveedor_exceldetallesemanal').val(idProveedor);					
					$('#id_familia_exceldetallesemanal').val(idFamilia);
					$('#fecha1_exceldetallesemanal').val(fecha1);
					$('#fecha2_exceldetallesemanal').val(fecha2);
					$('#tipo_exceldetallesemanal').val(5);

		        }   
        	});

}