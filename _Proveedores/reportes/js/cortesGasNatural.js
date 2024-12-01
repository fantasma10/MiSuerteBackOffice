
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
                        $("#select_proveedor option[value='27']").attr("selected",true);
                        
                    }
                }
                ).fail(function(resp) { alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde'); })
        },
        initBotones: function() {
            $('#btn_ExportarCorteGNExcel').on('click', function(e) {
                var unaopcion = false;
                id_proveedor = $('#select_proveedor').val();
                fecha1 = $('#fecIni').val();
                fecha2 = $('#fecFin').val();
                fechaTipo = $('#select-tipo-fecha').val();
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
                    $('#tipo').val(fechaTipo);
                    //$('#todoexcel').submit();
                }
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
        "sAjaxSource": "../ajax/cortesGasNatural.php",
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
                'aTargets': [0, 1, 2, 3, 4, 5, 6, 7,8,9,10,11],
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
                "mData": 'sNombreProducto',
                'aTargets': [4]
            },         
            {
                "mData": 'nZona',
                'aTargets': [5]
            },            
            {
                "mData": 'sNombreZona',
                'aTargets': [6]
            },
            {
                "mData": 'sClabe',
                'aTargets': [7]                
            },
            {
                "mData": 'nTotalOperaciones',
                'aTargets': [8]
            },
            {
                "mData": 'nTotalMonto',
                'aTargets': [9]
            },
            {
                "mData": 'nTotalComision',
                'aTargets': [10]
            },
            {
                "mData": 'nTotalPago',
                'aTargets': [11]
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

            for (var i = 0; i < data.length; i++) {
                totOpe = totOpe + parseFloat(data[i]['nTotalOperaciones']);
                totMonto = totMonto + parseFloat(data[i]['nTotalMonto2']);
                totCom = totCom + parseFloat(data[i]['nTotalComision2']);
                totPago = totPago + parseFloat(data[i]['nTotalPago2']);
            }  
                 
            if(data.length>0){                
                $("#footDetalle").show();                
                var options = {minimumFractionDigits:2}
                $(tfoot).find('td').eq(0).html("<strong>TOTAL</strong>");
                $(tfoot).find('td').eq(1).html(totOpe.toLocaleString("en-US"));
                $(tfoot).find('td').eq(2).html("$"+totMonto.toLocaleString("en-US",options));
                $(tfoot).find('td').eq(3).html("$"+totCom.toLocaleString("en-US",options));
                $(tfoot).find('td').eq(4).html("$"+totPago.toLocaleString("en-US",options));  
            }else{
                $("#footDetalle").hide();
            }         
        },
        "fnPreDrawCallback": function() {},
        "fnServerParams": function(aoData) {
            var params = {};
            params['tipo'] = 1;
            params['proveedor'] = proveedor;
            params['fechaIni'] = fechaIni;
            params['fechaFin'] = fechaFin;
            params['fechaTipo'] = fechaTipo;
            $.each(params, function(index, val) {
                aoData.push({ name: index, value: val });
            });
        }
    });

    $("#tabla_proveedores").css("display", "inline-table");
    $("#tabla_proveedores").css("width", "100%");  
}

function mostrarBotones() {
    $(".excel").fadeIn("normal");
}

function ocultarBotones() {
    $(".excel").hide();
}