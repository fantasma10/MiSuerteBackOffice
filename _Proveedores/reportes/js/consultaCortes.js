$(document).ready(function() {
    
});


/*function mostrarSpinner(){
    var html_spinner = '<div id="spinner" class="spinner" style="display:none;position: fixed;top: 0%;z-index: 1234567;overflow: auto;width: 100%;height: 100%;background-color: rgba(0, 0, 0, 0.6);background-color: rgb(0, 0, 0);background-color: rgba(0, 0, 0, 0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";"><img id="img-spinner" src="'+BASE_PATH+'/img/loading.gif" alt="Loading" style="position:fixed;margin-top:25%;margin-left:48%;padding:5px;background-color:#FFFFFF;"/></div>';
    $('body').append(html_spinner);
    $('#spinner').fadeIn();
}*/
function ocultarSpinner(){
    $('#spinner').fadeOut();
}


function initViewConsultaCorte() {
    var Layout = {
        buscaProveedores: function() {
            $("#select_proveedor").empty();
            $.post("../ajax/consultaCortes.php", { tipo: 1 },
                function(response) {
                    var obj = jQuery.parseJSON(response);
                    $('#select_proveedor').append('<option value="0">Todo</option>');
                    if (obj !== null) {
                        jQuery.each(obj, function(index, value) {
                            var nombre_proveedor = obj[index]['nombreProveedor'];
                            $('#select_proveedor').append('<option value="' + obj[index]['idProveedor'] + '">' + nombre_proveedor + '</option>');
                        });
                    }
                }
                ).fail(function(resp) { alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde'); })
        },
        initBotones: function() {
            // if(PERMISO_USER == 1){//analista
            //     $("#etiquetaTipoUsuario").html("/ANALISTA");
            // }
            // if(PERMISO_USER == 2){//autorizador
            //     $("#etiquetaTipoUsuario").html("/AUTORIZADOR");
            //     $("#etiquetaUsuario1").html("Fecha Liquidación");
            //     $("#etiquetaUsuario2").html("Fecha Liquidación");
            // }else{
            //     $("#etiquetaUsuario1").html("Fecha Corte");
            //     $("#etiquetaUsuario2").html("Fecha Corte");
            // }

            $('#btn_ExportarCorteExcel').on('click', function(e) {
                var unaopcion = false;
                id_proveedor = $('#select_proveedor').val();
                fecha1 = $('#fecIni').val();
                fecha2 = $('#fecFin').val();
                tipo = $('#select-tipo-fecha').val();
                if (id_proveedor != '') { unaopcion = true; }
                if (fecha1 != '' && fecha2 != '') { unaopcion = true; }
                if (fecha2 < fecha1) { jAlert('La Fecha Final debe ser igual o mayor que la Fecha Inicial'); return; }
                if (unaopcion == false) {
                    jAlert('Seleccione al menos una opción');
                    return;
                } else {
                    $('#id_proveedor_excel').val(id_proveedor);
                    $('#fecha1_excel').val(fecha1);
                    $('#fecha2_excel').val(fecha2);
                    $('#tipo').val(tipo);
                    $('#todoexcel').submit();
                }
            });

            //vista analista
            $("#selectEstatus").change(function() { 
                var opcion = $("#selectEstatus option:selected").val();
                var proveedor = $("#idProveedorP").val();
                var fecha = $("#fechaP").val();
                var corte = $("#idCorteP").val();
                var referenciaZona = $("#referenciaP").val();
                var estatusCorte = $("#estatusCorte").val();
                var zona = $("#zona").val();
                verDetalle(proveedor, fecha, corte, estatusCorte,opcion,zona,'');
            });

            //vista analista
            $("#cerrarModalCorte").click(function() {
                $("#selectEstatus option[value='0']").prop('selected', true);
            });

            //vista analista
            $("#guardarCorte").click(function() {
                $("#modalConfirmacionCorte").modal('show');
            });

            //vista analista
            $("#confirmarCierreCorte").click(function() {
                $("#modalConfirmacionCorte").modal('hide');
                var proveedor = $("#idProveedorP").val();
                var corte = $("#idCorteP").val();
                var zona = $("#zona").val();
                $.ajax({
                    data: {
                        tipo: 7,
                        proveedor: proveedor,
                        zona: zona,
                        corte: corte
                    },
                    type: 'POST',
                    cache: false,
                    url: '../ajax/consultaCortes.php',
                    success: function(response) {
                        var obj = jQuery.parseJSON(response);
                        if (obj["estatus"] == 0) {                    
                            jAlert(obj["respuesta"]);
                            $("#myModal").modal('hide');
                            buscarDatos();
                        } else { // Exito de cierre
                            jAlert(obj["respuesta"]);
                        }
                    }
                });
            });

            //vista analista
            $("#guardarAclaracion").click(function() {
                var motivo = $("#motivoAclaracion").val();
                var monto = $("#montoAclaracion").val();
                var idProveedorP = $("#idProveedorP").val();
                var idCorteP = $("#idCorteP").val();
                var currentIdOperacion = $("#currentIdOperacion").val();
                motivo = motivo.trim(); //limpiar espacios
                var pTipoOperacion = $("#pTipoOperacion").val();
                var fechaP = $("#fechaP").val();
                var tipoMovimiento = $("#pTipoMovimiento").val();
                var referenciaZona = $("#referenciaP").val();
                //console.log(pTipoOperacion+'-'+tipoMovimiento);
                if (motivo.length > 0) {

                    $("#motivoAclaracion").val(motivo);
                    guardarAclaracion(idCorteP, currentIdOperacion, idProveedorP, motivo, monto, pTipoOperacion, fechaP,referenciaZona);

                } else {
                    $("#motivoAclaracion").val("");
                    jAlert("Favor de ingresar un motivo de aclaracion");
                }
            });

            //vista autoriza
            $("#autorizarCorte").click(function() {
                var idProveedor =$("#idProveedor").val();
                var fechaPago = $("#fechaPago").val();
                var zona = $("#idZona").val();
                autorizarCorte(idProveedor,fechaPago,zona);
            });

            //vista autoriza
            $("#rechazarCorte").click(function(){
                var idProveedor =$("#idProveedor").val();
                var fechaPago = $("#fechaPago").val();
                var zona = $("#idZona").val();
                rechazarCorte(idProveedor,fechaPago,zona);
            });
        }
    } //Layout
    Layout.buscaProveedores();
    Layout.initBotones();
}

$("#btn_buscar_cortes").click(function() {
    var unaopcion = false;
    if ($('#select_proveedor').val() != '') {  unaopcion = true; }
    if ($('#fecIni').val() != '' && $('#fecFin').val() != '') { unaopcion = true; }
    if ($('#fecFin').val() < $('#fecIni').val()) { jAlert('La Fecha Final debe ser igual o mayor que la Fecha Inicial'); return; }
    if (unaopcion == false){
        jAlert('Seleccione al menos una opción');
        return;
    }else{
        buscarDatos();
    }
});

var p_proveedor =0;
var p_fechaIni="";
var p_fechaFin="";
function buscarDatos() {
    var bandera =1;
    var arregloProveedor = [];
  
    var dataTableObj;
    var proveedor = $("#select_proveedor option:selected").val();
    var fechaIni = $("#fecIni").val();
    var fechaFin = $("#fecFin").val();
    var fechaTipo = $("#select-tipo-fecha").val();

    if(p_proveedor == proveedor && p_fechaIni ==fechaIni && p_fechaFin == fechaFin){
        bandera = 1;//todo
    }else{
        bandera = 0;
    }
    p_proveedor = proveedor;
    p_fechaIni = fechaIni;
    p_fechaFin = fechaFin;
    boton ="";
    cont=0;

    dataTableObj = $('#tabla_proveedores').dataTable({
        "iDisplayLength": 50,
        "bProcessing": true,
        "bServerSide": true,
        "bFilter": true,
        "bDestroy": true,
        //"bSortable": true,
        "sAjaxSource": "../ajax/consultaCortes.php",
        "sServerMethod": 'POST',
        "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_",
            "sZeroRecords": "No se ha encontrado información",
            "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ Registros",
            "sInfoEmpty": "Mostrando 0 a 0 de 0 Registros",
            "sInfoFiltered": "(filtrado de _MAX_ total de Registros)",
            "sProcessing": "<img src='../../../img/cargando3.gif'> Loading...",
            "sSearch": "Buscar",
            "oPaginate": {
                "sPrevious": "Anterior",
                "sNext": "Siguiente"
            }
        },
        "aoColumnDefs": [
            {
                'aTargets': [],
                "bSortable": false
            },
            {
                "mData": 'nIdProveedor',
                'aTargets': [0]
            },
            {
                "mData": 'razonSocial',
                'aTargets': [1]
            },
            {
                "mData": 'dFecha',
                'aTargets': [2],
                'sWidth': '90px'
            },
            {
                "mData": 'dFechaPago',
                'aTargets': [3],
                'sWidth': '90px'
            },
            {
                "mData": 'nTotalOperaciones',
                'aTargets': [4],
                'sClass'  : 'align-right'
            },
            {
                "mData": 'nTotalMonto',
                'aTargets': [5],
                'sClass'  : 'align-right'
            },
            {
                "mData": 'nTotalComision',
                'aTargets': [6],
                'sClass'  : 'align-right'
            },
            {
                "mData": 'nComisionCxP',
                'aTargets': [7],
                'sClass'  : 'align-right'
            },
            {
                "mData": 'nImporteTransferencia',
                'aTargets': [8],
                'sClass'  : 'align-right'
            },
            {
                "mData": 'nTotalPago',
                'aTargets': [9],
                'sClass'  : 'align-right'
            }
        ],
        "fnDrawCallback": function(aoData) {            
            if (aoData._iRecordsDisplay > 0) {
                mostrarBotones();
            } else {
                ocultarBotones();
            }
        },
        "fnFooterCallback": function (tfoot, data, start, end, display) { 
            var totOpe = 0;
            var totMonto = 0;
            var totCom = 0;
            var totPago = 0;
            var totComCxP = 0;
            var totTrans=0;
            var ban =0;
            for (var i = 0; i < data.length; i++) {
                totOpe = totOpe + parseFloat(data[i]['nTotalOperaciones']);
                totMonto = totMonto + parseFloat(data[i]['nTotalMonto2']);
                totCom = totCom + parseFloat(data[i]['nTotalComision2']);
                totPago = totPago + parseFloat(data[i]['nTotalPago2']);
                totComCxP = totComCxP + parseFloat(data[i]['nComisionCxP2']);
                totTrans = totTrans + parseFloat(data[i]['nImporteTransferencia2']);
            }  
           
            btn_cerrar='';      
            if(data.length>0){                
                $("#footDetalle").show(); 
               /* if((proveedor==GASNATURAL || proveedor==METROGAS) && ban==1){
                    btn_cerrar = '<center><button data-toggle="modal" data-target="#modalConfirmacionCorte2"  data-placement="top" rel="tooltip" class="btn habilitar btn-default btn-xs">Cerrar corte</button></center>';
                }*/
                var options = {minimumFractionDigits:2}
                $(tfoot).find('td').eq(0).html();
                $(tfoot).find('td').eq(1).html(totOpe.toLocaleString("en-US"));
                $(tfoot).find('td').eq(2).html("$"+totMonto.toLocaleString("en-US",options));
                $(tfoot).find('td').eq(3).html("$"+totCom.toLocaleString("en-US",options));
                $(tfoot).find('td').eq(4).html("$"+totComCxP.toLocaleString("en-US",options)); 
                $(tfoot).find('td').eq(5).html("$"+totTrans.toLocaleString("en-US",options));   
                $(tfoot).find('td').eq(6).html("$"+totPago.toLocaleString("en-US",options));                
                $(tfoot).find('td').eq(7).html(btn_cerrar);    
            }else{
                $("#footDetalle").hide();
            }
            
        },
        "fnPreDrawCallback": function() {},
        "fnServerParams": function(aoData) {
            var params = {};
            params['tipo'] = 2;
            params['proveedor'] = proveedor;
            params['fechaIni'] = fechaIni;
            params['fechaFin'] = fechaFin;
            params['fechaTipo'] = fechaTipo;
            $.each(params, function(index, val) {
                aoData.push({ name: index, value: val });
            });
        },
    });

    $("#tabla_proveedores").css("display", "inline-table");
    $("#tabla_proveedores").css("width", "100%");  
}

function verDetalle(idProveedor, fecha, idCorte, estatusCorte,opcion,zona,nombreZona) {
   
    $("#idProveedorP").val(idProveedor);
    $("#fechaP").val(fecha);
    $("#idCorteP").val(idCorte);
    $("#estatusCorte").val(estatusCorte);
    $("#zona").val(zona);
    $("#myModal").modal('show');
    
    var propiedadRow = "";
    if (PERMISO_USER == 1) { //analisis
        if (estatusCorte == 2 || estatusCorte == 3) {
            propiedadRow = "disabled='true'";
            $("#guardarCorte").hide();
        }
        if(estatusCorte == 1){
            $("#guardarCorte").show();
        }
    }
    
    if(zona>0){
        $("#h4text").text("DETALLE DE OPERACIONES CORRESPONDIENTE AL DIA " + fecha + " ZONA "+zona+" "+nombreZona);
        propiedadRow = "disabled='true'";
    }else{
        $("#h4text").text("DETALLE DE OPERACIONES DEL CORTE " + idCorte + " CORRESPONDIENTE AL DIA " + fecha);
    }

    

    var contadorRows = 0;
    var contadorFila = 0;
    var dataTableObj;
    dataTableObj = $('#tabla_operaciones').dataTable({
        "iDisplayLength": 10,
        "bProcessing": true,
        "bServerSide": true,
        "bFilter": true,
        "bDestroy": true,
        "sAjaxSource": "../ajax/consultaCortes.php",
        "sServerMethod": 'POST',
        "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_",
            "sZeroRecords": "No se ha encontrado información",
            "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ Registros",
            "sInfoEmpty": "Mostrando 0 a 0 de 0 Registros",
            "sInfoFiltered": "(filtrado de _MAX_ total de Registros)",
            "sProcessing": "<img src='../../../img/cargando3.gif'> Loading...",
            "sSearch": "Buscar",
            "oPaginate": {
                "sPrevious": "Anterior",
                "sNext": "Siguiente"
            }
        },
        "aoColumnDefs": [{
            'aTargets': [0, 1, 2, 3, 4, 5,6,7],
            "bSortable": false
        },
        {
            "mData": 'idOperacion',
            'aTargets': [0],
        },
        {
            "mData": 'ticket',
            'aTargets': [1]
        },
        {
            "mData": 'referencia1Operacion',
            'aTargets': [2]
        },
        {
            "mData": 'nombreCadena',
            'aTargets': [3]
        },
        {
            "mData": 'nombreCorresponsal',
            'aTargets': [4]
        },
        {
            "mData": 'importeOperacion',
            'aTargets': [5]
        },
        {
            "mData": 'idOperacion',
            'aTargets': [6],
            mRender: function(data, type, row) {
                var importeC = "'" + row.importeOperacion + "'";
                var concepto = "'" + row.sConcepto + "'";
                var estatusC = row.idEstatusOperacion;
                var boton = "";
                var boton_edit = "";

                contadorFila++;
                if (row.evaluacion == "Agregada") {
                    contadorRows++;
                    boton_edit = '<button ' + propiedadRow + ' id="detalleAclaracion'+contadorFila+'" onclick="verDetalleOperacion(' + row.idOperacion + ',' +concepto+','+ importeC + ',1);" data-placement="top" rel="tooltip" title="" class="btn habilitar btn-default btn-xs" data-title=""><span id="span'+contadorFila+'" class="fa fa-check"></span></button>';
                    boton = "<center>" + boton_edit + "</center>";
                } else if (row.evaluacion == "Quitada") {
                    contadorRows++;
                    boton_edit = '<button ' + propiedadRow + ' id="detalleAclaracion'+contadorFila+'" onclick="verDetalleOperacion(' + row.idOperacion + ',' +concepto+','+ importeC + ',0);" data-placement="top" rel="tooltip" title="Agregar Aclaracion" class="btn habilitar btn-default btn-xs" data-title="Agregar Aclaracion"><span id="span'+contadorFila+'" class="fa fa-plus-circle"></span></button>';
                    boton = "<center>" + boton_edit + "</center>";

                } else if (row.evaluacion == "Default") {
                    if (estatusC == 0) {
                        boton_edit = '<button ' + propiedadRow + ' id="detalleAclaracion'+contadorFila+'" onclick="verDetalleOperacion(' + row.idOperacion + ',' +concepto+','+ importeC + ',0);" data-placement="top" rel="tooltip" title="Agregar Aclaracion" class="btn habilitar btn-default btn-xs" data-title="Agregar Aclaracion"><span id="span'+contadorFila+'" class="fa fa-plus-circle"></span></button>';
                        boton = "<center>" + boton_edit + "</center>";
                    } else {
                        boton = "";
                    }

                }
                return boton;
            }
        }, 
        {
            "mData": 'idOperacion',
            'aTargets': [7],            
            mRender: function(data, type, row) {
                var importeC = "'" + row.importeOperacion + "'";
                var concepto = "'" + row.sConcepto + "'";
                var estatusC = row.idEstatusOperacion;
                var boton_edit = "";
                var boton = "";
                if (row.evaluacion == 'Quitada') {
                    contadorRows++;
                    boton_edit = '<button ' + propiedadRow + ' id="detalleAclaracion'+contadorFila+'" onclick="verDetalleOperacion(' + row.idOperacion + ','+concepto+','+ importeC + ',1);" data-placement="top" rel="tooltip" title="" class="btn habilitar btn-default btn-xs" data-title=""><span id="span'+contadorFila+'" class="fa fa-check"></span></button>';
                    boton = "<center>" + boton_edit + "</center>";
                } else if (row.evaluacion == 'Agregada') {
                    contadorRows++;
                    boton_edit = '<button ' + propiedadRow + ' id="detalleAclaracion'+contadorFila+'" onclick="verDetalleOperacion(' + row.idOperacion + ',' +concepto+','+ importeC + ',1);" data-placement="top" rel="tooltip" title="Agregar Aclaracion" class="btn habilitar btn-default btn-xs" data-title="Agregar Aclaracion"><span id="span'+contadorFila+'" class="fa fa-times"></span></button>';
                    boton = "<center>" + boton_edit + "</center>";
                } else if (row.evaluacion == "Default") {
                    if (estatusC != 0) {
                        contadorRows++;
                        boton_edit = '<button ' + propiedadRow + ' id="detalleAclaracion'+contadorFila+'" onclick="verDetalleOperacion(' + row.idOperacion + ',' +concepto+','+ importeC + ',1);" data-placement="top" rel="tooltip" title="Agregar Aclaracion" class="btn habilitar btn-default btn-xs" data-title="Agregar Aclaracion"><span id="span'+contadorFila+'" class="fa fa-times"></span></button>';
                        boton = "<center>" + boton_edit + "</center>";
                    } else {
                        boton = "";
                    }
                }

                return boton;
            }
        },
        ],
        "fnDrawCallback": function(aoData) {
        },
        "fnPreDrawCallback": function() {},
        "fnServerParams": function(aoData) {
            var params = {};
            params['tipo'] = 5;
            params['idProveedor'] = idProveedor;
            params['fecha'] = fecha;
            params['estatusOperacion'] = opcion;
            params['zonaReferencia'] = zona;
            $.each(params, function(index, val) {
                aoData.push({ name: index, value: val });
            });
        },
    });
           
    $("#tabla_operaciones").css("display", "inline-table");
    $("#tabla_operaciones").css("width", "100%");
}

