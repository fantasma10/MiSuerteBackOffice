function initViewConsulta(){
	var dataTableObj;
	var Layout = {
		buscarProveedores : function(){
			var dataTableObj = $('#tabla_proveedores').dataTable({
		    	"iDisplayLength"  : 10, 	//numero de columnas a desplegar
		        "bProcessing"   : true, 	// mensaje 
		       	"bServerSide"   : false, 	//procesamiento del servidor
		        "bFilter"     : true, 		//no permite el filtrado caja de texto
		        "bDestroy": true, 			// reinicializa la tabla 
		        "sAjaxSource"   : "/_Proveedores/proveedor/ajax/consulta.php", //ajax que consulta la informacion		        
		        "sServerMethod"   : 'POST', //Metodo para enviar la informacion
		        //"aaSorting"     : [[0, 'desc']], //Como se sorteara la informacion numero de columna y tipo
		        "oLanguage"     : {
		          "sLengthMenu"   : "Mostrar _MENU_",
		          "sZeroRecords"    : "No se ha encontrado información",
		          "sInfo"       : "Mostrando _START_ a _END_ de _TOTAL_ Registros",
		          "sInfoEmpty"    : "Mostrando 0 a 0 de 0 Registros",
		          "sInfoFiltered"   : "(filtrado de _MAX_ total de Registros)",
		          "sProcessing"   : "Cargando",
		          "sSearch" : "Buscar",
		          "oPaginate": {
		            "sPrevious": "Anterior", // This is the link to the previous page
		            "sNext": "Siguiente"
		          }
        		},        		
		        "aoColumnDefs"    : [ //Desplegado de informacion  target es la posicion en la que viene en la respuesta
		        	{
		        		'aTargets'  : [0,1,2,3,4],
		        		"bSortable": false,
		        	},
		        	{
			        	"mData"   : 'idProveedor',
	          			'aTargets'  : [0]
			        },
			        {
			        	"mData"   : 'RFC',
	          			'aTargets'  : [1]
			        },
			        {
			        	"mData"   : 'razonSocial',
	          			'aTargets'  : [2]
			        },
			        {
			        	"mData"   : 'tipo',
	          			'aTargets'  : [3]
			        },
			        {
			        	"mData"   : 'idProveedor',
	          			'aTargets'  : [4],
	          			'sClass'  	: 'center',
	          			mRender: function(data, type, row){
	          				boton_edit ="";
	          				boton_productos="";
	          				if(ID_PERFIL == 1){
	          					boton_edit='<button id="confirmacionDesactivarProveedor" onclick="editarProveedor('+row.idProveedor+",'"+row.razonSocial+"'"+');" data-placement="top" rel="tooltip" title="Ver Informacion" class="btn habilitar btn-default btn-xs" data-title="Ver Informacion"><span class="fa fa-search"></span></button>';
	          					boton_productos='<button id="btnProductos" onclick="verProductos('+row.idProveedor+",'"+row.razonSocial+"'"+');" data-placement="top" rel="tooltip" title="Ver Productos" class="btn habilitar btn-default btn-xs" data-title="Ver Productos"><span class="fa fa-eye"></span></button>';
	          				}
	          				if(ID_PERFIL==9){
	          					boton_productos='<button id="btnProductos" onclick="verProductos('+row.idProveedor+",'"+row.razonSocial+"'"+');" data-placement="top" rel="tooltip" title="Ver Productos" class="btn habilitar btn-default btn-xs" data-title="Ver Productos"><span class="fa fa-eye"></span></button>';
	          				}
	          				botones = "<center>"+boton_edit+boton_productos+"</center>";
	          				return botones;
	          			}

			        },

		        ],
		        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
				},
		        "fnPreDrawCallback" : function() {		      
		        },
		        "fnDrawCallback" : function(aoData) {		      		
		        },
		        "fnServerParams" : function (aoData){//Funcion que se activa al buscar infromacion en la tabla o cambiar de pagina aoData contiene l ainfo del datatable		          
		         	var params = {};
		          	params['tipo'] =  1;
		          	$.each(params, function(index, val){
		            	aoData.push({name : index, value : val });
		          	});
		        }
      		});
			$("#tabla_reportes").css("display", "inline-table");
			$("#tabla_reportes").css("width", "100%"); 	
		}
	}
	
	Layout.buscarProveedores();
	//Layout.initBotones();
} // initViewConsulta






function editarProveedor(idProveedor,nombreProveedor){
	var formProveedor = '<form action="editarComisiones.php"  method="post" id="formProveedor"><input type="text" name="txtidProveedor" id="txtidProveedor"  value="'+idProveedor+'"/><input type="text" name="txtNombreProveedor" id="txtNombreProveedor"  value="'+nombreProveedor+'"/></form>'  
    $('body').append(formProveedor);
    $( "#formProveedor" ).submit();
}

function verProductos(idProveedor,razonSocial){
	$("#productos").modal();
	$.post("/_Proveedores/proveedor/ajax/consulta.php",{
		idProveedor : idProveedor,
		tipo: 3
	},
	function(response){
		var obj = jQuery.parseJSON(response);
		var html="";
		jQuery.each(obj, function(index, value) {  
            html += "<tr>";
            html += "<td>"+obj[index]['nIdProducto']+"</td>";
            html += "<td>"+obj[index]['descProducto']+"</td>";
            html += "<td>"+obj[index]['skuProducto']+"</td>";
            html += "<td>"+obj[index]['importe']+"</td>";
            html += "<td>"+obj[index]['descuento']+"</td>";
            html += "<td>"+obj[index]['importeSinDescuento']+"</td>";
            html += "<td>"+obj[index]['importeSinIva']+"</td>";
            html += "</tr>";
        });
        tabla = "<table class='table table-bordered table-striped'><th>ID</th><th>Producto</th><th>SKU</th><th>Import</th><th>Descuento</th><th>Importe sin desc.</th><th>Importe sin Iva</th>"+html+"</tabla>";
        $("#nombreProveedor").html(razonSocial);
		$("#contenidoProductos").html(tabla);
		
	}).fail(function(response){
		$("#desactivarProveedor").button('reset');
		alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
	})
	
}