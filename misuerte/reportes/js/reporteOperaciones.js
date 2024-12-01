function initView(){
	$("#txt_rfc").attr('style', 'text-transform: uppercase;');
        
	var Layout ={
		initBotones: function(){
			
	    	$("#btn_buscar").click(function(){
            	unaopcion = false;
            	if ($('#fecha1').val()!='' && $('#fecha2').val()!=''){unaopcion=true;}
				if ($('#fecha2').val() < $('#fecha1').val()){jAlert('La Fecha Final debe ser igual o mayor que la Fecha Inicial');return;}
    			if (unaopcion == false){
    				jAlert('Seleccione fechas');return;
  				}else{	
					buscarDatos();	    
				}   			
 			});
		}
	}

	Layout.initBotones();

}
	
function buscarDatos(){
	var dataTableObj;
	var fechaIni = $("#fecha1").val();
	var fechaFin = $("#fecha2").val();
	var metodoPago = $("#mPago").val();
	var mPago = document.getElementById("mPago");
        var textoMPago = mPago.options[mPago.selectedIndex].text;
        
	dataTableObj = $('#tabla_reporteOperaciones').dataTable({
        "iDisplayLength"  : 10,    //numero de columnas a desplegar
        "bProcessing"   : true,    // mensaje 
        "bServerSide"   : true,    //procesamiento del servidor
        "bFilter"       : true,    //no permite el filtrado caja de texto
        "bDestroy"      : true,    // reinicializa la tabla 
        "sAjaxSource"       : "ajax/reporteOperaciones.php", //ajax que consulta la informacion
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
        	'aTargets'  : [0,1,2,3,4,5,6,7,8,9,10],
        	"bSortable": false
        },
        {
        	"mData"   : 'FechaContable',
        	'aTargets'  : [0]
        },
        {
        	"mData"   : 'dFecSolicitud',
        	'aTargets'  : [1]
        },
        {
        	"mData"   : 'dFecConfirmacion',
        	'aTargets'  : [2]
        },
        {
        	"mData"   : 'sGameName',
        	'aTargets'  : [3]
        },
        {
        	"mData"   : 'metodo_pago',
        	'aTargets'  : [4]
        },
        {
        	"mData"   : 'nIdFolio',
        	'aTargets'  : [5]
        },
        {
        	"mData"   : 'nIdFolioVenta',
        	'aTargets'  : [6]
        },
        {
        	"mData"   : 'nMontoCargo',
        	'aTargets'  : [7]
        },
        {
        	"mData"   : 'nMontoRedencion',
        	'aTargets'  : [8]
        },
        {
        	"mData"   : 'nMonto',
        	'aTargets'  : [9]
        },
        {
                "mData"   : 'comision_pronosticos',
                'aTargets': [10]
        }

        ],
        "fnDrawCallback" : function(aoData) {
        	if(aoData._iRecordsDisplay > 0){
        		mostrarBotones();
        		$("#fecha1_excel").val(fechaIni);
        		$("#fecha2_excel").val(fechaFin);
                        $("#metodoPago").val(metodoPago);
                        $("#textoMPago").val(textoMPago);
            }else{
                ocultarBotones();
           	}
        },
       	"fnPreDrawCallback" : function() {   
        },
                
        "fnServerParams" : function (aoData){//Funcion que se activa al buscar infromacion en la tabla o cambiar de pagina aoData contiene l ainfo del datatable                
            var params = {};
           	params['tipo'] = 1; 
           	params['fechaIni'] =  fechaIni;
           	params['fechaFin']   =  fechaFin;
                params['metodoPago'] = metodoPago;
            $.each(params, function(index, val){
            	aoData.push({name : index, value : val });
            });
        },      
    });

	$("#tabla_reporteOperaciones").css("display", "inline-table");
	$("#tabla_reporteOperaciones").css("width", "100%");  
}

function mostrarBotones(){
    $(".excel").fadeIn("normal");
} 

function ocultarBotones(){
    $(".excel").hide();
} 