function verDetalleOperacion(idOperacion,concepto,importe, tipoOperacion) {
    $("#motivoAclaracion").val("");
    $("#currentIdOperacion").val(idOperacion);
    $("#motivoAclaracion").val((concepto!="")?concepto:"");    
    $("#montoAclaracion").val(importe);
    $("#pTipoOperacion").val(tipoOperacion);
    $("#pTipoMovimiento").val((concepto!="")?1:0);
    $("#modalAclaracion").modal('show');
}

function buscarDatosTareas() {
    var dataTableObj;
    var proveedor = $("#select_proveedor option:selected").val();
    var fechaIni = $("#fecIni").val();
    var fechaFin = $("#fecFin").val();
    
    dataTableObj = $('#tabla_autorizador').dataTable({
        "iDisplayLength": 50,
        "bProcessing": true,
        "bServerSide": true,
        "bFilter": true,
        "bDestroy": true,
        "sAjaxSource": "../ajax/consultaCortes.php",
        "sServerMethod": 'POST',
        "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_",
            "sZeroRecords": "No se ha encontrado información",
            "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ Registros",
            "sInfoEmpty": "Mostrando 0 a 0 de 0 Registros",
            "sInfoFiltered": "(filtrado de _MAX_ total de Registros)",
            "sProcessing": "<img src='../../../img/cargando3.gif'> Loading...",
            "sSearch": "Buscar",
            "oPaginate": {
                "sPrevious": "Anterior",
                "sNext": "Siguiente"
            }
        },
        "aoColumnDefs": [
            {
                'aTargets': [0, 1, 2, 3, 4, 5, 6,7,8],
                "bSortable": false
            },
            {
                "mData": 'nIdProveedor',
                'aTargets': [0]
            },
            {
                "mData": 'nombreProveedor',
                'aTargets': [1]
            },
            {
                "mData": 'nZona',
                'aTargets': [2]
            },
            {
                "mData": 'dFechaPago',
                'aTargets': [3]
            },
            {
                "mData": 'nTotalOperaciones',
                'aTargets': [4]
            },
            {
                "mData": 'nTotalMonto',
                'aTargets': [5]
            },
            {
                "mData": 'nTotalComision',
                'aTargets': [6]
            },
            {
                "mData": 'nTotalPago',
                'aTargets': [7]
            },           
            {
                "mData": 'nEnviaReporte',
                'aTargets': [8],
                mRender: function(data, type, row) {
                    boton="";
                    var dFechaPago = "'" + row.dFechaPago + "'";
                    var nIdProveedor = row.nIdProveedor;
                    var zona = row.nZona;
                    var envioCorreo = row.envioCorreo;
                    var iconoRow="";
                                        
                    if (PERMISO_USER == 2 && data == 0 && nIdProveedor == TELMEX) { // usuario que autoriza y envia reporte
                        iconoRow = "fa fa-pencil";
                        $("#tabla_iconos").hide();
                        
                        var iconoAclaracion = "fa fa-list";
                        boton_edit = '<button onclick="verDetalleTareas('+ nIdProveedor + ',' + dFechaPago+','+zona+');" data-placement="top" rel="tooltip" title="Revisar Cortes" class="btn habilitar btn-default btn-xs" data-title="Revisar Cortes"><span class="'+iconoRow+'"></span></button>';
                        botonAclar = '<button onclick="verDetalleAclaraciones('+ nIdProveedor + ',' + dFechaPago+');" data-placement="top" rel="tooltip" title="Detalle Aclaraciones" class="btn habilitar btn-default btn-xs" data-title="Detalle Aclaraciones"><span class="'+iconoAclaracion+'"></span></button>';
                        boton = "<center>" + boton_edit +"&nbsp;&nbsp;&nbsp;"+ botonAclar+ "</center>";
                    }
                    if(envioCorreo>0){
                        boton ="Correo Enviado";
                    }               
                    return boton;
                }
            }
        ],
        "fnDrawCallback": function(aoData) {},
        "fnPreDrawCallback": function() {},
        "fnFooterCallback": function (tfoot, data, start, end, display) { 
            var totOpe = 0;
            var totMonto = 0;
            var totCom = 0;
            var totPago = 0;
            var ban =0;
            for (var i = 0; i < data.length; i++) {
                totOpe = totOpe + parseFloat(data[i]['nTotalOperaciones']);
                totMonto = totMonto + parseFloat(data[i]['nTotalMonto2']);
                totCom = totCom + parseFloat(data[i]['nTotalComision2']);
                totPago = totPago + parseFloat(data[i]['nTotalPago2']);
                // if(data[i]['nIdEstatus']==1 || data[i]['nIdEstatus']==4){
                //     ban=1;
                // }
            }  
           
            btn_autorizar='';      
            if(data.length>0){                
                $("#footDetalle2").show(); 
                if((proveedor==GASNATURAL || proveedor==METROGAS)){
                    btn_autorizar = '<center><button data-toggle="modal" data-target="#modalAutorizacion"  data-placement="top" rel="tooltip" class="btn habilitar btn-default btn-xs">Autorizar</button></center>';
                }
                var options = {minimumFractionDigits:2}
                $(tfoot).find('td').eq(0).html();
                $(tfoot).find('td').eq(1).html(totOpe.toLocaleString("en-US"));
                $(tfoot).find('td').eq(2).html("$"+totMonto.toLocaleString("en-US",options));
                $(tfoot).find('td').eq(3).html("$"+totCom.toLocaleString("en-US",options));
                $(tfoot).find('td').eq(4).html("$"+totPago.toLocaleString("en-US",options));
                $(tfoot).find('td').eq(5).html(btn_autorizar);    
            }else{
                $("#footDetalle2").hide();
            }
            
        },
        "fnServerParams": function(aoData) {
            var params = {};
            params['tipo'] = 3;
            params['proveedor'] = proveedor;
            params['fechaIni'] = fechaIni;
            params['fechaFin'] = fechaFin;
            $.each(params, function(index, val) {
                aoData.push({ name: index, value: val });
            });
        }
    });

    $("#tabla_autorizador").css("display", "inline-table");
    $("#tabla_autorizador").css("width", "100%");
}

