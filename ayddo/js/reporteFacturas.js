function initView(){
		var Layout = {

				buscarInformacion : function(){
					Layout._llenarTabla();
				},

		_llenarTabla : function(){
			$('#gridbox').html('<table  id="tblGridBox" class="display table table-bordered table-striped"><thead><tr><th>Razon Social</th><th>RFC</th><th>Estatus</th><th>Operaciones</th><th>Monto Factura</th><th>Acciones</th></tr></thead><tbody></tbody></table>');

			showSpinner();
			var dataTableObj = $('#tblGridBox').dataTable({
				"iDisplayLength"	: 10,
				"bProcessing"		: true,
				"bServerSide"		: true,
				"sAjaxSource"		: BASE_PATH + '/ayddo/ajax/ReporteFacturas.php',
				"sServerMethod"		: 'POST',
				"bFilter"			: false,
				"bAutoWidth"		: false,
				"oLanguage": {
					"sLengthMenu"		: "Mostrar _MENU_ Registros por P&aacute;gina",
					"sZeroRecords"		: "No se ha encontrado nada",
					"sInfo"				: "Mostrando _START_ a _END_ de _TOTAL_ Registros",
					"sInfoEmpty"		: "Mostrando 0 a 0 de 0 Registros",
					"sInfoFiltered"		: "(filtrado de _MAX_ total de Registros)",
					"sProcessing"		: "Cargando"
        			},
       
				"aoColumnDefs"		: [
					{
						'bSortable'	: false,
						'aTargets'	: [0,1,2,3,4]
					},
					{
						"mData"		: 'sNombre',
						'aTargets'	: [0]
					},
					{
						"mData"		: 'sNombreComercial',
						'aTargets'	: [1]
					},
					{
						"mData"		: null,
						'aTargets'	: [2],
						"fnRender": function ( data, type, row ) {
          					estatus =+ data.aData.nIdEstatus;
          					if(estatus == 1){
								estatus = 'Pendiente';
          					}else{
          						estatus = 'Liberada';
          					}
            				return estatus;        				
    					}
					},
					{
						"mData"		: 'nOperaciones',
						'aTargets'	: [3]
					},
//					{
//						"mData"		:'nMontoOperaciones',
//						'aTargets'	: [4]
//					},
					{
						"mData"		: 'nMontoFactura',
						'aTargets'	: [4],
                                                "fnRender": function ( data, type, row ) {
                                                        monto =+ data.aData.nMontoFactura;
                                                        var montoFactura = accounting.formatMoney(accounting.toFixed(monto,2),'$');
                                                    return montoFactura;        				
                                                }
                                        },
                                        { 
						"mData"     : null,
                                                'aTargets'      : [5],

                                                "fnRender": function ( data, type, row ) {
                                                        estatus =+ data.aData.nIdEstatus;
                                                        if(estatus == 1){
                                                                        boton = '<button id="liberar" data-placement="top" rel="tooltip" title="Liberar" data-toggle="modal" data-target="#confirmacion" class="btn habilitar btn-primary btn-xs" data-id='+data.aData.nIdCorte+' data-nombre="'+data.aData.sNombreComercial+'" data-title="Liberar Pago"><span class="fa fa-check"></span></button>&nbsp;&nbsp;\n\
                                                                                 <button id="verDetalle" data-IdProveedor="'+data.aData.nId+'";  data-placement="top" rel="tooltip" title="Ver Detalle" class="btn habilitar btn-default btn-xs" data-title="Ver Informacion"><span class="fa fa-search"></span></button>';
                                                        }else{
                                                                boton = '';
                                                        }
                                                    return boton;        				
                                                }
                                        }
                                ],
        
				"fnPreDrawCallback"	: function() {
					showSpinner();
        		},
        
				"fnDrawCallback": function ( oSettings ) {
                                        document.getElementById("export").style.display="inline";
					hideSpinner();
                                        document.getElementById('detalleOperaciones').style.display='none';
                                        document.getElementById('titulo').style.display='none';
					
				},
				"fnServerParams" : function (aoData){
					var params = $('form[name=formFiltros]').getSimpleParams();
					
					$.each(params, function(index, val){
						aoData.push({name : index, value : val });
					});
        		}
        
			});
		},

		buscaIntegradorProveedor:function(){	


					$("#cmbClientes").empty();
					$.post(BASE_PATH + "/ayddo/ajax/Proveedores.php",{
					itipo : 1
					},
					function(response){		
						var obj = jQuery.parseJSON(response);
								
							$('#cmbClientes').append('<option value="0">Todos</option>');
							jQuery.each(obj, function(index,value) {
							$('#cmbClientes').append('<option value="'+obj[index]['nIdProveedor']+'">'+obj[index]['sRazonSocial']+'</option>');
							});		
					})
					.fail(function(resp){
								alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
					})
		},

		selectMes:function(){	


					$("#cmbMes").empty();
					$.post(BASE_PATH + "/ayddo/ajax/selectMes.php",{
					},
					function(response){		
							$('#cmbMes').append('<option value="0">Todos</option>');
						var obj = jQuery.parseJSON(response);
								
							jQuery.each(obj, function(index,value) {
							$('#cmbMes').append('<option value="'+obj[index]['nMes']+'">'+obj[index]['dMes']+'</option>');
							});		
					})
					.fail(function(resp){
								alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
					})
		},

		selectYear:function(){	


					$("#cmbYear").empty();
					$.post(BASE_PATH + "/ayddo/ajax/selectYear.php",{
					},
					function(response){		
							$('#cmbYear').append('<option value="0">Todos</option>');
							var obj = jQuery.parseJSON(response);
								
							jQuery.each(obj, function(index,value) {
							$('#cmbYear').append('<option value="'+obj[index]['dYear']+'">'+obj[index]['dYear']+'</option>');
							});		
					})
					.fail(function(resp){
								alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
					})
		},				


		initBotones : function(){
			$('#btnBuscar').on('click', function(e){
//				if ($('#cmbMes option:selected').val()=='0'){jAlert('Debe el mes para la busqueda');return;}
//				if ($('#cmbYear option:selected').val()=='0'){jAlert('Debe capturar el año para la busqueda');return;}
				if ($('#cmbMes option:selected').val() != '0' && $('#cmbYear option:selected').val()=='0'){jAlert('Debe capturar el año para la busqueda');return;}

				Layout.buscarInformacion();
				$('form[name=excel] :input[name=h_nIdProveedor]').val($('#cmbClientes').val());
				$('form[name=pdf] :input[name=h_nIdProveedor]').val($('#cmbClientes').val());

				$('form[name=excel] :input[name=h_nIdEstatus]').val($('#cmbEstatus').val());
				$('form[name=pdf] :input[name=h_nIdEstatus]').val($('#cmbEstatus').val());

				$('form[name=excel] :input[name=h_Mes]').val($('#cmbMes').val());
				$('form[name=pdf] :input[name=h_Mes]').val($('#cmbMes').val());

				$('form[name=excel] :input[name=h_Year]').val($('#cmbYear').val());
				$('form[name=pdf] :input[name=h_Year]').val($('#cmbYear').val());
                                
                                //Export Global
                                mes = $('#cmbMes').val();
                                anio = $('#cmbYear').val();
                                fecha = String(anio + "-" + "0"+ mes + "-01");
                                $('form[name=excel3] :input[name=h_mesBusqueda]').val(fecha);
                                $('form[name=excel3] :input[name=h_cmbProveedores]').val($('form[name=excel2] :input[name=h_cmbProveedores]').val());
                                $('form[name=excel3] :input[name=h_mesString]').val($('select[name="cmbMes"] option:selected').text());

			});

			$(document).on('click','#verDetalle',function(e){
                            mes = $('#cmbMes').val();
                            anio = $('#cmbYear').val();
                            fecha = String(anio + "-" + "0"+ mes + "-01");
				proveedor = this.attributes['data-IdProveedor'].value;
//				tipo =+ $("#tipoReporte option:selected").val();
				
				getDetalleOperaciones(fecha,proveedor,fecha);
			});
		}
	}

	Layout.buscarInformacion();
	Layout.initBotones();
	Layout.buscaIntegradorProveedor();
	Layout.selectMes();
	Layout.selectYear();
	

} // initViewComision


