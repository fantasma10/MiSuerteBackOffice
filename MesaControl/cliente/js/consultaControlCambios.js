$(document).ready(function(){
    var configDataTable = {
        "iDisplayLength": 50, 	//numero de columnas a desplegar
        "bProcessing": true, 	// mensaje
        "bServerSide": false, 	//procesamiento del servidor
        "bFilter": true, 		//no permite el filtrado caja de texto
        "bDestroy": true, 			// reinicializa la tabla
        "sAjaxSource": "/MesaControl/cliente/ajax/consultaControlCambios.php", //ajax que consulta la informacion
        "sServerMethod": 'POST', //Metodo para enviar la informacion
        //"aaSorting"     : [[0, 'desc']], //Como se sorteara la informacion numero de columna y tipo
        "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_",
            "sZeroRecords": "No se ha encontrado información",
            "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ Registros",
            "sInfoEmpty": "Mostrando 0 a 0 de 0 Registros",
            "sInfoFiltered": "(filtrado de _MAX_ total de Registros)",
            "sProcessing": "<img src='" + BASE_PATH + "/img/cargando3.gif'> Loading...",
            "sSearch": "Buscar",
            "oPaginate": {
                "sPrevious": "Anterior", // This is the link to the previous page
                "sNext": "Siguiente"
            }
        },
        "aoColumnDefs": [ //Desplegado de informacion  target es la posicion en la que viene en la respuesta
            {
                'aTargets': [0, 1, 2, 3, 4],
                "bSortable": false,
            },
            {
                "mData": 'nIdCliente',
                'aTargets': [0]
            },
            {
                "mData": 'RFC',
                'aTargets': [1]
            },
            {
                "mData": 'RazonSocial',
                'aTargets': [2],
                mRender: function (data, type, row) {
                    if (row.RazonSocial == "") {
                        return row.NombreCliente;
                    }
                    return row.RazonSocial;
                }
            },
            {
                "mData": 'idEstatus',
                'aTargets': [3],
                "bVisible": false
            },
            {
                "mData"   : 'nIdCliente',
                'aTargets'  : [4],
                'sClass'  	: 'center',
                mRender: function(data, type, row){
                    boton_edit='<button onclick="editarCliente('+row.nIdCliente+', \'' +row.RazonSocial+ '\')"  data-placement="top" rel="tooltip" title="Revisar cambios" class="btn habilitar btn-default btn-xs" data-title="Revisar cambios"><span class="fa fa-edit"></span></button>';

                    botones = "<center>"+boton_edit+"</center>";
                    return botones;
                }
            },
        ],
        "fnServerParams": function (aoData) {//Funcion que se activa al buscar informacion en la tabla o cambiar de pagina aoData contiene la info del datatable
            var params = {};
            params['tipo'] = 1;
            params['perfil'] = ID_PERFIL;
            $.each(params, function (index, val) {
                aoData.push({ name: index, value: val });
            });
        }
    }

    $('#tabla_clientes').dataTable(configDataTable);

})

function editarCliente(idCliente, razonSocial) {
    var prealta = 2;
    var formCliente = '<form action="afiliacionCliente.php" method="post" id="formCliente" class="hidden">' +
        '<input type="text" name="txtidCliente"  value="' + idCliente + '"/>' +
        '<input type="text" name="txtRazonSocial" value="' + razonSocial + '"/>' +
        '<input type="text" name="prealta" value="' + prealta + '">' +
        '</form>'
    $('body').append(formCliente);
    $("#formCliente").submit();
}