function verDetalleAclaraciones(idProveedor,fechaPago){
    

    $.post(BASE_PATH +"/_Proveedores/reportes/ajax/consultaCortes.php",{
      tipo:4,
      idProveedor : idProveedor,
      fechaPago: fechaPago
    },
    function(response){   
        var obj = jQuery.parseJSON(response);
        var html="";
        var datos = obj.aaData;
        for(i=0;i<datos.length;i++){
            html += '<tr>';
            html += '<td>'+datos[i]['dFechaCorte']+'</td>';
            html += '<td>'+datos[i]['nIdsOperacion']+'</td>';
            html += '<td>'+datos[i]['nombreProveedor']+'</td>';
            html += '<td>'+datos[i]['sConcepto']+'</td>';
            html += '<td>'+datos[i]['nMonto']+'</td>';
            html += '<td>'+datos[i]['tipoOperacion']+'</td>';
            html += '</tr>';
        }
        tabla = "<table class='table table-bordered table-striped'><th>Fecha Corte</th><th>Id Operacion</th><th>Proveedor</th><th>Concepto</th><th>Monto</th><th>Tipo</th>"+html+"</tabla>";    
        $("#tabla_aclaraciones").html(tabla);
        $("#modalDetalleAclaraciones").modal("show")
    })
    .fail(function(resp){
      alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
    })
}

