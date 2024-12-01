function initEdicionComisiones(){
	var Layout = { 
		buscarProductos : function (){
			var idProveedor = $("#idProveedor").val();
			$.ajax({
                            data:{
                              tipo : 1,
                              idProveedor : idProveedor
                            },
                            type: 'POST',
                            cache: false,
                            async : false,
                            url: '../ajax/edicionComisiones.php',
                            success: function(response){
                            	var obj = jQuery.parseJSON(response);
                                var checkPorcentaje=0;

                           	for (var index = obj.length - 1; index >= 0; index--) {
                                /*emular*/
                                contadorListaProductos++;
                                var idFamiliaCompuesto = "familia_"+contadorListaProductos;
                                var idFamiliaCompuestoTexto = "familiaTexto_"+contadorListaProductos;
                                var idSubFamiliaCompuesto = "subfamilia_"+contadorListaProductos;
                                var idSubFamiliaCompuestoTexto = "subfamiliaTexto_"+contadorListaProductos;
                                var idProductoCompuesto = "producto_"+contadorListaProductos;
                                var idProductoCompuestoTexto = "productoTexto_"+contadorListaProductos;
                                var fila="<tr class='tr_class' id='filaProducto_"+contadorListaProductos+"'>"+
                                "<td style='display:none;'><input type='hidden' class='form-control' id='"+idFamiliaCompuesto+"'></td>"+
                                "<td><input type='text' class='form-control' id='"+idFamiliaCompuestoTexto+"' disabled></td>"+
                                "<td style='display:none;'><input type='hidden' class='form-control' id='"+idSubFamiliaCompuesto+"'></td>"+
                                "<td><input type='text' class='form-control' id='"+idSubFamiliaCompuestoTexto+"' disabled></td>"+
                                "<td style='display:none;'><input type='hidden' class='form-control' id='"+idProductoCompuesto+"'></td>"+
                                "<td><input type='text' class='form-control' id='"+idProductoCompuestoTexto+"' disabled></td>"+
                                "<td><input type='text' id='importe_"+contadorListaProductos+"' class='form-control m-bot15 numericos' onkeyup='calcularDesIvaImporte(this.id);'></td>"+
                                "<td><input type='text' id='descuento_"+contadorListaProductos+"' class='form-control m-bot15 numericos' onkeyup='calcularDesIvaDescuento(this.id,event);'></td>"+
                                "<td><input type='text' id='importesindescuento_"+contadorListaProductos+"' class='form-control m-bot15 numericos' disabled></td>"+
                                "<td><input type='text' id='importesiniva_"+contadorListaProductos+"' class='form-control m-bot15 numericos' disabled></td>"+
                                "<td><button style='background-color:red;border-color:red;' id='row_"+contadorListaProductos+"' class='add_button btn btn-sm btn-default' onclick='eliminarFilaListaProductos(this.id);'><i class='fa fa-minus-circle' aria-hidden='true'></i></button>"+
                                "&nbsp;&nbsp;<button style='background-color:green;border-color:green;' id='row_"+contadorListaProductos+"' class='add_button btn btn-sm btn-default' onclick='editarFilaListaProductos(this.id);'><i class='fa fa-pencil' aria-hidden='true'></i></button></td>"+
                                "</tr>";
                                $("#tabla_listaProductos").append(fila);
                                $("#familia_"+contadorListaProductos).val(obj[index]['idfamilia']);
                                $("#familiaTexto_"+contadorListaProductos).val(obj[index]['descFamilia']);
                                $("#subfamilia_"+contadorListaProductos).val(obj[index]['idsubfamilia']);
                                $("#subfamiliaTexto_"+contadorListaProductos).val(obj[index]['descSubFamilia']);
                                $("#producto_"+contadorListaProductos).val(obj[index]['nIdProducto']);
                                $("#productoTexto_"+contadorListaProductos).val(obj[index]['descProducto']);
                                $("#importe_"+contadorListaProductos+" ").val(obj[index]['importe']);
                                $("#descuento_"+contadorListaProductos+" ").val(obj[index]['descuento']);
                                $("#importesindescuento_"+contadorListaProductos+" ").val(obj[index]['importeSinDescuento']);
                                $("#importesiniva_"+contadorListaProductos+" ").val(obj[index]['importeSinIva']);

                                checkPorcentaje = obj[index]['nPorcentaje'];
                                    /*emular*/
                           	}

                            if(checkPorcentaje==1){
                                $("#check_porcentaje").attr('checked',true);
                            }else{
                                $("#check_porcentaje").attr('checked',false);
                            }
                           	

                           	$(".numericos").numeric({
				                allowPlus           : false,
				                allowMinus          : false,
				                allowThouSep        : false,
				                allowDecSep         : true,
				                allowLeadingSpaces  : false,
				                maxDigits           : 10
				            });

                            }
                        });

		},
		buscaFamilia: function() {
            $("#select_familia").empty();
            $("#familia_modal").empty();
            $.post("../ajax/altaProveedores.php", { tipo: 1 },
                function(response) {
                    var obj = jQuery.parseJSON(response);
                    $('#select_familia').append('<option value="0">Seleccione</option>');
                    $('#familia_modal').append('<option value="0">Seleccione</option>');
                    if (obj !== null) {
                        jQuery.each(obj, function(index, value) {
                            var nombre_familia = obj[index]['descFamilia'];
                            $('#select_familia').append('<option value="' + obj[index]['idFamilia'] + '">' + nombre_familia + '</option>');
                            $('#familia_modal').append('<option value="' + obj[index]['idFamilia'] + '">' + nombre_familia + '</option>');
                        });
                    }
                }
            ).fail(function(resp) { alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde'); })
        },
        inicializarCamposImporte : function(){
        	$("#importe_0, #descuento_0, #importesindescuento_0, #importesiniva_0").numeric({
                allowPlus           : false,
                allowMinus          : false,
                allowThouSep        : false,
                allowDecSep         : true,
                allowLeadingSpaces  : false,
                maxDigits           : 10
            });
        },
        deshabilitardivs : function(){
        	$("#datos_generales").addClass('disabledbutton');
        	$("#div_guardar").addClass('disabledbutton');
        },
        detectaCambio : function(){
            $('#fecha1').datepicker()
                .on('changeDate', function(e) {
                    var contador=0;
                $.each(e, function (key, value) {
                    contador++;
                    if(contador==2){
                        var hora =value+"";
                        var partes = hora.split(" ");
                        var anio;
                        var mes;
                        var dia;
                        if(partes[1]=="Jan"){
                            mes ="01";
                        }
                        if(partes[1]=="Feb"){
                            mes ="02";
                        }
                        if(partes[1]=="Mar"){
                            mes ="03";
                        }
                        if(partes[1]=="Apr"){
                            mes ="04";
                        }
                        if(partes[1]=="May"){
                            mes ="05";
                        }
                        if(partes[1]=="Jun"){
                            mes ="06";
                        }
                        if(partes[1]=="Jul"){
                            mes ="07";
                        }
                        if(partes[1]=="Aug"){
                            mes ="08";
                        }
                        if(partes[1]=="Sep"){
                            mes ="09";
                        }
                        if(partes[1]=="Oct"){
                            mes ="10";
                        }
                        if(partes[1]=="Nov"){
                            mes ="11";
                        }
                        if(partes[1]=="Dec"){
                            mes ="12";
                        }
                         anio = parseInt(partes[3])+parseInt(20);
                         var finale = anio+"-"+mes+"-"+partes[2];
                         $("#fecha2").val(finale);
                    }
                    });
                });

        },
        cargarExcel : function(){
			$(':input[type=file]').unbind('change');
			$(':input[type=file]').on('change', function(e){
				var correctos=0;
				var errores=0;
				var mensaje="";
				var input       = e.target;
    			var nIdTipoDoc  = input.getAttribute('idtipodoc');
    			var file = $(input).prop('files')[0];
    			var formdata = new FormData();
		        formdata.append('sFile',file);
		        formdata.append('tipo',4);
		        if(file.type != 'application/vnd.ms-excel'){
			      jAlert('El archivo debe ser formato csv');
			      return;
			    }else{
			        $.ajax({  
		                url: "../ajax/edicionComisiones.php",
		                type: "POST",
		                data:  formdata,
		                contentType: false,
		                processData:false
				    }).done(function(response){
				      	var obj = jQuery.parseJSON(response);
		                    if(obj.length>0){
			                    jQuery.each(obj, function(index, value) {
			                    	contadorListaProductos++;
			                    	var idFamiliaCompuesto = "familia_"+contadorListaProductos;
						            var idFamiliaCompuestoTexto = "familiaTexto_"+contadorListaProductos;

						            var idSubFamiliaCompuesto = "subfamilia_"+contadorListaProductos;
						            var idSubFamiliaCompuestoTexto = "subfamiliaTexto_"+contadorListaProductos;

						            var idProductoCompuesto = "producto_"+contadorListaProductos;
						            var idProductoCompuestoTexto = "productoTexto_"+contadorListaProductos;

			                    	var fila="<tr class='tr_class' id='filaProducto_"+contadorListaProductos+"'>"+
						            "<td style='display:none;'><input type='hidden' class='form-control' id='"+idFamiliaCompuesto+"'></td>"+
						            "<td><input type='text' class='form-control' id='"+idFamiliaCompuestoTexto+"' disabled></td>"+
						            "<td style='display:none;'><input type='hidden' class='form-control' id='"+idSubFamiliaCompuesto+"'></td>"+
						            "<td><input type='text' class='form-control' id='"+idSubFamiliaCompuestoTexto+"' disabled></td>"+
						            "<td style='display:none;'><input type='hidden' class='form-control' id='"+idProductoCompuesto+"'></td>"+
						            "<td><input type='text' class='form-control' id='"+idProductoCompuestoTexto+"' disabled></td>"+
						            "<td><input type='text' id='importe_"+contadorListaProductos+"' class='form-control m-bot15 numericos' onkeyup='calcularDesIvaImporte(this.id);'></td>"+
						            "<td><input type='text' id='descuento_"+contadorListaProductos+"' class='form-control m-bot15 numericos' onkeyup='calcularDesIvaDescuento(this.id,event);'></td>"+
						            "<td><input type='text' id='importesindescuento_"+contadorListaProductos+"' class='form-control m-bot15 numericos' disabled></td>"+
						            "<td><input type='text' id='importesiniva_"+contadorListaProductos+"' class='form-control m-bot15 numericos' disabled></td>"+
						            "<td><button style='background-color:red;border-color:red;' id='row_"+contadorListaProductos+"' class='add_button btn btn-sm btn-default' onclick='eliminarFilaListaProductos(this.id);'><i class='fa fa-minus-circle' aria-hidden='true'></i></button>"+
						            "&nbsp;&nbsp;<button style='background-color:green;border-color:green;' id='row_"+contadorListaProductos+"' class='add_button btn btn-sm btn-default' onclick='editarFilaListaProductos(this.id);'><i class='fa fa-pencil' aria-hidden='true'></i></button></td>"+
						            "</tr>";
						            $("#tabla_listaProductos").append(fila);
						            $("#familia_"+contadorListaProductos).val(obj[index]['idFamilia']);
						            $("#familiaTexto_"+contadorListaProductos).val(obj[index]['descFamilia']);

						            $("#subfamilia_"+contadorListaProductos).val(obj[index]['idSubFamilia']);
						            $("#subfamiliaTexto_"+contadorListaProductos).val(obj[index]['descSubFamilia']);
						            $("#producto_"+contadorListaProductos).val(obj[index]['idProducto']);
						            $("#productoTexto_"+contadorListaProductos).val(obj[index]['descProducto']);
						            $("#importe_"+contadorListaProductos+" ").val(obj[index]['importe']);
						            $("#descuento_"+contadorListaProductos+" ").val(obj[index]['descuento']);
						            $("#importesindescuento_"+contadorListaProductos+" ").val(obj[index]['importeSinDescuento']);
						            $("#importesiniva_"+contadorListaProductos+" ").val(obj[index]['imprteSinIVA']);

						            correctos = obj[index]['correctos'];
									errores = obj[index]['errores'];
			                	});
		                	}
		                	mensaje += "Registros correctos "+ correctos+"\n"+"Registros fallidos "+errores+"\n" ;
		                	jAlert(mensaje);
				    }).fail(function(resp){
				    	jAlert('Error al Intentar Subir el Archivo');
				    });
				}				
			});	
		},
	}

    $.fn.alphanum.setNumericSeparators({
        thousandsSeparator: "",
        decimalSeparator: "."
    });

    $(".numericPer").numeric({
        maxDigits           : 5,
        maxDecimalPlaces    : 4,
        allowDecSep         : true
    });

    $(".numeric").numeric({
        maxDigits           : 18,
        maxDecimalPlaces    : 4,
        allowOtherCharSets	: false,
        allowDecSep         : true
    });

	Layout.inicializarCamposImporte();
    checkEdicion();
    //Layout.detectaCambio();
}

function checkEdicion(){
    var edicion = $("#edicion_ruta").val();
    buscarConectores();
    if(edicion==1){
        var ruta = $("#id_ruta_edicion").val();
        var idProveedor = $("#idProveedor").val();
        $("#divEditar").show();
        $("#editarE").show();
        $("#guardarE").hide();
        buscarDatosRuta(ruta,idProveedor);
        $("#datos_generales").addClass('disabledbutton');
        $("#div_guardar").addClass('disabledbutton');
    }else{
        $("#divEditar").hide();
        $("#guardarE").show();
        $("#editarE").hide();
        BuscarProductosSelect();
    }
}

function habilitarDivs(){
	$("#datos_generales").removeClass('disabledbutton');
	$("#div_guardar").removeClass('disabledbutton');
}

function buscarDatosRuta(ruta,idProveedor){
    $.ajax({
            data:{
              tipo : 5,
              ruta: ruta,
              idProveedor : idProveedor
            },
            type: 'POST',
            async: false,
            url: '../ajax/edicionComisiones.php',
            success: function(response){   
                var obj = jQuery.parseJSON(response);
                jQuery.each(obj,function(index,value){
                    $('#select_productos').append($('<option>', {
                        value: obj[index]['idProducto'],
                        text: obj[index]['descProducto'],
                        selected: true
                    }));
                    //$("#select_productos").val(obj[index]['idProducto']);
                    $("#select_productos").prop( "disabled", true );
                    $("#select_conector").val(obj[index]['idConector']);
                    $("#skuProveedor").val(obj[index]['skuProveedor']);
                    $("#descripcionRuta").val(obj[index]['descRuta']);
                    $("#fecha1").val(obj[index]['idFevRuta']);
                    $("#fecha2").val(obj[index]['idFsvRuta']);

                    $("#importe_minimo_ruta").val(parseFloat(obj[index]['impMinRuta']).toFixed(4));
                    $("#importe_maximo_ruta").val(parseFloat(obj[index]['impMaxRuta']).toFixed(4));
                    $("#porcentaje_costo_ruta").val(parseFloat(obj[index]['perCostoRuta']*100).toFixed(4));
                    $("#importe_costo_ruta").val(parseFloat(obj[index]['impCostoRuta']).toFixed(4));
                    $("#porcentaje_comision_producto").val(parseFloat(obj[index]['perComisionProducto']*100).toFixed(4));
                    $("#importe_comision_producto").val(parseFloat(obj[index]['impComisionProducto']).toFixed(4));
                    $("#porcentaje_comision_corresponsal").val(parseFloat(obj[index]['perComCorresponsal']*100).toFixed(4));
                    $("#importe_comision_corresponsal").val(parseFloat(obj[index]['impComCorresponsal']).toFixed(4));
                    $("#porcentaje_comision_cliente").val(parseFloat(obj[index]['perComCliente']*100).toFixed(4));
                    $("#importe_comision_cliente").val(parseFloat(obj[index]['impComCliente']).toFixed(4));
                    $("#porcentaje_pago_producto").val(parseFloat(obj[index]['nPerPagoProveedor']*100).toFixed(4));
                    $("#importe_pago_producto").val(parseFloat(obj[index]['nImpPagoProveedor']).toFixed(4));
                    $("#porcentaje_margen_red").val(parseFloat(obj[index]['nPerMargen']*100).toFixed(4));
                    $("#importe_margen_red").val(parseFloat(obj[index]['nImpMargen']).toFixed(4));
                });
            }
        });
}

function isZerosValues (percentage, amount) {
    return (percentage == 0 && amount == 0);
}

function editarRuta(){
    if ($('#fecha2').val() < $('#fecha1').val()){ 
        jAlert('La Fecha Salida debe ser mayor que la Fecha Entrada');
        return;
    }else{
        var select_productos = $("#select_productos option:selected").val();
        var select_conector = $("#select_conector option:selected").val();
        var idProveedor = $("#idProveedor").val();
        var nombreProveedor = $("#nombreProveedor").val();
        var skuProveedor = $("#skuProveedor").val();
        var descripcionRuta = $("#descripcionRuta").val();
        var fecha_entrada_vigor = $("#fecha1").val();
        var fecha_salida_vigor = $("#fecha2").val();
        var importe_minimo_ruta = $("#importe_minimo_ruta").val();
        var importe_maximo_ruta = $("#importe_maximo_ruta").val();
        var porcentaje_costo_ruta = $("#porcentaje_costo_ruta").val();
        var importe_costo_ruta = $("#importe_costo_ruta").val();
        var porcentaje_comision_producto = $("#porcentaje_comision_producto").val();
        var importe_comision_producto = $("#importe_comision_producto").val();
        var porcentaje_comision_corresponsal = $("#porcentaje_comision_corresponsal").val();
        var importe_comision_corresponsal = $("#importe_comision_corresponsal").val();
        var porcentaje_comision_cliente = $("#porcentaje_comision_cliente").val();
        var importe_comision_cliente = $("#importe_comision_cliente").val();
        var importe_cxp = $("#imp_cxp").val();
        var porcentaje_pago_producto = $("#porcentaje_pago_producto").val();
        var importe_pago_producto = $("#importe_pago_producto").val();
        var importe_cxc = $("#imp_cxc").val();
        var porcentaje_margen_red = $('#porcentaje_margen_red').val();
        var importe_margen_red = $('#importe_margen_red').val();
        var ruta = $("#id_ruta_edicion").val();

        var lack="";
        var banderaDatosPrincipales=0;
        if(select_productos>0 && select_conector>0 && skuProveedor.length>0 && descripcionRuta.length>0 && importe_minimo_ruta.length>0 && importe_maximo_ruta.length>0){
            banderaDatosPrincipales=1;
        }else{
            banderaDatosPrincipales=0;
            lack +='Datos Principales\n';
        }

        var banderaCostoRuta=0;
        if(porcentaje_costo_ruta.length>0 || importe_costo_ruta.length>0){
            banderaCostoRuta=1;
        }else{
            banderaCostoRuta=0;
            lack +='Porcentaje o Importe de Costo Ruta\n';
        }

        var banderaComisionCorresponsal=0;
        if(porcentaje_comision_corresponsal.length>0 || importe_comision_corresponsal.length>0){
            banderaComisionCorresponsal=1;
        }else{
            banderaComisionCorresponsal=0;
            lack +='Porcentaje o Importe de Comision Corresponsal\n';
        }

        var banderaComisionCliente=0;
        if(porcentaje_comision_cliente.length>0 || importe_comision_cliente.length>0){
            banderaComisionCliente=1;
        }else{
            banderaComisionCliente=0;
            lack +='Porcentaje o Importe de Comision Cliente\n';
        }

        var banderaComisionCliente=0;
        if(porcentaje_comision_cliente.length>0 || importe_comision_cliente.length>0){
            banderaComisionCliente=1;
        }else{
            banderaComisionCliente=0;
            lack +='Porcentaje o Importe de Comision Cliente\n';
        }

        var banderaComisionProducto=0;
        if(porcentaje_comision_producto.length>0 || importe_comision_producto.length>0){
            banderaComisionProducto=1;
        }else{
            banderaComisionProducto=0;
            lack +='Porcentaje o Importe de Comision Cobro Proveedor\n';
        }

        var banderaPagoProducto=0;
        if(porcentaje_pago_producto.length>0 || importe_pago_producto.length>0){
            banderaPagoProducto=1;
        }else{
            banderaPagoProducto=0;
            lack +='Porcentaje o Importe de Comisión Pago Proveedor\n';
        }

        var banderaMargenRED = 0;
        if (porcentaje_margen_red.length > 0 || importe_margen_red.length > 0) {
            if (! isZerosValues(porcentaje_margen_red, importe_margen_red)) {
                banderaMargenRED = 1;
            } else {
                banderaMargenRED = 0;
                lack +='El porcentaje o importe de comisión mínima margen RED debe ser mayor a 0.\n';
            } 
        } else {
            banderaMargenRED = 0;
            lack +='Porcentaje o importe de comisión mínima margen RED\n';
        }

        if(lack.length>0){
            var black = (lack != "") ? "Los siguientes datos son Obligatorios : " : "";
            jAlert(black + '\n' + lack+'\n' );
        }else{
            $.ajax({
                data:{
                    tipo : 6,
                    select_productos : select_productos,
                    select_conector : select_conector,
                    idProveedor : idProveedor,
                    nombreProveedor : nombreProveedor,
                    skuProveedor : skuProveedor,
                    descripcionRuta : descripcionRuta,
                    fecha_entrada_vigor : fecha_entrada_vigor,
                    fecha_salida_vigor : fecha_salida_vigor,
                    importe_minimo_ruta : importe_minimo_ruta,
                    importe_maximo_ruta : importe_maximo_ruta,
                    porcentaje_costo_ruta : porcentaje_costo_ruta,
                    importe_costo_ruta : importe_costo_ruta,
                    porcentaje_comision_producto : porcentaje_comision_producto,
                    importe_comision_producto : importe_comision_producto,
                    porcentaje_comision_corresponsal : porcentaje_comision_corresponsal,
                    importe_comision_corresponsal : importe_comision_corresponsal,
                    porcentaje_comision_cliente : porcentaje_comision_cliente,
                    importe_comision_cliente : importe_comision_cliente,
                    porcentaje_pago_producto:porcentaje_pago_producto,
                    importe_pago_producto:importe_pago_producto,
                    importe_cxp:importe_cxp,
                    importe_cxc:importe_cxc,
                    ruta : ruta,
                    porcentaje_margen_red: porcentaje_margen_red,
                    importe_margen_red: importe_margen_red
                },
                type: 'POST',
                cache: false,
                async: false,
                url: '../ajax/edicionComisiones.php',
                success: function(response){
                    var obj = jQuery.parseJSON(response);
                    var mensaje="";
                    var codigo="";
                    jQuery.each(obj,function(index,value){
                        mensaje =  obj['msg'];
                        codigo = obj['showMessage'];
                    });

                    if(codigo==0){
                        jAlert(mensaje);
                        setTimeout(function(){
                            $('body').append('<form id="aconsulta" method="post" action="consulta.php"></form>');
                            $("#aconsulta").submit();
                        }, 3000);
                    }else{
                        jAlert(mensaje);
                    }

                }
            });
        }
    }
    /**/
}

function BuscarSubFamilias(value){ //buscador de subfamilias
    $('#select_subfamilia').empty();
    $('#subfamilia_modal').empty();
    var idFamilia = value;
    $.ajax({
            data:{
              tipo : 2,
              idFamilia: idFamilia
            },
            type: 'POST',
            // cache: false,
            async: false,
            url: '../ajax/altaProveedores.php',
            success: function(response){                
                var obj = jQuery.parseJSON(response);
                $('#select_subfamilia').append('<option value="-1">Seleccione</option>');
                jQuery.each(obj,function(index,value){
                    var nombre_subfamilia = obj[index]['descSubFamilia'];
                    $('#select_subfamilia').append('<option value="'+obj[index]['idSubFamilia']+'">'+nombre_subfamilia+'</option>');
                    $('#subfamilia_modal').append('<option value="'+obj[index]['idSubFamilia']+'">'+nombre_subfamilia+'</option>');
                });
            }
        });
}

function BuscarSubFamiliasDinamico(value){
	var idCompuesto ="subfamilia_edicion";
    $('#'+idCompuesto).empty();
    var idFamilia = value;
    $.ajax({
            data:{
              tipo : 2,
              idFamilia: idFamilia
            },
            type: 'POST',
            async: false,
            url: '../ajax/altaProveedores.php',
            success: function(response){        
                var obj = jQuery.parseJSON(response);
                $('#'+idCompuesto).append('<option value="-1">Seleccione</option>');
                jQuery.each(obj,function(index,value){
                    var nombre_subfamilia = obj[index]['descSubFamilia'];
                    $('#'+idCompuesto).append('<option value="'+obj[index]['idSubFamilia']+'">'+nombre_subfamilia+'</option>');
                });
            }
        });
}

function BuscarProductosDinamico(value){ //busqueda de productos
    var idCompuesto = "producto_edicion";
    // var partir = id.split("_");
    $('#'+idCompuesto).empty();
    var idFamilia = $("#familia_edicion option:selected").val();
    $.ajax({
            data:{
              tipo : 3,
              idFamilia : idFamilia,
              idSubFamilia : value
            },
            type: 'POST',
            async : false,
            url: '../ajax/altaProveedores.php',
            success: function(response){
                var obj = jQuery.parseJSON(response);
                jQuery.each(obj,function(index,value){
                    var nombre_producto = obj[index]['descProducto'];
                    $('#'+idCompuesto).append('<option value="'+obj[index]['idProducto']+'">'+nombre_producto+'</option>');
                });
            }
        });
}

function BuscarProductosSelect(value){
    $.ajax({
            data:{
              tipo : 16
            },
            type: 'POST',
            async : false,
            url: '../ajax/altaProveedores.php',
            success: function(response){
                var obj = jQuery.parseJSON(response);
                jQuery.each(obj,function(index,value){
                    var nombre_producto = obj[index]['descProducto'];
                    $('#select_productos').append('<option value="'+obj[index]['idProducto']+'">'+nombre_producto+'</option>');
                });
            }
        });
}

function buscarConectores(){
    $.ajax({
            data:{
              tipo : 17
            },
            type: 'POST',
            async : false,
            url: '../ajax/altaProveedores.php',
            success: function(response){
                var obj = jQuery.parseJSON(response);
                jQuery.each(obj,function(index,value){
                    var nombre_conector = obj[index]['descConector'];
                    $('#select_conector').append('<option value="'+obj[index]['idConector']+'">'+nombre_conector+'</option>');
                });
            }
        });
}

function removerLineasProductos(corr) {
    for (var i = 0; i < lineasListaProductos.length; i++) {
        while (lineasListaProductos[i] == corr)
            lineasListaProductos.splice(i, 1);
    }

     if(lineasListaProductos.length == 0){// si es 0 cero resetea el input file
        $("#txtFileExcel").val('');
    }
}
var lineasListaProductos = [];
function agregarlineasProductos(renglon) {
        linea =renglon;
        lineasListaProductos.push(linea);
}
var contadorListaProductos=0;
function agregarListaProductos(id){
	    var familia = $("#select_familia option:selected").val();
	    var subfamilia = $("#select_subfamilia option:selected").val();
	    var producto = $("#select_productos option:selected").val();

	    var familia_texto = $("#select_familia option:selected").text();
	    var subfamilia_texto = $("#select_subfamilia option:selected").text();
	    var producto_texto = $("#select_productos option:selected").text();

	    var importe = $("#importe_0").val();
	    var descuento = $("#descuento_0").val();
	    var importesindescuento = $("#importesindescuento_0").val();
	    var importesiniva = $("#importesiniva_0").val();
	    if(familia>0 && subfamilia>0 && producto>0 && importe.length>0 && descuento.length>0 && importesindescuento.length>0 && importesiniva.length>0){
	            contadorListaProductos++;
	            var idFamiliaCompuesto = "familia_"+contadorListaProductos;
	            var idFamiliaCompuestoTexto = "familiaTexto_"+contadorListaProductos;

	            var idSubFamiliaCompuesto = "subfamilia_"+contadorListaProductos;
	            var idSubFamiliaCompuestoTexto = "subfamiliaTexto_"+contadorListaProductos;

	            var idProductoCompuesto = "producto_"+contadorListaProductos;
	            var idProductoCompuestoTexto = "productoTexto_"+contadorListaProductos;

	            var fila="<tr class='tr_class' id='filaProducto_"+contadorListaProductos+"'>"+
	            "<td style='display:none;'><input type='hidden' class='form-control' id='"+idFamiliaCompuesto+"'></td>"+
	            "<td><input type='text' class='form-control' id='"+idFamiliaCompuestoTexto+"' disabled></td>"+
	            "<td style='display:none;'><input type='hidden' class='form-control' id='"+idSubFamiliaCompuesto+"'></td>"+
	            "<td><input type='text' class='form-control' id='"+idSubFamiliaCompuestoTexto+"' disabled></td>"+
	            "<td style='display:none;'><input type='hidden' class='form-control' id='"+idProductoCompuesto+"'></td>"+
	            "<td><input type='text' class='form-control' id='"+idProductoCompuestoTexto+"' disabled></td>"+
	            "<td><input type='text' id='importe_"+contadorListaProductos+"' class='form-control m-bot15 numericos'></td>"+
	            "<td><input type='text' id='descuento_"+contadorListaProductos+"' class='form-control m-bot15 numericos'></td>"+
	            "<td><input type='text' id='importesindescuento_"+contadorListaProductos+"' class='form-control m-bot15 numericos'></td>"+
	            "<td><input type='text' id='importesiniva_"+contadorListaProductos+"' class='form-control m-bot15 numericos'></td>"+
	            "<td><button style='background-color:red;border-color:red;' id='row_"+contadorListaProductos+"' class='add_button btn btn-sm btn-default' onclick='eliminarFilaListaProductos(this.id);'><i class='fa fa-minus-circle' aria-hidden='true'></i></button>"+
	            "&nbsp;&nbsp;<button style='background-color:green;border-color:green;' id='rowEditar_"+contadorListaProductos+"' class='add_button btn btn-sm btn-default' onclick='editarFilaListaProductos(this.id);'><i class='fa fa-pencil' aria-hidden='true'></i></button></td>"+
	            "</tr>";
	            $("#tabla_listaProductos").append(fila);
	            $("#familia_"+contadorListaProductos).val(familia);
	            $("#familiaTexto_"+contadorListaProductos).val(familia_texto);
	            $("#subfamilia_"+contadorListaProductos).val(subfamilia);
	            $("#subfamiliaTexto_"+contadorListaProductos).val(subfamilia_texto);
	            $("#producto_"+contadorListaProductos).val(producto);
	            $("#productoTexto_"+contadorListaProductos).val(producto_texto);
	            $("#importe_"+contadorListaProductos+" ").val(importe);
	            $("#descuento_"+contadorListaProductos+" ").val(descuento);
	            $("#importesindescuento_"+contadorListaProductos+" ").val(importesindescuento);
	            $("#importesiniva_"+contadorListaProductos+" ").val(importesiniva);
	            //clean inputs
	            $("#select_familia").val('0');
	            $("#select_subfamilia").empty();
	            $("#select_subfamilia").append('<option value="-1">Seleccione</option>');
	            $("#select_productos").empty();
	            $("#select_productos").append('<option value="-1">Seleccione</option>');
	            $("#importe_0").val("");
	            $("#descuento_0").val("");
	            $("#importesindescuento_0").val("");
	            $("#importesiniva_0").val("");

	            $(".numericos").numeric({
				                allowPlus           : false,
				                allowMinus          : false,
				                allowThouSep        : false,
				                allowDecSep         : true,
				                allowLeadingSpaces  : false,
				                maxDigits           : 10
				            });
	        
	    }else{
	        jAlert("Favor de ingresar todos los datos");
	    }	
}

function eliminarFilaListaProductos(id){//elimina una fila de la matriz de escalamiento
    var partir = id.split("_");
    var numero_fila = partir[1];
    var fila = "filaProducto_"+numero_fila;
    var row =document.getElementById(fila);
    row.parentNode.removeChild(row);
}

function guardarRelacion(){
    if ($('#fecha2').val() < $('#fecha1').val()){ 
        jAlert('La Fecha Salida debe ser mayor que la Fecha Entrada');
        return;
    }else{
        var select_productos = $("#select_productos option:selected").val();
        var select_conector = $("#select_conector option:selected").val();
        var idProveedor = $("#idProveedor").val();
        var nombreProveedor = $("#nombreProveedor").val();

        var skuProveedor = $("#skuProveedor").val();
        var descripcionRuta = $("#descripcionRuta").val();
        var fecha_entrada_vigor = $("#fecha1").val();
        var fecha_salida_vigor = $("#fecha2").val();
        var importe_minimo_ruta = $("#importe_minimo_ruta").val();
        var importe_maximo_ruta = $("#importe_maximo_ruta").val();
        var porcentaje_costo_ruta = $("#porcentaje_costo_ruta").val();
        var importe_costo_ruta = $("#importe_costo_ruta").val();
        var porcentaje_comision_producto = $("#porcentaje_comision_producto").val();
        var importe_comision_producto = $("#importe_comision_producto").val();
        var porcentaje_comision_corresponsal = $("#porcentaje_comision_corresponsal").val();
        var importe_comision_corresponsal = $("#importe_comision_corresponsal").val();
        var porcentaje_comision_cliente = $("#porcentaje_comision_cliente").val();
        var importe_comision_cliente = $("#importe_comision_cliente").val();
        var importe_cxp = $("#imp_cxp").val();
        var porcentaje_pago_producto = $("#porcentaje_pago_producto").val();
        var importe_pago_producto = $("#importe_pago_producto").val();
        var importe_cxc = $("#imp_cxc").val();
        var porcentaje_margen_red = $('#porcentaje_margen_red').val();
        var importe_margen_red = $('#importe_margen_red').val();
        
        var lack="";
        var banderaDatosPrincipales=0;
        if(select_productos>0 && select_conector>0 && skuProveedor.length>0 && descripcionRuta.length>0 && importe_minimo_ruta.length>0 && importe_maximo_ruta.length>0){
            banderaDatosPrincipales=1;
        }else{
            banderaDatosPrincipales=0;
            lack +='Datos principales\n';
        }

        var banderaCostoRuta=0;
        if(porcentaje_costo_ruta.length>0 || importe_costo_ruta.length>0){
            banderaCostoRuta=1;
        }else{
            banderaCostoRuta=0;
            lack +='Porcentaje o importe de Costo Ruta\n';
        }

        var banderaComisionProducto=0;
        if(porcentaje_comision_producto.length>0 || importe_comision_producto.length>0){
            banderaComisionProducto=1;
        }else{
            banderaComisionProducto=0;
            lack +='Porcentaje o importe de comisión producto\n';
        }

        var banderaComisionCorresponsal=0;
        if(porcentaje_comision_corresponsal.length>0 || importe_comision_corresponsal.length>0){
            banderaComisionCorresponsal=1;
        }else{
            banderaComisionCorresponsal=0;
            lack +='Porcentaje o importe de comisión corresponsal\n';
        }

        var banderaComisionCliente=0;
        if(porcentaje_comision_cliente.length>0 || importe_comision_cliente.length>0){
            banderaComisionCliente=1;
        }else{
            banderaComisionCliente=0;
            lack +='Porcentaje o importe de comisión cliente\n';
        }

        var banderaPagoProducto=0;
        if(porcentaje_pago_producto.length>0 || importe_pago_producto.length>0){
            banderaPagoProducto=1;
        }else{
            banderaPagoProducto=0;
            lack +='Porcentaje o importe de comisión pago proveedor\n';
        }

        var banderaMargenRED = 0;
        if (porcentaje_margen_red.length > 0 || importe_margen_red.length > 0) {
            if (! isZerosValues(porcentaje_margen_red, importe_margen_red)) {
                banderaMargenRED = 1;
            } else {
                banderaMargenRED = 0;
                lack +='El porcentaje o importe de comisión mínima margen RED debe ser mayor a 0.\n';
            }
        } else {
            banderaMargenRED = 0;
            lack +='Porcentaje o importe de comisión mínima margen RED\n';
        }

        /*
        var banderaComisionCXP=0;
        if(importe_cxp.length>0){
            banderaComisionCXP=1;
        }else{
            banderaComisionCXP=0;
            lack +='Importe de Comision CXP\n';
        }

        var banderaComisionCXC=0;
        if(importe_cxc.length>0){
            banderaComisionCXC=1;
        }else{
            banderaComisionCXC=0;
            lack +='Importe de Comision CXC\n';
        }
        */

        if(lack.length>0){
            var black = (lack != "") ? "Los siguientes datos son Obligatorios : " : "";
            jAlert(black + '\n' + lack+'\n' , 'Aviso');
        }else{
            $.ajax({
                data:{
                    tipo : 3,
                    select_productos : select_productos,
                    select_conector : select_conector,
                    idProveedor : idProveedor,
                    nombreProveedor : nombreProveedor,
                    skuProveedor : skuProveedor,
                    descripcionRuta : descripcionRuta,
                    fecha_entrada_vigor : fecha_entrada_vigor,
                    fecha_salida_vigor : fecha_salida_vigor,
                    importe_minimo_ruta : importe_minimo_ruta,
                    importe_maximo_ruta : importe_maximo_ruta,
                    porcentaje_costo_ruta : porcentaje_costo_ruta,
                    importe_costo_ruta : importe_costo_ruta,
                    porcentaje_comision_producto : porcentaje_comision_producto,
                    importe_comision_producto : importe_comision_producto,
                    porcentaje_comision_corresponsal : porcentaje_comision_corresponsal,
                    importe_comision_corresponsal : importe_comision_corresponsal,
                    porcentaje_comision_cliente : porcentaje_comision_cliente,
                    importe_comision_cliente : importe_comision_cliente,
                    porcentaje_pago_producto:porcentaje_pago_producto,
                    importe_pago_producto:importe_pago_producto,
                    importe_cxc : importe_cxc,
                    importe_cxp: importe_cxp,
                    porcentaje_margen_red: porcentaje_margen_red,
                    importe_margen_red: importe_margen_red
                },
                type: 'POST',
                cache: false,
                async: false,
                url: '../ajax/edicionComisiones.php',
                success: function(response){
                    var obj = jQuery.parseJSON(response);
                    var mensaje="";
                    var codigo="";
                    jQuery.each(obj,function(index,value){
                        mensaje =  obj['msg'];
                        codigo = obj['showMessage'];
                    });

                    if(codigo==0){
                        jAlert(mensaje);
                        setTimeout(function(){
                            $('body').append('<form id="aconsulta" method="post" action="consulta.php"></form>');
                            $("#aconsulta").submit();
                        }, 3000);


                    }else{
                        jAlert(mensaje);
                    }

                }
            });

        }
    }


}

function agregarFamiliaSelectEdicion(input,opcion){
	 		$.ajax({
            data:{
              tipo : 1
            },
            type: 'POST',
            cache: false,
            async: false,
            url: '../ajax/altaProveedores.php',
            success: function(response){            
                var obj = jQuery.parseJSON(response);
                $('#'+input).append('<option value="-1">Seleccione</option>');
                jQuery.each(obj,function(index,value){
                    var nombre_familia = obj[index]['descFamilia'];
                    $('#'+input).append('<option value="' + obj[index]['idFamilia'] + '">' + nombre_familia + '</option>');
                });
                $("#"+input).val(opcion);
                // var idSubFamiliaCompuesto = "subfamilia_"+contadorListaProductos;
                // var subfamilia = $("#select_subfamilia option:selected").val();
                // var familia = $("#select_familia option:selected").val();
	 			// agregarSubFamiliaSelectEdicion(idSubFamiliaCompuesto,subfamilia,familia);
            }
        });

}

function agregarSubFamiliaSelectEdicion(input,opcion,familia){
    $('#'+input).empty();
    $.ajax({
            data:{
              tipo : 2,
              idFamilia: familia
            },
            type: 'POST',
            cache: false,
            async: false,
            url: '../ajax/altaProveedores.php',
            success: function(response){           
                var obj = jQuery.parseJSON(response);
                $('#'+input).append('<option value="-1">Seleccione</option>');
                jQuery.each(obj,function(index,value){
                    var nombre_subfamilia = obj[index]['descSubFamilia'];
                    $('#'+input).append('<option value="'+obj[index]['idSubFamilia']+'">'+nombre_subfamilia+'</option>');
                });
                $("#"+input).val(opcion);

                // agregarProductoSelectEdicion()
				// var idProductoCompuesto = "producto_"+contadorListaProductos;
				// var familia = $("#select_familia option:selected").val();
				// var subfamilia = $("#select_subfamilia option:selected").val();
				// var producto = $("#select_productos option:selected").val();
                // agregarProductoSelectEdicion(idProductoCompuesto,producto,familia,subfamilia);
            }
        });
}

function agregarProductoSelectEdicion(input,opcion,familia,subfamilia){
    $('#'+input).empty();
    $.ajax({
            data:{
              tipo : 3,
              idFamilia : familia,
              idSubFamilia : subfamilia
            },
            type: 'POST',
            async : false,
            cache: false,
            url: '../ajax/altaProveedores.php',
            success: function(response){
                var obj = jQuery.parseJSON(response);
                jQuery.each(obj,function(index,value){
                    var nombre_producto = obj[index]['descProducto'];
                    $('#'+input).append('<option value="'+obj[index]['idProducto']+'">'+nombre_producto+'</option>');
                });
                $("#"+input).val(opcion);
            }
        });
}

function Regresar(){
        $('body').append('<form id="aconsulta" method="post" action="consulta.php"></form>');
        $("#aconsulta").submit();
}

function editarFilaListaProductos(id){
	$("#modalEdicion").modal('show');
	var splitear = id.split("_");
	$("#idRow").val(id);

	var familia = $("#familia_"+splitear[1]).val();
	var subfamilia = $("#subfamilia_"+splitear[1]).val();
	var producto = $("#producto_"+splitear[1]).val();
	var importe = $("#importe_"+splitear[1]).val();
	var descuento = $("#descuento_"+splitear[1]).val();
	var importesindescuento = $("#importesindescuento_"+splitear[1]).val();
	var importesiniva = $("#importesiniva_"+splitear[1]).val();

	var inputFam = "familia_edicion";
	var inputsubFam="subfamilia_edicion";
	var inputProd="producto_edicion";
	agregarFamiliaSelectEdicion(inputFam,familia);
	agregarSubFamiliaSelectEdicion(inputsubFam,subfamilia,familia);
	agregarProductoSelectEdicion(inputProd,producto,familia,subfamilia);
	$("#importe_edicion").val(importe);
	$("#descuento_edicion").val(descuento);
	$("#importesindescuento_edicion").val(importesindescuento);
	$("#importesiniva_edicion").val(importesiniva);

	$("#importe_edicion, #descuento_edicion, #importesindescuento_edicion, #importesiniva_edicion").numeric({
                allowPlus           : false,
                allowMinus          : false,
                allowThouSep        : false,
                allowDecSep         : true,
                allowLeadingSpaces  : false,
                maxDigits           : 10
            });

}

function editarProducto(){
	var fila = $("#idRow").val();


	var familia = $("#familia_edicion option:selected").val();
	var familiaTexto = $("#familia_edicion option:selected").text();
	var subfamilia = $("#subfamilia_edicion option:selected").val();
	var subfamiliaTexto = $("#subfamilia_edicion option:selected").text();
	var producto = $("#producto_edicion option:selected").val();
	var productoTexto = $("#producto_edicion option:selected").text();
	var importe =   $("#importe_edicion").val();
	var descuento = $("#descuento_edicion").val();
	var importeSD = $("#importesindescuento_edicion").val();
	var importeSI = $("#importesiniva_edicion").val();

	if(familia>0 && subfamilia>0 && producto>0 && importe.length>0 && descuento.length>0 && importeSD.length>0 && importeSI.length>0){
		var split = fila.split("_");
		$("#familia_"+split[1]).val(familia);
		$("#familiaTexto_"+split[1]).val(familiaTexto);
		$("#subfamilia_"+split[1]).val(subfamilia);
		$("#subfamiliaTexto_"+split[1]).val(subfamiliaTexto);
		$("#producto_"+split[1]).val(producto);
		$("#productoTexto_"+split[1]).val(productoTexto);
		$("#importe_"+split[1]).val(importe);
		$("#descuento_"+split[1]).val(descuento);
		$("#importesindescuento_"+split[1]).val(importeSD);
		$("#importesiniva_"+split[1]).val(importeSI);

		$("#modalEdicion").modal('hide');
	}else{
		jAlert("Favor de llenar todos los datos");
	}

}

function calcularDesIvaImporte(id){
    var partir = id.split("_");
    var importe = $("#importe_"+partir[1]).val();
    var descuento = $("#descuento_"+partir[1]).val();
    var importeSinDescuento = parseFloat(importe-descuento);
    var convertidoISD = importeSinDescuento.toFixed(4);
    $("#importesindescuento_"+partir[1]).val(convertidoISD);

    var importeSinIVA =parseFloat(importeSinDescuento/1.16);
    var convertidoISI = importeSinIVA.toFixed(4);
    $("#importesiniva_"+partir[1]).val(convertidoISI);

    
}

function calcularDesIvaDescuento(id,event){
    var partir = id.split("_");
    var importe = $("#importe_"+partir[1]).val();
    var descuento = $("#descuento_"+partir[1]).val();

        if(event.which == 13) {
            var banderaPorcentaje = $("#check_porcentaje:checked").length;
            if(banderaPorcentaje==1){
                descuento = parseFloat(descuento*0.10);
                convertidoD = descuento.toFixed(4);
                $("#descuento_"+partir[1]).val(convertidoD);
                var importeSinDescuento = parseFloat(importe-convertidoD);
                var convertidoISD = importeSinDescuento.toFixed(4);
                $("#importesindescuento_"+partir[1]).val(convertidoISD);

                var importeSinIVA =parseFloat(importeSinDescuento/1.16);
                var convertidoISI = importeSinIVA.toFixed(4);
                $("#importesiniva_"+partir[1]).val(convertidoISI);
            }
    }else{
    }
    
}

function showInformationModal (type) {
    let contentBody = `
        <p>Se recomienda el siguiente valor si el producto se maneja por importe:</p>
        <p>El importe de margen mínimo RED es de <strong>0.50</strong> o superior.</p>
        <p>Esta configuración se ocupa en el módulo de Permisos del cliente</p>
    `;

    if (type === 'porcentaje') {
        contentBody = `
            <p>Se recomiendan los siguienes valores si el producto se maneja por porcentaje:</p>
            <p>Si el producto es <strong>TAE</strong> el margen deseable es de <strong>0.20%</strong></p>
            <p>Si el producto es un <strong>PIN</strong> el margen deseable es de <strong>1.50%</strong></p>
            <p>Esta configuración se ocupa en el módulo de Permisos del cliente</p>
        `;
    }

    $('#modal-information .modal-body').html(contentBody);

    $('#modal-information').modal();
}