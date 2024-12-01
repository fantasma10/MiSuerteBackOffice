function initView(){
                $('#btnBuscar').click();
		var Layout = {

				buscarInformacion : function(){
                                    Layout._llenarTabla();
				},

		_llenarTabla : function(id, mes){
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
                                                
                                    var nId     =   $('#cmbProveedores').val();
                        var sFechaI =   $('#p_dFechaInicio').val();
                        var sFechaF =   $('#p_dFechaFin').val();
                        var reporte =   $('#tipoReporte').val();

                        $("#data tbody").empty();
                        var datos = $("#data").DataTable();
                        datos.fnClearTable();
                        datos.fnDestroy();

                        var tabla = $("#tblGridBox2").DataTable();

                        tabla.fnClearTable();
                        tabla.fnDestroy();
                        document.getElementById('detalleOperaciones').style.display='none';
                        document.getElementById('titulo').style.display='none';
                        
                        var mes = $('#mesBusqueda').val() + "-01";
                        var id = $('#cmbProveedores').val();
                        var regex = new RegExp(/^\d{4}-\d{2}-\d{2}$/);
                        
                        if (regex.test(mes)) {
                            
                            $.post(BASE_URL +"/ayddo/ajax/ReporteOrdenesCobro.php",
                            {
                                    idProveedor: id,
                                    mesBusqueda:mes,
                            }, 
                            function(response){
                                     var obj = jQuery.parseJSON(response);
                                    if (obj.Codigo == 0 && obj.Data.length > 0) {
                                        jQuery.each(obj.Data, function(index,value) {
                                        fechaOperaciones = obj.Data[index]['dFechaOperaciones'];
                                        nombreProveedor = obj.Data[index]['sNombre'];
                                        $('#data tbody').append('<tr>'+
                                                      '<td >'+obj.Data[index]['sRFC']+'</td>'+
                                                      '<td > '+obj.Data[index]['sRazonSocial']+'</td>'+
                                                      '<td style="text-align:center;">'+obj.Data[index]['num_operaciones']+'</td>'+
                                                      '<td >'+obj.Data[index]['monto_total']+'</td>'+
                                                      '<td > '+obj.Data[index]['iva_comision']+'</td>'+
                                                      '<td > '+obj.Data[index]['monto_facturar']+'</td>'+
                                                      '<td > <button id="verDetalle" data-fecha="'+mes+'"; data-proveedor="'+obj.Data[index]['nIdProveedor']+'";  data-placement="top" rel="tooltip" title="Ver Detalle" class="btn habilitar btn-default btn-xs" data-title="Ver Informacion"><span class="fa fa-search"></span></button>'+
                                                      '</tr>');
                                        });
                                        datos.DataTable(settings);
                                        document.getElementById("export").style.display="inline";
                                        document.getElementById("data").style.display="inline-table";
                                        document.getElementById("data").style.width="100%";

                                    }else {
                                        jAlert('No se encontraron registros');
                                    }
                            })
                            .fail(function(resp){
                                alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
                            });

                        }else{
                            jAlert('Debe seleccionar un mes');
                        }
//                        document.getElementById("export").style.display="inline";
//                        document.getElementById("data").style.display="inline-table";
//                        document.getElementById("data").style.width="100%";
                        
                        
		},
                
                _buscarProveedor:function(){
                    $("#mesBusqueda").on("change", function(){
                        var valormes = $('#mesBusqueda').val() + "-01";
                        var proveedor = $('#cmbProveedores').val();
                        Layout._llenarTabla();
                    });
                },
		buscaIntegradorProveedor:function(){
                    
			$("#cmbProveedores").on("change", function(){
                                
					$('#btnBuscar').click();
//                                       Layout.buscarInformacion();
				if (cliente =! 0) {
				}
			});
			
                            $.post(BASE_URL +"/ayddo/ajax/Proveedores.php",{
                            itipo : 1
                            },
                            function(response){		
                                    var obj = jQuery.parseJSON(response);

                                            $('#cmbProveedores').append('<option value="0">Todos</option>');
                                            jQuery.each(obj, function(index,value) {
                                            $('#cmbProveedores').append('<option value="'+obj[index]['nIdProveedor']+'">'+obj[index]['sRazonSocial']+'</option>');
                                            });		
                            })
                            .fail(function(resp){
                                                    alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
                            });
		
		},


		initBotones : function(){
                        f =new Date();
                        meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                        mesString = "0"+(f.getMonth()+1);
                        anioString = String(f.getFullYear());
                        setMes = String(anioString + "-" + mesString);
                        
                        $('#mesBusqueda').val(setMes);
                        var mesDefault = $('#mesBusqueda').val();
                        if (mesDefault != " ") {
                            Layout.buscarInformacion();
                        }
			$('#btnBuscar').on('click', function(e){
				if ($('#tipoReporte').val()==0){jAlert('Seleccione un tipo de reporte');return;}
				if ($('#p_dFechaInicio').val()==''){jAlert('Debe capturar la fecha inicial del reporte');return;}
				if ($('#p_dFechaFin').val()==''){jAlert('Debe capturar la fecha Final del reporte');return;}
				if($('#p_dFechaFin').val() < $('#p_dFechaInicio').val()){jAlert('La Fecha Final debe ser igual o mayor que la Fecha Inicial');return;}
                                
				Layout.buscarInformacion();
				$('form[name=excel] :input[name=h_mesBusqueda]').val($('#mesBusqueda').val() + "-01");
				$('form[name=pdf] :input[name=h_mesBusqueda]').val($('#mesBusqueda').val() + "-01");

				$('form[name=excel] :input[name=h_cmbProveedores]').val($('#cmbProveedores').val());
				$('form[name=pdf] :input[name=h_cmbProveedores]').val($('#cmbProveedores').val());
				
                                $('form[name=excel] :input[name=h_mesString]').val(mesString);
				$('form[name=pdf] :input[name=h_mesString]').val(mesString);

				$('form[name=excel2] :input[name=h_mesBusqueda]').val($('#mesBusqueda').val() + "-01");
				$('form[name=excel2] :input[name=h_cmbProveedores]').val($('#cmbProveedores').val());
                                
				
//                                Layout._llenarTabla();

				  });
//				$('#p_dFechaInicio, #p_dFechaFin').datepicker({format : 'yyyy-mm-dd'}).on('changeDate', function(){
//				$(this).datepicker('hide'); 
//				$(this).blur();
//			   });
                           
                           $("#mesBusqueda").on("change", function(){
                                var valormes = $('#mesBusqueda').val() + "-01";
                                var proveedor = $('#cmbProveedores').val();

                                if (valormes) {
                                    Layout.buscarInformacion();
                                }
//                                Layout._llenarTabla(proveedor,valormes);
                            });
                            
			$(document).on('click','#verDetalle',function(e){
				fecha = this.attributes['data-fecha'].value;
				proveedor = this.attributes['data-proveedor'].value;
                                
				tipo =+ $("#tipoReporte option:selected").val();
				
				getDetalleOperaciones(fecha,proveedor,mesString);
				$('form[name=excel2] :input[name=h_cmbProveedores]').val(proveedor);
			});
		}
	}

	
	Layout.initBotones();
//        Layout._llenarTabla();
	Layout.buscaIntegradorProveedor();
	

} // initViewComision


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

    $.post(BASE_URL +"/ayddo/ajax/DetalleFacturas.php",{
            idProveedor: proveedor,
            mesBusqueda:valormes,
            mesString:mesString
    },
    function(response){
      var obj = jQuery.parseJSON(response);
      
      conteo = obj.Data.length;   
	  document.getElementById('detalleOperaciones').style.display='block';
	  document.getElementById('titulo').style.display='block';

          $('form[name=excel2] :input[name=h_mesBusqueda]').val($('#mesBusqueda').val() + "-01");
          $('form[name=excel2] :input[name=h_cmbProveedores]').val(proveedor);
          $('form[name=excel2] :input[name=h_mesString]').val(mesString);
      // Validacion de que la consulta contiene registros para ser mostrados

      if(conteo > 0){

          // Llenado de la tabla con la informacion de la consulta
           jQuery.each(obj.Data, function(index,value) {
        
              $('#tblGridBox2 tbody').append('<tr><td style="width: 13%!important;">'+obj.Data[index]['dFecha']+'</td>'+
              '<td style="text-align:center;">'+obj.Data[index]['nIdFolio']+'</td>'+
              '<td style="text-align:center;">'+obj.Data[index]['nMonto']+'</td>'+
              '<td style="text-align:center;">'+obj.Data[index]['sMetodo']+'</td>'+
              '<td style="text-align:right;">'+obj.Data[index]['nComision']+'</td>'+
              '<td style="text-align:center;">'+obj.Data[index]['iva']+'</td>'+
              '<td style="text-align:center;">'+obj.Data[index]['total']+'</td>');

        
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