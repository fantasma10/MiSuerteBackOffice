

function initViewConsultaRutas(){
    var Layout = {
        buscaProveedores: function(){
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
        buscarProductos: function(){
            var familia = $("#select_familia").val();
            console.log(familia);
            $("#select_producto").empty();
            $.post("../ajax/consultaRutasProveedores.php", {tipo: 2, familia: familia},
            function(response){
                var obj = jQuery.parseJSON(response);
                $("#select_producto").append('<option value="">Todo</option>');
                if( obj !== null ){
                    jQuery.each(obj, function(index, value){
                        var id_prod = obj[index]["idProducto"];
                        var nombre_prod = obj[index]["descProducto"];
                        $("#select_producto").append('<option value="'+ id_prod +'">'+ nombre_prod +'</option>');
                    });
                }
            }).fail(function(response){ alert("Ha ocurrido un error, intente de nuevo."); })
        },
        initBotones: function(){
            $('#btn_ExportarRutasProveedoresExcel').on('click', function(e) {
                var unaopcion   = false;
                id_familia      = $("#select_familia").val();
                id_proveedor    = $('#select_proveedor').val();
                id_producto     = $("#select_producto").val();
                id_estatus      = $("#select_estatus").val();
                if (id_familia != '') { unaopcion = true; }
                if (unaopcion == false) {
                    jAlert('Seleccione al menos una opción');
                    return;
                } else {
                    $('#id_familia_excel').val(id_familia);
                    $('#id_proveedor_excel').val(id_proveedor);
                    $('#id_producto_excel').val(id_producto);
                    $('#id_estatus_producto').val(id_estatus);
                    $('#tipo').val(2);
                    $('#todoexcel').submit();
                }
            });
        }
    }

    Layout.buscaProveedores();
    Layout.buscarProductos();
    Layout.initBotones();
}

$("#btn_buscar_rutas").click(function() {
    var unaopcion = false;
    if ($('#select_familia').val() != '') {  unaopcion = true; }
    if ($('#select_proveedor').val() != '') {  unaopcion = true; }
    if ($('#select_producto').val() != '') {  unaopcion = true; }
    if (unaopcion == false){
        jAlert('Seleccione al menos una opción');
        return;
    }else{        
        buscarDatos();
    }
});

$("#select_familia").on('change', function(){
    console.log($(this).val());
    initViewConsultaRutas();
})


function buscarDatos() {

  
    var dataTableObj;
    var familia             = $("#select_familia option:selected").val();
    var proveedor           = $("#select_proveedor option:selected").val();
    var producto            = $("#select_producto option:selected").val();
    var estatus_producto    = $("#select_estatus option:selected").val();

    dataTableObj = $('#tabla_rutas_proveedores').dataTable({
        "iDisplayLength": 10,
        "bProcessing": true,
        "bPaginate": true,
        "bServerSide": false,
        "bFilter": true,
        "bDestroy": true,
        "sAjaxSource": "../ajax/consultaRutasProveedores.php",
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
                'aTargets': [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20],
                "bSortable": false
            },
            {
                "mData": 'FAMILIA',
                'aTargets': [0]
            },
            {
                "mData": 'ID_PROVEEDOR',
                'aTargets': [1]
            },
            {
                "mData": 'NOMBRE_COM_PROVEEDOR',
                'aTargets': [2],
                'sWidth': '90px'
            },
            {
                "mData": 'NOMBRE_PROVEEDOR',
                'aTargets': [3],
                'sWidth': '90px'
            },
            {
                "mData": 'ID_RUTA',
                'aTargets': [4],
                'sClass'  : 'align-right'
            },
            {
                "mData": 'RUTA',
                'aTargets': [5],
                'sClass'  : 'align-right'
            },
            {
                "mData": 'ID_PRODUCTO',
                'aTargets': [6],
                'sClass'  : 'align-right'
            },
            {
                "mData": 'PRODUCTO',
                'aTargets': [7],
                'sClass'  : 'align-right'
            },
            {
                "mData": 'ESTATUS_PRODUCTO',
                'aTargets': [8],
                'sClass'  : 'align-right'
            },
            {
                "mData": 'PORCENTAJE_USUARIO_MAX_POSIBLE',
                'aTargets': [9],
                'sClass'  : 'align-right'
            },
            {
                "mData": 'IMP_USUARIO_MAS_POSIBLE',
                'aTargets': [10],
                'sClass'  : 'align-right'
            },
            {
                "mData": 'PORCENTAJE_COBRO_PROVEEDOR',
                'aTargets': [11],
                'sClass'  : 'align-right'
            },
            {
                "mData": 'IMP_COBRO_PROVEEDOR',
                'aTargets': [12],
                'sClass'  : 'align-right'
            },
            {
                "mData": 'PORCENTAJE_PAGO_PROVEEDOR',
                'aTargets': [13],
                'sClass'  : 'align-right'
            },
            {
                "mData": 'IMP_PAGO_PROVEEDOR',
                'aTargets': [14],
                'sClass'  : 'align-right'
            },
            {
                "mData": 'SUMA_INGRESO_RED',
                'aTargets': [15],
                'sClass'  : 'align-right'
            },
            {
                "mData": 'MARGEN_MINIMO',
                'aTargets': [16],
                'sClass'  : 'align-right'
            },
            {
                "mData": 'MAXIMO_COMISION_RUTAS',
                'aTargets': [17],
                'sClass'  : 'align-right'
            },
            {
                "mData": 'PORCENTAJE_COMISION_CADENA',
                'aTargets': [18],
                'sClass'  : 'align-right'
            },
            {
                "mData": 'IMP_MAX_COMISION_CADENA',
                'aTargets': [19],
                'sClass'  : 'align-right'
            },
            {
                "mData": 'MARGEN_RED',
                'aTargets': [20],
                'sClass'  : 'align-right'
            },
        ],
        "fnDrawCallback": function() {
            mostrarBotones();
        },
        "fnServerParams": function(aoData) {
            var params = {};
            params['tipo']      = 1;
            params['familia']   = familia;
            params['proveedor'] = proveedor;
            params['producto']  = producto;
            params['estatus']   = estatus_producto;
            $.each(params, function(index, val) {
                aoData.push({ name: index, value: val });
            });
        },
    });

    $("#tabla_rutas_proveedores").css("display", "inline-table");
    $("#tabla_rutas_proveedores").css("width", "100%");  
}

function mostrarBotones() {
    $(".excel").fadeIn("normal");
}