function verDetalleTareas(idProveedor,fechaPago,zona){
    tablaE="";
    tablaC="";
    tablaP="";    
    $.ajax({
        data: {
            tipo: 11,
            idProveedor: idProveedor,
            fechaPago : fechaPago,
            zona: zona 
        },
        type: 'POST',
        cache: false,
        async: false,
        url: '../ajax/consultaCortes.php',
        success: function(response) {
            $("#idProveedor").val(idProveedor);
            $("#fechaPago").val(fechaPago);
            $("#idZona").val(zona);
            var obj = jQuery.parseJSON(response);
            tablaE = "<table class='table table-bordered'>";
            tablaE +="<tr><td align='center' colspan='3'>COBRANZA</td><td align='center' colspan='3'>LIQUIDACIÓN</td></tr>";
            tablaE +="<tr><td align='center'>DIA</td><td align='center'>RECIBOS</td><td align='center'>IMPORTE</td><td align='center'>DIA</td><td align='center'>RECIBOS</td><td align='center'>IMPORTE</td></tr>";
            
            datos = obj['datosCuerpo'];
            for (var i = 0; i < datos.length; i++) {
                tablaC ="<tr>";
                tablaC +="<td>"+ datos[i]['diaCorte']+"</td>"
                tablaC +="<td>"+ datos[i]['nTotalOpeCobranza']+"</td>"
                tablaC +="<td>"+ datos[i]['nTotalMontoCobranza']+"</td>"
                tablaC +="<td>"+ datos[i]['diaPago']+"</td>"
                 tablaC +="<td>"+ datos[i]['nTotalOpeLiquidacion']+"</td>"
                tablaC +="<td>"+ datos[i]['nTotalMontoLiquidacion']+"</td>"
                tablaC +="</tr>";
            }

            datos2 = obj['datosPie'];
            tablaP2="";
            if(datos2[0]['aclaracionesPositivas']>0){
                tablaP2 +="<tr><td colspan='5' align='right'>+"+datos2[0]['aclaracionesPositivas']+" ACLARACIONES</td><td>"+datos2[0]['montoAclaracionesPositivas']+"</td></tr>";
            }
            if(datos2[0]['aclaracionesNegativas']>0){
                tablaP2 +="<tr><td colspan='5' align='right'>- "+datos2[0]['aclaracionesNegativas']+" ACLARACIONES</td><td>"+datos2[0]['montoAclaracionesNegativas']+"</td></tr>";
            }
            
            tablaP +="</tr><td colspan='5' align='right'>- COMISION</td><td>"+datos2[0]['comision']+"</td></tr>"
            tablaP +="</tr><td colspan='5' align='right'>NETO DEPOSITADO</td><td>"+ datos2[0]['netoDepositado']+"</td></tr>"

            $("#cuerpoModal").html(tablaE+tablaC+tablaP2+tablaP);
            if(obj['historico']==0){
                $("#autorizarCorte").css('display','none');
                $("#rechazarCorte").css('display','none')
            }else{
                $("#autorizarCorte").css('display','inline');
                $("#rechazarCorte").css('display','inline');
            }
            $("#modalMultiCortes").modal('show');
        }
    });
}

