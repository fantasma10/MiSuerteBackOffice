var dataTableObj;
function initViewConsultaProducto(){
	var Layout = {
        
		buscaFamilia: function() {
            $("#select_familia").empty();
            if(jSonFamilia == undefined || jSonFamilia == null) {
                $.post("../ajax/altaProveedores.php", {tipo: 1},
                    function (response) {
                        var obj = jQuery.parseJSON(response);
                        $('#select_familia').append('<option value="0">Todo</option>');
                        if (obj !== null) {
                            jQuery.each(obj, function (index, value) {
                                var nombre_familia = obj[index]['descFamilia'];
                                $('#select_familia').append('<option value="' + obj[index]['idFamilia'] + '">' + nombre_familia + '</option>');
                            });
                        }
                    }
                ).fail(function (resp) {
                    alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
                })
            } else {
                $('#select_familia').append('<option value="0">Seleccione</option>');
                jSonFamilia.forEach(function(index, value){
                    var nombre_familia = index['descFamilia'];
                    $('#select_familia').append('<option value="' + index['idFamilia'] + '">' + nombre_familia + '</option>');
                });
            }
        },

        cargaEmisores: function() {
            if(jSonEmisor == undefined || jSonEmisor == null) {
                $.post("../ajax/altaProveedores.php", {tipo: 4},
                    function (response) {
                        var obj = jQuery.parseJSON(response);
                        $('#select_emisor').append('<option value="0">Seleccione</option>');
                        if (obj !== null) {
                            jQuery.each(obj, function (index, value) {
                                var nombre_emisor = obj[index]['descEmisor'];
                                $('#select_emisor').append('<option value="' + obj[index]['idEmisor'] + '">' + nombre_emisor + '</option>');
                            });
                        }
                    }
                ).fail(function (resp) {
                    alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
                })
            } else {
                $('#select_emisor').append('<option value="0">Seleccione</option>');
                jSonEmisor.forEach(function(index, value){
                    var nombre_emisor = index['descEmisor'];
                    $('#select_emisor').append('<option value="' + index['idEmisor'] + '">' + nombre_emisor + '</option>');
                });
            }
        },

        cargaFlujoImporte: function() {
            $("#select_flujo_importe").empty();
            if(jSonFlujoImporte == undefined || jSonFlujoImporte == null) {
                $.post("../ajax/altaProveedores.php", {tipo: 5},
                    function (response) {
                        var obj = jQuery.parseJSON(response);
                        $('#select_flujo_importe').append('<option value="-1">Seleccione</option>');
                        if (obj !== null) {
                            jQuery.each(obj, function (index, value) {
                                var nombre_flujo = obj[index]['descFlujo'];
                                $('#select_flujo_importe').append('<option value="' + obj[index]['idFlujo'] + '">' + nombre_flujo + '</option>');
                            });
                        }
                    }
                ).fail(function (resp) {
                    alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
                })
            } else {
                $('#select_flujo_importe').append('<option value="-1">Seleccione</option>');
                jSonFlujoImporte.forEach(function(index, value){
                    var nombre_flujo = index['descFlujo'];
                    $('#select_flujo_importe').append('<option value="' + index['idFlujo'] + '">' + nombre_flujo + '</option>');
                });
            }
        },

        buscaProductos:function(){



            var familia = $("#select_familia option:selected").val();
            var subfamilia = $("#select_subfamilia option:selected").val();
            var emisor = $("#select_emisor option:selected").val();
            var tipo_estado = $("#tipo_estado option:selected").val();

            // if(familia == undefined || familia == 0){familia = 0;}
            if(subfamilia == undefined || subfamilia == -1){subfamilia = 0;}
            // if(emisor == undefined || emisor == -1 || emisor == 0){emisor = 0;}

            // familia = parseInt(familia);
            // subfamilia = parseInt(subfamilia);
            // emisor = parseInt(emisor);

            // console.log("fam: "+familia+" subfamilia: "+subfamilia+" emisor: "+emisor);
            tipo_busqueda = 0;
            
            if(familia == 0 && subfamilia ==0 && emisor==0){
                tipo_busqueda = 0;  //busca todo
            }
            if(familia>0 && subfamilia>0 && emisor>0){
                tipo_busqueda = 1;  //busca por los tres parametros
            }
            if(familia > 0 && subfamilia >0 && emisor==0){
                tipo_busqueda = 2; //busca por familia y subfamilia
            }
            if(familia == 0 && subfamilia ==0 && emisor>0){
                tipo_busqueda = 3; //busca por emisor
            }
            if(familia > 0 && subfamilia ==0 && emisor==0){
                tipo_busqueda = 4; //busca por emisor
            }

            if(dataTableObj != undefined) {
                dataTableObj.dataTableSettings[0].jqXHR.abort();
            }

            dataTableObj = $('#tabla_productos').dataTable({          
               "iDisplayLength"  : 10,  //numero de columnas a desplegar
                "bProcessing"   : true,     // mensaje 
                "bServerSide"   : false,    //procesamiento del servidor
                "bFilter"     : true,       //no permite el filtrado caja de texto
                "bDestroy": true,           // reinicializa la tabla 
                "sAjaxSource"       : "../ajax/consultaProducto.php", //ajax que consulta la informacion
                "sServerMethod"     : 'POST', //Metodo para enviar la informacion
                "oLanguage"         : {
                    "sLengthMenu"       : "Mostrar _MENU_",
                    "sZeroRecords"      : "No se ha encontrado información",
                    "sInfo"             : "Mostrando _START_ a _END_ de _TOTAL_ Registros",
                    "sInfoEmpty"        : "Mostrando 0 a 0 de 0 Registros",
                    "sInfoFiltered"     : "(filtrado de _MAX_ total de Registros)",
                    "sProcessing"       : '<div id="loaderEmisor" class="loaderEmisor"><div id="loader" class="loader"></div></div>',
                    "sSearch"           : "Buscar",
                    "oPaginate"         : {
                        "sPrevious"     : "Anterior", // This is the link to the previous page
                        "sNext"         : "Siguiente"
                    }
                },
                "aoColumnDefs"    : [ //Desplegado de informacion  target es la posicion en la que viene en la respuesta
                    {
                        'aTargets'  : [0,1,2,3,4,5],
                        "bSortable": false
                    },
                    {
                        "mData"   : 'idProducto',
                        'aTargets'  : [0]
                    },
                    {
                        "mData"   : 'descProducto',
                        'aTargets'  : [1]
                    },
                    {
                        "mData"   : 'idFevProducto',
                        'aTargets'  : [2],
                        'bVisible'  : false
                    },
                    {
                        "mData"   : 'idFsvProducto',
                        'aTargets'  : [3],
                        'bVisible'  : false
                    },
                    {
                        "mData"   : 'skuProducto',
                        'aTargets'  : [4]
                    },
                    {
                        "mData"   : 'EstatusProducto',
                        'aTargets'  : [5]
                    },
                    {
                        "mData"   : 'idProducto',
                        'aTargets'  : [6],
                        mRender: function(data, type, row){
                            boton_desactivar="";
                            if(ID_PERFIL == 1 ){
                                if(row.idEstatusProducto == 0 ){
                                    boton_desactivar = '<button id="confirmacionDesactivarProducto" data-id='+row.idProducto+' data-name="'+row.descProducto+'" data-placement="top" rel="tooltip" title="Inhabilitar Producto"  data-toggle="modal"  data-target="#confirmacion" class="btn inhabilitar btn-default btn-xs" data-title="Editar Informacion"><span class="fa fa-times"></span></button>'
                                }else{
                                    boton_desactivar = '<button id="confirmacionActivarProducto" data-id='+row.idProducto+' data-name="'+row.descProducto+'" data-placement="top" rel="tooltip" title="Habilitar Producto" data-toggle="modal" data-target="#confirmacion" class="btn habilitar btn-primary btn-xs" data-title="Editar Informacion"><span class="fa fa-check"></span></button>'
                                }
                            }
                            boton_edit='<button id="confirmacionDesactivarProveedor" onclick="editarProducto('+row.idProducto+');" data-placement="top" rel="tooltip" title="Ver Informacion" class="btn habilitar btn-default btn-xs" data-title="Ver Informacion"><span class="fa fa-search"></span></button>';
                            return boton_desactivar+boton_edit;
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
                    params['familia']  =  familia;
                    params['subfamilia'] =  subfamilia;
                    params['emisor']   =  emisor;
                    params['tipo_busqueda'] = tipo_busqueda;
                    params['tipo_estado'] = tipo_estado;
                    
                    $.each(params, function(index, val){
                        aoData.push({name : index, value : val });
                    });
                }   
            });

            $("#tabla_productos").css("display", "inline-table");
            $("#tabla_productos").css("width", "100%");   
        },

        initBotones: function(){
            $('#btn_buscar_reporte_productos').on("click", function(){
                Layout.buscaProductos();             
            });
        }
	}//Layout

    Layout.initBotones();
    $('#btn_buscar_reporte_productos').click();
    Layout.buscaFamilia();
    Layout.cargaEmisores();
    Layout.cargaFlujoImporte();
} // initViewAltaProducto

function BuscarSubFamilias(value){ //buscador de subfamilias
    $('#select_subfamilia').empty();
    var idFamilia = value;
    $.ajax({
            data:{
              tipo : 2,
              idFamilia: idFamilia
            },
            type: 'POST',
            cache: false,
            url: '../ajax/altaProveedores.php',
            success: function(response){                
                var obj = jQuery.parseJSON(response);
                $('#select_subfamilia').append('<option value="-1">Seleccione</option>');
                jQuery.each(obj,function(index,value){
                    var nombre_subfamilia = obj[index]['descSubFamilia'];
                    $('#select_subfamilia').append('<option value="'+obj[index]['idSubFamilia']+'">'+nombre_subfamilia+'</option>');
                });
            }
    });
}

function editarProducto(idProducto){
    var formProveedor = '<form action="altaProducto.php"  method="POST" id="formProducto"><input type="text" id="txtidProducto"  name="txtidProducto" value="'+idProducto+'"/></form>'  
    $('body').append(formProveedor);
    $( "#formProducto" ).submit();
}

$(document).on('click', '#confirmacionDesactivarProducto',function (e) {//pasa datos al modal para desactivar el Producto
    var id = $(this).data("id");
    $("#idProducto").val(id);
    $("#estatusProducto").val(2);
    $('#confirmacion p').empty();
    var nombre = $(this).data("name");
    var texto = "Desea <strong>Desactivar</strong> este producto: " +nombre;
    $('#confirmacion p').append(texto);
});

$(document).on('click', '#confirmacionActivarProducto',function (e) {//pasa datos al modal para activa el Producto
    var id = $(this).data("id");
    $("#idProducto").val(id);
    $("#estatusProducto").val(0);
    $('#confirmacion p').empty();
    var nombre = $(this).data("name");
    var texto = "Desea <strong>Activar</strong> este producto: " +nombre;
    $('#confirmacion p').append(texto);
});

$(document).on('click', '#desactivarProducto',function (e) {//activa o desactiva el Producto
    var $this = $(this);
    $this.button('loading');
    id = $("#idProducto").val();
    estatus = $("#estatusProducto").val();
    $.post("/_Proveedores/proveedor/ajax/consultaProducto.php",{
            idProducto : id,
            estatus : estatus,
            tipo: 6
        },
        function(response){
            var obj = jQuery.parseJSON(response);
            if(obj.showMessage == 0){
                //console.log(obj.msg);
                $('#confirmacion').modal('hide');
                $this.button('reset');
                jAlert(obj.msg,"Producto", function () {
                    $('#btn_buscar_reporte_productos').click();
                });
                //setTimeout("$('#btn_buscar_reporte_productos').click();", 2000);
            }else{
                $('#confirmacion').modal('hide');
                $this.button('reset');
                jAlert(obj.msg,"Producto", function () {
                    $('#btn_buscar_reporte_productos').click();
                });
                //setTimeout("$('#btn_buscar_reporte_productos').click();", 2000);
            }
        }).fail(function(response){
            $("#desactivarProducto").button('reset');
            alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');

    })
});

$('#confirmacion').on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset');
})
