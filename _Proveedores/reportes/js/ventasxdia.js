function initViewConsultaCorte(){
	var Layout = {
        initBotones:function(){
            $("#cmb_cadena").empty();           
            $.post(BASE_PATH+"/_Reportes/Corresponsal/ajax/corresponsal.php", { tipo: 1 },
                function(response) {
                    var obj = jQuery.parseJSON(response);
                    $('#cmb_cadena').append('<option value="-1">Todo</option>');
                    if (obj !== null) {
                        jQuery.each(obj, function(index, value) {
                            var nombre_cadena = obj[index]['nombreCadena'];
                            $('#cmb_cadena').append('<option value="' + obj[index]['idCadena'] + '">' + nombre_cadena + '</option>');
                        });
                    }
                }
            ).fail(function(resp) { alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde'); });

            $('#cmb_cadena').change( function(){                            
                $("#txtRFC").val('');
                $("#txtCliente").val('');
                $("#txtCta").val('');
                $("#txtForelo").val('');
                $("#txtRFC,#txtCliente, #txtCta,#txtForelo").prop('disabled', false);

                var idCadena = $('#cmb_cadena').val();
                if(idCadena >= 0){
                    cmb_subcadena(idCadena,-1);
                }  
                 if(idCadena == -1){
                    $("#cmb_subcadena").empty();
                    $("#cmb_corresponsal").empty();
                 }
                          
            });

            $('#cmb_subcadena').change( function(){
                $("#cmb_corresponsal").empty();
                var idCadena = $('#cmb_cadena').val();
                var idSubCadena = $('#cmb_subcadena').val();
                if(idSubCadena > 0){
                    cmb_corresponsal(idCadena,idSubCadena);
                }          
            });

            $('#btn_ExportarVentasXDia').on('click', function(e){
                var unaopcion=false;
                familia = $('#familia_select').val();
                fecha1 = $('#fecIni').val();
                fecha2 = $('#fecFin').val();

                if (familia !=''){unaopcion=true;}
                if (fecha1 !='' && fecha2!=''){unaopcion=true;}
                if (fecha2 < fecha1){jAlert('La Fecha Final debe ser igual o mayor que la Fecha Inicial');return;}
                if (unaopcion==false){
                    jAlert('Seleccione al menos una opción');
                    return;
                }else{                  
                    $('#todoexcel').submit();
                }
            });

            $("#txtRFC,#txtCliente,#txtCta,#txtForelo").on('keyup', function(event){
                var id = event.target.id;
                var value = event.target.value;

                if(value == ""){
                    $('#cmb_cadena').val(-1);
                    $("#cmb_subcadena").empty();
                    $("#cmb_corresponsal").empty();
                }

                if(value == "" || value == undefined){
                    if(id == "txtRFC"){
                        $("#txtCliente, #txtCta,#txtForelo").prop('disabled', false);
                    }
                    if(id == "txtCliente"){
                        $("#txtRFC,#txtCta,#txtForelo").prop('disabled', false);
                    }
                    if(id == "txtCta"){
                        $("#txtRFC,#txtCliente,#txtForelo").prop('disabled', false);
                    }
                    if(id == "txtForelo"){
                        $("#txtRFC,#txtCliente,#txtCta").prop('disabled', false);
                    }
                }
                else{
                    if(id == "txtRFC"){
                        $("#txtCliente, #txtCta,#txtForelo").prop('disabled', true);
                    }
                    if(id == "txtCliente"){
                        $("#txtRFC,#txtCta,#txtForelo").prop('disabled', true);
                    }
                    if(id == "txtCta"){
                        $("#txtRFC,#txtCliente,#txtForelo").prop('disabled', true);
                    }
                    if(id == "txtForelo"){
                        $("#txtRFC,#txtCliente,#txtCta").prop('disabled', true);
                    }
                }
            }); 

            $( "#txtRFC" ).autocomplete({
               source: BASE_PATH+"/_Proveedores/reportes/ajax/search.php",
               minLength: 3,
               focus: function( event, ui ) {
                    $(this).val(ui.item.RFC);
                    return false;               
                },
                select: function( event, ui ) {
                    $('#cmb_cadena').val(ui.item.idCadena);  
                    cmb_subcadena(ui.item.idCadena,ui.item.idSubCadena);
                    cmb_corresponsal(ui.item.idCadena,ui.item.idSubCadena,ui.item.idCorresponsal);
                    return false;               
                }
            }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
                return $( '<li>' )
                .append( "<a>" + "RFC: " + item.RFC + " " + "<br><span class='thinTitle'>" + item.nombreCadena + "</span></a>").appendTo( ul );
            };

            $( "#txtCliente" ).autocomplete({
               source: BASE_PATH+"/_Proveedores/reportes/ajax/search.php",
               minLength: 3,
               focus: function( event, ui ) {
                    $(this).val(ui.item.nombre);
                    return false;               
                },
                select: function( event, ui ) {
                    $('#cmb_cadena').val(ui.item.idCadena);
                    cmb_subcadena(ui.item.idCadena,ui.item.idSubCadena);
                    cmb_corresponsal(ui.item.idCadena,ui.item.idSubCadena,ui.item.idCorresponsal);
                    return false;               
                }
            }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
                return $( '<li>' )
                .append( "<a><br><span class='thinTitle'>" + item.nombre + "</span></a>").appendTo( ul );
            };

            $( "#txtForelo" ).autocomplete({
               source: BASE_PATH+"/_Proveedores/reportes/ajax/search.php",
               minLength: 3,
               focus: function( event, ui ) {
                    $(this).val(ui.item.numCuenta);
                    return false;               
                },
                select: function( event, ui ) {
                    $('#cmb_cadena').val(ui.item.idCadena);
                    cmb_subcadena(ui.item.idCadena,ui.item.idSubCadena);
                    cmb_corresponsal(ui.item.idCadena,ui.item.idSubCadena,ui.item.idCorresponsal);
                    return false;               
                }
            }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
                return $( '<li>' )
                .append( "<a>" + "Forelo: " + item.numCuenta + " " + "<br><span class='thinTitle'>" + item.nombreCadena + "</span></a>").appendTo( ul );
            };

            $( "#txtCta" ).autocomplete({
               source: BASE_PATH+"/_Proveedores/reportes/ajax/search.php",
               minLength: 3,
               focus: function( event, ui ) {
                    $(this).val(ui.item.ctaContable);
                    return false;               
                },
                select: function( event, ui ) {
                    $('#cmb_cadena').val(ui.item.idCadena);
                    cmb_subcadena(ui.item.idCadena,ui.item.idSubCadena);
                    cmb_corresponsal(ui.item.idCadena,ui.item.idSubCadena,ui.item.idCorresponsal);
                    return false;               
                }
            }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
                return $( '<li>' )
                .append( "<a>" + "Cuenta: " + item.ctaContable + " " + "<br><span class='thinTitle'>" + item.nombreCadena + "</span></a>").appendTo( ul );
            };
        },
	}//Layout
    Layout.initBotones();
    cargarFamilias();
}

function cmb_subcadena(idCadena,idSubCadena){
    $("#cmb_subcadena").empty();   
    $.post(BASE_PATH+"/_Reportes/Corresponsal/ajax/corresponsal.php", { tipo: 2, idCadena:idCadena },
    function(response) {
        var obj = jQuery.parseJSON(response);                        
        $('#cmb_subcadena').append('<option value="-1">Todo</option>');
        if (obj !== null) {
            jQuery.each(obj, function(index, value) {
                var nombre_subcadena = obj[index]['nombreSubCadena'];
                if(idSubCadena==obj[index]['idSubCadena'])
                    $('#cmb_subcadena').append('<option selected value="' + obj[index]['idSubCadena'] + '">' + nombre_subcadena + '</option>');
                else
                    $('#cmb_subcadena').append('<option value="' + obj[index]['idSubCadena'] + '">' + nombre_subcadena + '</option>');
            });
        }
    }
    ).fail(function(resp) { alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde'); });
}

function cmb_corresponsal(idCadena,idSubCadena,idCorresponsal){
    $("#cmb_corresponsal").empty();
    $.post(BASE_PATH+"/_Reportes/Corresponsal/ajax/corresponsal.php", { tipo: 3, idCadena:idCadena,idSubCadena:idSubCadena },
    function(response) {
        var obj = jQuery.parseJSON(response);
        $('#cmb_corresponsal').append('<option value="-1">Todo</option>');
        if (obj !== null) {
            jQuery.each(obj, function(index, value) {
                var nombre_corresponsal = obj[index]['nombreCorresponsal'];
                if(idCorresponsal==obj[index]['idCorresponsal'])
                    $('#cmb_corresponsal').append('<option selected value="' + obj[index]['idCorresponsal'] + '">' + nombre_corresponsal + '</option>');
                else
                    $('#cmb_corresponsal').append('<option value="' + obj[index]['idCorresponsal'] + '">' + nombre_corresponsal + '</option>');

            });
        }
    }
    ).fail(function(resp) { alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde'); });
}

$("#btn_buscar_ventas").click(function(){
    var unaopcion=false;
    if ($('#familia_select').val()!=''){unaopcion=true;}
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
            var fechaIni = $("#fecIni").val();
            var fechaFin = $("#fecFin").val();
            var familia  = $("#familia_select option:selected").val();
            var cadena = $('#cmb_cadena option:selected').val();
            var subcadena = $('#cmb_subcadena').val();
            var corresponsal = $('#cmb_corresponsal').val();
            var combo = document.getElementById("cmb_cadena");
            var selected = combo.options[combo.selectedIndex].text;
            
            dataTableObj = $('#tabla_ventas').dataTable({
            "iDisplayLength"  : 10,  //numero de columnas a desplegar
                "bProcessing"   : true,     // mensaje 
                "bServerSide"   : true,    //procesamiento del servidor
                "bFilter"     : true,       //no permite el filtrado caja de texto
                "bDestroy": true,           // reinicializa la tabla 
                "sAjaxSource"       : "../ajax/consultaventasxdia.php", //ajax que consulta la informacion
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
                        'aTargets'  : ['_all'],
                        "bSortable": false
                    },
                    {
                        "mData"   : 'nMesFecAltaOparacion',
                        'aTargets'  : [0]
                    },
                    {
                        "mData"   : 'dFecAltaOperacion',
                        'aTargets'  : [1]
                    },
                    {
                        "mData"   : 'nIdCadena',
                        'aTargets'  : [2]
                    },
                    {
                        "mData"   : 'sNombreCadena',
                        'aTargets'  : [3]
                    },
                    {
                        "mData"   : 'nIdSubCadena',
                        'aTargets'  : [4]
                    },
                    {
                        "mData"   : 'sNombreSubCadena',
                        'aTargets'  : [5]
                    },
                    {
                        "mData"   : 'nIdCorresponsal',
                        'aTargets'  : [6]
                    },
                    {
                        "mData"   : 'sNombreCorresponsal',
                        'aTargets'  : [7]
                    },
                    {
                        'mData': 'sRfcCliente',
                        'aTargets': [8]
                    },
                    {
                        "mData"   : 'nIdProveedor',
                        'aTargets'  : [9]
                    },
                    {
                        "mData"   : 'sNombreProveedor',
                        'aTargets'  : [10]
                    },
                    {
                        'mData': 'sRfcProveedor',
                        'aTargets': [11]
                    },
                    {
                        "mData"   : 'nIdFamilia',
                        'aTargets'  : [12]
                    },
                    {
                        "mData"   : 'sDescFamilia',
                        'aTargets'  : [13]
                    },
                    {
                        "mData"   : 'nIdEmisor',
                        'aTargets'  : [14]
                    },
                    {
                        "mData"   : 'sDescEmisor',
                        'aTargets'  : [15]
                    },
                    {
                        "mData"   : 'nIdProducto',
                        'aTargets'  : [16]
                    },
                    {
                        "mData"   : 'sDescProducto',
                        'aTargets'  : [17]
                    },
                    {
                        "mData"   : 'sNumCuenta',
                        'aTargets'  : [18]
                    },
                    {
                        "mData"   : 'sCtaContable',
                        'aTargets'  : [19]
                    },
                    {
                        "mData"   : 'nVentas',
                        'aTargets'  : [20]
                    },
                    {
                        "mData"   : 'nImporte',
                        'aTargets'  : [21]
                    },
                    {
                        "mData"   : 'nRetiros',
                        'aTargets'  : [22]
                    },
                    {
                        "mData"   : 'nComCorresponsales',
                        'aTargets'  : [23]
                    },
                    {
                        "mData"   : 'nClienteCxC',
                        'aTargets'  : [24]
                    },
                    {
                        "mData"   : 'nComIntegradores',
                        'aTargets'  : [25]
                    },
                    {
                        "mData"   : 'nComRecibo',
                        'aTargets'  : [26]
                    },
                    {
                        "mData"   : 'nCPS',
                        'aTargets'  : [27]
                    },
                    {
                        "mData"   : 'nIngreso',
                        'aTargets'  : [28]
                    },
                    {
                        "mData"   : 'nComOperacion',
                        'aTargets'  : [29]
                    },
                    {
                        "mData"   : 'nProveedorCxP',
                        'aTargets'  : [30]
                    }
                ],
                "fnDrawCallback" : function(aoData) {
                    if(aoData._iRecordsDisplay>0){
                        mostrarBotones();
						$("#fecha1_excel").val(fechaIni);
						$("#fecha2_excel").val(fechaFin);
                        $("#familia_select_excel").val(familia);
                        $("#cadena_excel").val(cadena);
                        $("#subcadena_excel").val(subcadena);
                        $("#corresponsal_excel").val(corresponsal);
                        $("#cadena_txt").val(selected);

                    }else{
                        ocultarBotones();
                    }
                },
                "fnPreDrawCallback" : function() {            
                },
                
                "fnServerParams" : function (aoData){//Funcion que se activa al buscar infromacion en la tabla o cambiar de pagina aoData contiene l ainfo del datatable                
                    var params = {};
                    params['caso'] = 1; 
                    params['tipoReporte'] =  1; // 1 >> reporte normal, 2 >> reporte en excel
                    params['fechaIni'] =  fechaIni;
                    params['fechaFin']   =  fechaFin;
                    params['familia'] = familia;
                    params['cadena'] = cadena;
                    params['subcadena'] = subcadena;
                    params['corresponsal'] = corresponsal;
                    $.each(params, function(index, val){
                        aoData.push({name : index, value : val });
                    });
                },   
            });

            $("#tabla_ventas").css("display", "inline-table");
            $("#tabla_ventas").css("width", "100%");   
        
 }

function mostrarBotones(){
    $(".excel").fadeIn("normal");
} 

function ocultarBotones(){
    $(".excel").hide();
} 
function cargarFamilias(){
    $.ajax({
            data:{
              tipo : 1
            },
            type: 'POST',
            async : false,
            url: BASE_PATH + '/_Proveedores/proveedor/ajax/altaProveedores.php',
            success: function(response){
                var obj = jQuery.parseJSON(response);
                $('#familia_select').append('<option value="0">Seleccione</option>');
                jQuery.each(obj,function(index,value){
                    var nombreFamilia = obj[index]['descFamilia'];
                    $('#familia_select').append('<option value="'+obj[index]['idFamilia']+'">'+nombreFamilia+'</option>');
                });
            }
        });
}