function autorizarCorte(idProveedor,fechaPago,zona){
    $.ajax({
        data: {
            tipo: 8,
            proveedor : idProveedor,
            fechaPago : fechaPago,
            zona: zona
        },
            type: 'POST',
            cache: false,
            async: false,
            url: '../ajax/consultaCortes.php',
            success: function(response) {
                var obj = jQuery.parseJSON(response);
                jAlert(obj["sMensaje"],'ALERTA');
                setTimeout(function(){
                    $("#modalMultiCortes").modal('hide');
                    buscarDatosTareas();
                } ,1000);
            }
        }).done(function() {
            //ocultarSpinner();
        });
}

function rechazarCorte(idProveedor,fechaPago,zona){
    $.ajax({
        data: {
            tipo: 9,
            proveedor: idProveedor,
            fechaPago : fechaPago,
            zona: zona
        },
        type: 'POST',
        cache: false,
        async: false,
        url: '../ajax/consultaCortes.php',
        success: function(response) {
            var obj = jQuery.parseJSON(response);
            jAlert(obj["sMensaje"],'ALERTA');
            setTimeout(function(){
                $("#modalMultiCortes").modal('hide');
                buscarDatosTareas();
            } ,1000);
        }
    }).done(function() {
        ocultarSpinner();
    });
}