$(document).on('click', '#liberar',function (e) {
		var id = $(this).data("id");
		var nombre = $(this).data("nombre");
		$("#corteId").val(id);
		$('#confirmacion p').empty();
		var texto = "Desea liberar la factura de  :" +nombre;
		$('#confirmacion p').append(texto);
});


$(document).on('click', '#liberaPago',function (e) {
		var $this = $(this);
		
		id = $("#corteId").val();
		actualizaEstatus(id);
});


function actualizaEstatus(id){
	$.post(BASE_PATH + '/ayddo/ajax/LiberaFactura.php',{
			corte : id
		},
		function(response){
			
			var obj = jQuery.parseJSON(response);
			
			if(obj[0].nCodigo != 0){
				alert(obj[0].sMensaje);
				
			}else{
				alert(obj[0].sMensaje);
				$("#btnBuscar").click();
				$("#confirmacion").modal('hide');
			}
		})

		.fail(function(response){
		
				alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
		})
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
                
function getDetalleOperaciones(valormes,proveedor,mesString){
	var tabla = $("#tblGridBox2").DataTable();
				
    tabla.fnClearTable();
    tabla.fnDestroy();
    $.post("../ajax/DetalleFacturas.php",{
            idProveedor: proveedor,
            mesBusqueda:valormes,
            mesString:mesString
    },
    function(response){
      var obj = jQuery.parseJSON(response);
        conteo = obj.Data.length;   
        obj = obj.Data;
	  document.getElementById('detalleOperaciones').style.display='block';
	  document.getElementById('titulo').style.display='block';

          $('form[name=excel2] :input[name=h_mesBusqueda]').val(mesString);
          $('form[name=excel2] :input[name=h_cmbProveedores]').val(proveedor);
          $('form[name=excel2] :input[name=h_mesString]').val($('select[name="cmbMes"] option:selected').text());
      // Validacion de que la consulta contiene registros para ser mostrados

      if(conteo > 0){

          // Llenado de la tabla con la informacion de la consulta
           jQuery.each(obj, function(index,value) {
               var monto = accounting.formatMoney(accounting.toFixed(obj[index]['nMonto'],2),'$');
               var comision = accounting.formatMoney(accounting.toFixed(obj[index]['comision_total'],2),'$');
               var iva = accounting.formatMoney(accounting.toFixed(obj[index]['iva'],2),'$');
               var total = accounting.formatMoney(accounting.toFixed(obj[index]['comision_sin_iva'],2),'$');
              $('#tblGridBox2 tbody').append('<tr><td style="width: 13%!important;">'+obj[index]['dFecha']+'</td>'+
              '<td style="text-align:center;">'+obj[index]['nombre']+'</td>'+
              '<td style="text-align:center;">'+obj[index]['rfc']+'</td>'+
              '<td style="text-align:center;">'+obj[index]['nIdFolio']+'</td>'+
              '<td style="text-align:center;">'+monto+'</td>'+
              '<td style="text-align:center;">'+obj[index]['sMetodo']+'</td>'+
              '<td style="text-align:center;">'+total+'</td>'+
              '<td style="text-align:center;">'+iva+'</td>'+
              '<td style="text-align:right;">'+comision+'</td>');

        
            })   
           table = $("#tblGridBox2").DataTable(settings);
      }else{
        table = $("#tblGridBox2").DataTable(settings);
        document.getElementById('detalleOperaciones').style.display='none';
	  	document.getElementById('titulo').style.display='none';
        jAlert("No se encontro informacion");

      } 
  })
  .fail(function(resp){
          alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
  })
}