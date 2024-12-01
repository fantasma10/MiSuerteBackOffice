function initViewConsultaCorte(){
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
        }
	}//Layout

	Layout.buscaProveedores();
} // initViewAltaProducto





 $("#btn_buscar_cortes").click(function(){
    buscarDatos();
 });

 function buscarDatos(){
            var dataTableObj;
            var proveedor = $("#select_proveedor option:selected").val();
            var fechaIni = $("#fecIni").val();
            var fechaFin = $("#fecFin").val();

            tipo_busqueda = 0;
            
            if(proveedor == 0 && fechaIni.length>0 && fechaFin.length>0){
                tipo_busqueda = 0;  //fechas
            }
            if(proveedor > 0 && fechaIni.length>0 && fechaFin.length>0){
                tipo_busqueda = 1;  //todos los campos
            }

            dataTableObj = $('#tabla_productos').dataTable({          
               "iDisplayLength"  : 10,  //numero de columnas a desplegar
                "bProcessing"   : true,     // mensaje 
                "bServerSide"   : false,    //procesamiento del servidor
                "bFilter"     : true,       //no permite el filtrado caja de texto
                "bDestroy": true,           // reinicializa la tabla 
                "sAjaxSource"       : "../ajax/consultaCortes.php", //ajax que consulta la informacion
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
                        'aTargets'  : [0,1,2,3,4],
                        "bSortable": false
                    },
                    {
                        "mData"   : 'nIdProveedor',
                        'aTargets'  : [0]
                    },
                    {
                        "mData"   : 'nombreProveedor',
                        'aTargets'  : [1]
                    },
                    {
                        "mData"   : 'nTotalOperaciones',
                        'aTargets'  : [2]
                    },
                    {
                        "mData"   : 'nTotalMonto',
                        'aTargets'  : [3]
                    },
                    {
                        "mData"   : 'nTotalComision',
                        'aTargets'  : [4]
                    }
                ],
                "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                },
                "fnPreDrawCallback" : function() {            
                },
                "fnDrawCallback" : function(aoData) {                   
                },
                "fnServerParams" : function (aoData){//Funcion que se activa al buscar infromacion en la tabla o cambiar de pagina aoData contiene l ainfo del datatable                
                    var params = {};
                    params['tipo'] =  2;
                    params['proveedor']  =  proveedor;
                    params['fechaIni'] =  fechaIni;
                    params['fechaFin']   =  fechaFin;
                    params['tipo_busqueda'] = tipo_busqueda;
                    $.each(params, function(index, val){
                        aoData.push({name : index, value : val });
                    });
                },   
            });

            $("#tabla_productos").css("display", "inline-table");
            $("#tabla_productos").css("width", "100%");   
        
 }

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