function guardarAclaracion(corte, idOperacion, idProveedor, concepto, monto, pTipoOperacion, fechaP,referenciaZona) {
    var montoFiltrado = monto.replace("$", "");
    montoFiltrado = montoFiltrado.replace(",", "");
    $.ajax({
        data: {
            tipo: 6,
            corte: corte,
            idOperacion: idOperacion,
            idProveedor: idProveedor,
            concepto: concepto,
            monto: montoFiltrado,
            tipoOperacion: pTipoOperacion,
            fechaP: fechaP,
            referenciaZona: referenciaZona
        },
        type: 'POST',
        cache: false,
        url: '../ajax/consultaCortes.php',
        success: function(response) {
            var obj = jQuery.parseJSON(response);
            jAlert(obj.Mensaje);
            if (obj.Estatus == 0) {
                $("#modalAclaracion").modal('hide');
                /*Reload DataTable*/
                var proveedor = $("#idProveedorP").val();
                var fecha = $("#fechaP").val();
                var corte = $("#idCorteP").val();
                verDetalle(proveedor, fecha, corte, 0, 0,0,'');
                /*Reload DataTable*/
            }
        }
    });
}

function actualizarAclaracion(idsOperacion, motivo) {
    $.ajax({
        data: {
            tipo: 10,
            idsOperacion: idsOperacion,
            motivo: motivo
        },
        type: 'POST',
        cache: false,
        url: '../ajax/consultaCortes.php',
        success: function(response) {
            var obj = jQuery.parseJSON(response);
            jAlert(obj.mensaje);
            if (obj.estatus == 0) {
                $("#modalAclaracion").modal('hide');
            }
        }
    });
}

function mostrarBotones() {
    $(".excel").fadeIn("normal");
}

function ocultarBotones() {
    $(".excel").hide();
}

function cerrar_corte_multiple(){
    /*$('[name="check_corte[]"]:checked').each(function(index, check ){
       console.log(check.value);
    })*/
    $("#modalConfirmacionCorte2").modal('hide');

    var proveedor = $("#select_proveedor option:selected").val();
    var fechaIni = $("#fecIni").val();
    var fechaFin = $("#fecFin").val();

    var indicador = true;
    var mensaje ='';
    if(proveedor==0){
        indicador=false;
        jAlert("Selecciona solo un proveedor");return;
    }
    
    var fechaI = new Date("'"+fechaIni+"'");
    var fechaF = new Date("'"+fechaFin+"'");
                
    var difM = fechaF - fechaI // diferencia en milisegundos
    var difD = difM / (1000 * 60 * 60 * 24) // diferencia en dias
              
    if(difD > 0){
        indicador=false;
        jAlert('No puedes cerrar cortes mayores a 1 dia');return;
    }

    if(indicador==true){
        $.ajax({
            data: {
                tipo: 12,
                proveedor: proveedor,
                fechaIni: fechaIni
            },
            type: 'POST',
            cache: false,
            url: '../ajax/consultaCortes.php',
            success: function(response) {
                var obj = jQuery.parseJSON(response);
                jAlert(obj.Mensaje);
                buscarDatos();
            }
        });
    }
}

function autorizar_corte_multiple(){
    $("#modalAutorizacion").modal('hide');

    var proveedor = $("#select_proveedor option:selected").val();
    var fechaIni = $("#fecIni").val();
    var fechaFin = $("#fecFin").val();

    var indicador = true;
    var mensaje ='';
    if(proveedor==0){
        indicador=false;
        jAlert("Selecciona solo un proveedor");return;
    }
    
    var fechaI = new Date("'"+fechaIni+"'");
    var fechaF = new Date("'"+fechaFin+"'");
                
    var difM = fechaF - fechaI // diferencia en milisegundos
    var difD = difM / (1000 * 60 * 60 * 24) // diferencia en dias
              
    if(difD > 0){
        indicador=false;
        jAlert('No puedes cerrar cortes mayores a 1 dia');return;
    }

    if(indicador==true){
        $.ajax({
            data: {
                tipo: 13,
                proveedor: proveedor,
                fechaIni: fechaIni
            },
            type: 'POST',
            cache: false,
            url: '../ajax/consultaCortes.php',
            success: function(response) {
                var obj = jQuery.parseJSON(response);
                jAlert(obj["sMensaje"],'ALERTA');
                buscarDatosTareas();
            }
        });
    }
}
