$( document ).ready(function() {
	
//cargaemisoresdt();
//emisor,receptor,integrador,preemisor
if(valorconsulta == 1){cargarintegradores();} 
if(valorconsulta == 2){cargarpreemisores();} 
if(valorconsulta == 3){cargarproveedor();} //receptores por post


$('#closepdf').click(function(){$('#pdfvisor').css('display','none')});
var x = 0;

$("#nombreComercial").alphanum({
	allow				: '-',
	allow				: '.',
	allowNumeric		: true,
	allowOtherCharSets	: true,
	maxLength			: 50
});
$("#beneficiario").alphanum({
	allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1',
	allowNumeric		: false,
	allowOtherCharSets	: false,
	maxLength			: 100
});

$("#telefono").prop('maxlength', 10);
$('#telefono').mask('(00) 0000-0000');

$("#correo").alphanum({
	allow				: '-.@_',
	allowNumeric		: true,
	allowOtherCharSets	: false,
	maxLength			: 120
});

$("#comision").prop('maxlength', 6);
$("#comision").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : true,
	allowLeadingSpaces  : false
});


$("#liquidacion").prop('maxlength', 6);
$("#liquidacion").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : false,
	allowLeadingSpaces  : false
});

$("#perComision").prop('maxlength', 6);
$("#perComision").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : true,
	allowLeadingSpaces  : false
});


$("#clabe").prop('maxlength', 18);
$("#clabe").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : false,
	allowLeadingSpaces  : false
});

$("#referencia").prop('maxlength', 10);
$("#referencia").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : false,
	allowLeadingSpaces  : false
});

$("#referenciaAlfa").alphanum({
	allow				: '-',
	allowNumeric		: true,
	allowOtherCharSets	: false,
	maxLength			: 20
});

$("#nombreComercialCadena").alphanum({
	allow				: '-',
	allow				: '.',
	allowNumeric		: true,
	allowOtherCharSets	: true,
	maxLength			: 50
});
$("#beneficiarioCadena").alphanum({
	allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1',
	allowNumeric		: false,
	allowOtherCharSets	: false,
	maxLength			: 100
});

$("#telefonoCadena").prop('maxlength', 10);
$('#telefonoCadena').mask('(00) 0000-0000');

$("#correoCadena").alphanum({
	allow				: '-.@_',
	allowNumeric		: true,
	allowOtherCharSets	: false,
	maxLength			: 120
});


$("#comisionCadena").prop('maxlength', 6);
$("#comisionCadena").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : true,
	allowLeadingSpaces  : false
});


$("#liquidacionCadena").prop('maxlength', 6);
$("#liquidacionCadena").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : false,
	allowLeadingSpaces  : false
});

$("#perComisionCadena").prop('maxlength', 6);
$("#perComisionCadena").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : true,
	allowLeadingSpaces  : false
});


$("#clabeCadena").prop('maxlength', 18);
$("#clabe").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : false,
	allowLeadingSpaces  : false
});

$("#referenciaCadena").prop('maxlength', 10);
$("#referencia").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : false,
	allowLeadingSpaces  : false
});

$("#referenciaAlfaCadena").alphanum({
	allow				: '-',
	allowNumeric		: true,
	allowOtherCharSets	: false,
	maxLength			: 20
});


$('input[name="entrega"]').change(function(){

	if($('input[name=entrega]:checked').val() == '1000'){

		document.getElementById("datosFtp").style.display="none";
		$("#host").val("");
		$("#port").val(0);
		$("#user").val("");
		$("#password").val("");
		$("#remoteFolder").val("");


	}else{

		document.getElementById("datosFtp").style.display="inline-block";

	}
});


//emisor,receptor,integrador,preemisor
//Switcheo de tablas

$("#emisor").on('click',function () {
    cargaremisoresss();
});

$("#receptor").on('click',function () {
     cargarreceptores();
	});

$("#integrador").on('click',function () {

      cargarintegradores();
	});


$("#preemisor").on('click',function () {
  /*$("#reportesubemisorpdf").attr("onclick","verreporte(4)");
  $("#reportesubemisorxls").attr("onclick","descargaexcel(4)");
  $("#reportesubemisorpdf").text("SubEmisores PDF");
  $("#reportesubemisorxls").text("SubEmisores Excel")

  cargarsubemisores();*/
  cargarpreemisores();
	});

$("#proveedor").on('click',function () {
		cargarproveedor();
	});

});



////////varaiables////

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

//var tablaEmisor = "";


////////////////////////////////////////////////////






function cargaremisoresss(){
        $('#ordertablaE tbody').empty();
	var clase = $("#emisor").hasClass("active").toString();
	if(clase != "true"){
          // quitar la clase activa a lso demas boton y dejarla solo al boton seleccionado
		$("#emisor").addClass("active");
		$("#receptor").removeClass("active");
       /* $("#integrador").removeClass("active");
        $("#preemisor").removeClass("active");*/

		//document.getElementById("cadenaInfo").style.display="none";

        var tablaEmisor = $("#ordertablaE").DataTable();
		tablaEmisor.fnDestroy();
		var tablaReceptor = $("#ordertablaR").DataTable();
		tablaReceptor.fnDestroy();
        /*var tablaIntegrador = $("#ordertablaI").DataTable();
		tablaIntegrador.fnDestroy();
         var tablaPreemisor = $("#ordertablaP").DataTable();
        tablaPreemisor.fnDestroy();*/


		cargaemisoresdt();

        //alert('calbaza emisor');
		$( "#receptor" ).prop( "checked", false );
       /* $( "#integrador" ).prop( "checked", false );
         $( "#preemisor" ).prop( "checked", false );*/

		tabla="#ordertablaE #E tr";

		document.getElementById("ordertablaR").style.display="none";
       /* document.getElementById("ordertablaI").style.display="none";
        document.getElementById("ordertablaP").style.display="none";*/

		document.getElementById("tablaEmisores").style.display="inline";
		document.getElementById("tablaReceptores").style.display="none";
        /*document.getElementById("tablaIntegradores").style.display="none";
        document.getElementById("tablaPreemisores").style.display="none";*/

		document.getElementById("ordertablaE").style.width="100%";
		document.getElementById("ordertablaE").style.display="inline-table";
	}
}

function cargarreceptores(){
	var clase = $("#receptor").hasClass("active").toString();
	if(clase != "true"){
    $('#ordertablaR tbody').empty();
    $("#receptor").addClass("active");
		$("#emisor").removeClass("active");
        /*$("#integrador").removeClass("active");
        $("#preemisor").removeClass("active");*/

		//document.getElementById("emisorInfo").style.display="none";
    $( "#emisor" ).prop( "checked", false );
   /* $( "#integrador" ).prop( "checked", false );
    $( "#preemisor" ).prop( "checked", false );*/

		$( "#emisor" ).prop( "checked", false );
        /*$( "#integrador" ).prop( "checked", false );
         $( "#preemisor" ).prop( "checked", false );*/

       var tablaEmisor = $("#ordertablaE").DataTable();
		tablaEmisor.fnDestroy();
		var tablaReceptor = $("#ordertablaR").DataTable();
		tablaReceptor.fnDestroy();
        /*var tablaIntegrador = $("#ordertablaI").DataTable();
		tablaIntegrador.fnDestroy();
         var tablaPreemisor = $("#ordertablaP").DataTable();
        tablaPreemisor.fnDestroy();*/

    cargareceptoresdt();
    //alert('calbaza receptor');
		tabla="#ordertablaR #R tr";
		document.getElementById("ordertablaE").style.display="none";
        /*document.getElementById("ordertablaI").style.display="none";
        document.getElementById("ordertablaP").style.display="none";*/

		document.getElementById("tablaEmisores").style.display="none";
		document.getElementById("tablaReceptores").style.display="inline";
        /*document.getElementById("tablaIntegradores").style.display="none";
        document.getElementById("tablaPreemisores").style.display="none";*/

		document.getElementById("ordertablaR").style.display="inline-table";
		document.getElementById("ordertablaR").style.width="100%";
	}

}

function cargarintegradores(){
  // alert('calbaza integrador');
  var clase = $("#integrador").hasClass("active").toString();
  if(clase != "true"){
    $("#ordertablaIntegradores tbody").empty();
    $("#integrador").addClass("active");
    /*$("#emisor").removeClass("active");
    $("#receptor").removeClass("active");*/
	$("#preemisor").removeClass("active");
	$("#proveedor").removeClass("active");

    //document.getElementById("emisorInfo").style.display="none";
    /*$( "#emisor" ).prop( "checked", false );
	$( "#receptor" ).prop( "checked", false );*/
	$("#preemisor" ).prop( "checked", false );
    $("#proveedor" ).prop( "checked", false );

    /*var tablaEmisor = $("#ordertablaE").DataTable();
    tablaEmisor.fnDestroy();
    var tablaReceptor = $("#ordertablaR").DataTable();
    tablaReceptor.fnDestroy();*/
    var tablaIntegrador = $("#ordertablaIntegradores").DataTable();
    tablaIntegrador.fnDestroy();
    var tablaPreemisor = $("#ordertablaPreemisores").DataTable();
    tablaPreemisor.fnDestroy();
	var tablaProveedor = $("#ordertablaProveedores").DataTable();
	tablaProveedor.fnDestroy();
	
    cargaintegradoresdt();

    tabla="#ordertablaIntegradores #I tr";
    /*document.getElementById("ordertablaE").style.display="none";
    document.getElementById("ordertablaR").style.display="none";*/
   

    /*document.getElementById("tablaEmisores").style.display="none";
    document.getElementById("tablaReceptores").style.display="none";*/
    document.getElementById("tablaIntegradores").style.display="inline";
	document.getElementById("tablaPreemisores").style.display="none";
	document.getElementById("tablaProveedores").style.display="none";

	document.getElementById("ordertablaProveedores").style.display="none";
	document.getElementById("ordertablaPreemisores").style.display="none";
    document.getElementById("ordertablaIntegradores").style.display="inline-table";
    document.getElementById("ordertablaIntegradores").style.width="100%";
	}
}

function cargarpreemisores(){
  /*$("#reportesubemisorpdf").attr("onclick","verreporte(5)");
  $("#reportesubemisorxls").attr("onclick","descargaexcel(5)");
  $("#reportesubemisorpdf").text("Por Aurotizar PDF");
  $("#reportesubemisorxls").text("Por Autorizar Excel")*/

  
	var clase = $("#preemisor").hasClass("active").toString();
	if(clase != "true"){
		$("#ordertablaPreemisores tbody").empty();
		$("#integrador").removeClass("active");
		$("#proveedor").removeClass("active");
		/*$("#emisor").removeClass("active");
        $("#receptor").removeClass("active");*/
        $("#preemisor").addClass("active");

		//document.getElementById("emisorInfo").style.display="none";

		/*$( "#emisor" ).prop( "checked", false );
        $( "#receptor" ).prop( "checked", false );*/
		$("#integrador" ).prop( "checked", false );
		$("#proveedor" ).prop( "checked", false );



        /*var tablaEmisor = $("#ordertablaE").DataTable();
		tablaEmisor.fnDestroy();
		var tablaReceptor = $("#ordertablaR").DataTable();
		tablaReceptor.fnDestroy();*/
        var tablaIntegrador = $("#ordertablaIntegradores").DataTable();
		tablaIntegrador.fnDestroy();
         var tablaPreemisor = $("#ordertablaPreemisores").DataTable();
		tablaPreemisor.fnDestroy();
		var tablaProveedor = $("#ordertablaProveedores").DataTable();
        tablaProveedor.fnDestroy();

        cargapreemisoresdt();

		tabla="#ordertablaPreemisores #P tr";

		/*document.getElementById("ordertablaE").style.display="none";
		document.getElementById("ordertablaR").style.display="none";*/
		
		document.getElementById("tablaIntegradores").style.display="none";
		document.getElementById("tablaPreemisores").style.display="inline";
		document.getElementById("tablaProveedores").style.display="none";
		
        document.getElementById("ordertablaIntegradores").style.display="none";
		document.getElementById("ordertablaProveedores").style.display="none";
		document.getElementById("ordertablaPreemisores").style.display="inline-table";
		document.getElementById("ordertablaPreemisores").style.width="100%";
  

    /*cargapreemisores();

		tabla="#ordertablaP #P tr";
    $("#ordertablaE").css("display","none");
    $("#ordertablaR").css("display","none");
    $("#ordertablaI").css("display","none");
		$("#ordertablaP").css("display","none");

    $("#tablaEmisores").css("display","none");
    $("#tablaReceptores").css("display","none");
    $("#tablaIntegradores").css("display","none");
		$("#tablaPreemisores").css("display","none");
    $("#tablaPreemisores").css("display","inline");

    $("#ordertablaP").css("display","inline-table");
    $("#ordertablaP").css("width","100%");*/
	//}
}
}

function cargarproveedor(){
		 // alert('calbaza integrador');
		 var clase = $("#proveedor").hasClass("active").toString();
		 if(clase != "true"){
			 $("#ordertablaProveedores tbody").empty();
			 $("#proveedor").addClass("active");
			 /*$("#emisor").removeClass("active");
			 $("#receptor").removeClass("active");*/
		 	$("#preemisor").removeClass("active");
		 	$("#integrador").removeClass("active");
	 
			 //document.getElementById("emisorInfo").style.display="none";
			 /*$( "#emisor" ).prop( "checked", false );
		 $( "#receptor" ).prop( "checked", false );*/
		 	$("#preemisor" ).prop( "checked", false );
			 $("#integrador" ).prop( "checked", false );
	 
			 /*var tablaEmisor = $("#ordertablaE").DataTable();
			 tablaEmisor.fnDestroy();
			 var tablaReceptor = $("#ordertablaR").DataTable();
			 tablaReceptor.fnDestroy();*/
			 var tablaIntegrador = $("#ordertablaIntegradores").DataTable();
			 tablaIntegrador.fnDestroy();
			 var tablaPreemisor = $("#ordertablaPreemisores").DataTable();
			 tablaPreemisor.fnDestroy();
			var tablaProveedor = $("#ordertablaProveedores").DataTable();
			tablaProveedor.fnDestroy();
		 
			 //cargaintegradoresdt();
			 cargarproveedoresdt();
	 
			 tabla="#ordertablaProveedores #I tr";
			 /*document.getElementById("ordertablaE").style.display="none";
			 document.getElementById("ordertablaR").style.display="none";*/
			
	 
			 /*document.getElementById("tablaEmisores").style.display="none";
			 document.getElementById("tablaReceptores").style.display="none";*/
			 document.getElementById("tablaIntegradores").style.display="none";
		 	document.getElementById("tablaPreemisores").style.display="none";
		 	document.getElementById("tablaProveedores").style.display="inline";
	 
		 	document.getElementById("ordertablaIntegradores").style.display="none";
		 	document.getElementById("ordertablaPreemisores").style.display="none";
			 document.getElementById("ordertablaProveedores").style.display="inline-table";
			 document.getElementById("ordertablaProveedores").style.width="100%";
		 }
}

/* no se usa*/
function cargarsubemisores(){
	var clase = $("#proveedor").hasClass("active").toString();
	if(clase != "true"){
		$("#proveedor").addClass("active");
		/*$("#emisor").removeClass("active");
        $("#receptor").removeClass("active");*/
		$("#preemisor").removeClass("active");
		$("#integrador").removeClass("active");

		//document.getElementById("emisorInfo").style.display="none";


		/*$( "#emisor" ).prop( "checked", false );
        $( "#receptor" ).prop( "checked", false );*/
        $("#preemisor" ).prop( "checked", false );
		$("#integrador" ).prop( "checked", false );



       /*var tablaEmisor = $("#ordertablaE").DataTable();
		tablaEmisor.fnDestroy();
		var tablaReceptor = $("#ordertablaR").DataTable();
		tablaReceptor.fnDestroy();*/
        var tablaIntegrador = $("#ordertablaIntegradores").DataTable();
		tablaIntegrador.fnDestroy();
         var tablaPreemisor = $("#ordertablaPreemisores").DataTable();
        tablaPreemisor.fnDestroy();
		var tablaProveedor = $("#ordertablaProveedores").DataTable();
        tablaProveedor.fnDestroy();

		cargaintegradoresdt();


		tabla="#ordertablaIntegradores #I tr";
		/*document.getElementById("ordertablaE").style.display="none";
        document.getElementById("ordertablaR").style.display="none";*/
		document.getElementById("tablaIntegradores").style.display="none";
		document.getElementById("tablaPreemisores").style.display="none";
		document.getElementById("tablaProveedores").style.display="inline";
	
		document.getElementById("ordertablaProveedores").style.display="inline-table";
		document.getElementById("ordertablaPreemisores").style.display="none";
		document.getElementById("ordertablaIntegradores").style.display="none";
		document.getElementById("ordertablaIntegradores").style.width="100%";
	}
}
/* no se usa*/
function cargasubemisores(){
  $.post("../../../paycash/ajax/Afiliacion/consultaClientes.php",{
    tipo:16
  },function(response){
    var obj = jQuery.parseJSON(response);

    jQuery.each(obj, function(index,value){
      estatus   =   obj[index]['estatus'];
      nombre    =   obj[index]['nombre'];

      if (ID_PERFIL == 1 || ID_PERFIL == 5) {
        if (estatus == 0) {
          boton = '<button id="confirmacionBorradoSubEmisor" data-placement="top" rel="tooltip" title="Inhabilitar SubEmisor" data-toggle="modal" data-target="confirmacion" class="btn inhabilitar btn-default btn-xs" data-id='+obj[index]['id']+' data-name="'+nombre+'" data-title="Editar Informacion"><span class="fa fa-times"></span></button>';
        }else {
          boton = '<button id="confirmacionHabilitarSubEmisor" data-placement="top" rel="tooltip" title="Habilitar SubEmisor" data-toggle="modal" data-target="#confirmacion" class="btn habilitar btn-primary btn-xs" data-id='+obj[index]['id']+' data-name="'+nombre+'" data-title="Editar Informacion"><span class="fa fa-check"></span></button>'
        }
      }else{
        boton = "";
      }

      var lengthOption = $('#integradorFilter option:contains("'+obj[index]['nombreIntegrador']+'")').length

      if (lengthOption == 0) {
        $('#integradorFilter').append($('<option>', {
            value: obj[index]['nombreIntegrador'],
            text: obj[index]['nombreIntegrador']
        }));
      }

      $('#ordertablaP tbody').append('<tr><td>'+obj[index]['nombre']+'</td>'+
        '<td style="text-align:center;">'+obj[index]['tipoEmisor']+'</td>'+
        '<td style="text-align:center;">'+obj[index]['retencion']+'</td>'+
        '<td style="text-align:right;">'+obj[index]['liquidacion']+'</td>'+
        '<td style="text-align:right;"> $'+obj[index]['comision']+'</td>'+
        '<td style="text-align:center;"> %'+(obj[index]['porcentajeComision']*100)+'</td>'+
        '<td style="text-align:center;">'+obj[index]['nombreIntegrador']+'</td>'+
        '<td style="width: 13%!important;"><button id="verEmisor" onclick="editaremisor('+obj[index]['id']+', '+obj[index]['tipoCliente']+');" data-placement="top" rel="tooltip" title="Ver Informacion" class="btn habilitar btn-default btn-xs" data-id='+obj[index]['id']+' data-title="Ver Informacion"><span class="fa fa-search"></span></button>'+
        ''+boton+'</td></tr>');
    });
    $("[rel=tooltip]").tooltip();
    var	tablaSubEmisor = $("#ordertablaP").DataTable(settings);

		/*document.getElementById("tablaEmisores").style.display="none";
		document.getElementById("tablaReceptores").style.display="none";*/
        document.getElementById("tablaIntegradores").style.display="inline";
		document.getElementById("tablaPreemisores").style.display="none";
		document.getElementById("ordertablaProveedores").style.display="none";

  }).fail(function(response){
        alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
  });
}




function cargaemisoresdt(){
  $.post("../../../paycash/ajax/Afiliacion/consultaClientes.php",{
			tipo:1
		},
		function(response){
			var obj = jQuery.parseJSON(response);
			//console.log(obj);
			jQuery.each(obj, function(index,value) {

				estatus = obj[index]['estatus'];
				nombre = obj[index]['nombre'];

				if(ID_PERFIL == 1 || ID_PERFIL == 5){
					if(estatus == 0 ){
						boton = '<button id="confirmacionBorradoEmisor" data-placement="top" rel="tooltip" title="Inhabilitar Emisor"  data-toggle="modal"  data-target="#confirmacion" class="btn inhabilitar btn-default btn-xs" data-id='+obj[index]['id']+' data-name="'+nombre+'" data-title="Editar Informacion"><span class="fa fa-times"></span></button>'
					}else{
						boton = '<button id="confirmacionHabilitarEmisor" data-placement="top" rel="tooltip" title="Habilitar Emisor" data-toggle="modal" data-target="#confirmacion" class="btn habilitar btn-primary btn-xs" data-id='+obj[index]['id']+' data-name="'+nombre+'" data-title="Editar Informacion"><span class="fa fa-check"></span></button>'
					}
				}else{
					boton = "";
				}


                    //$('#ordertablaE tbody').remove();
				$('#ordertablaE tbody').append('<tr><td>'+obj[index]['nombre']+'</td>'+
					'<td style="text-align:center;">'+obj[index]['tipoEmisor']+'</td>'+
					'<td style="text-align:center;">'+obj[index]['retencion']+'</td>'+
					'<td style="text-align:right;">'+obj[index]['liquidacion']+'</td>'+
					'<td style="text-align:right;"> $'+obj[index]['comision']+'</td>'+
					'<td style="text-align:center;"> %'+(obj[index]['porcentajeComision']*100)+'</td>'+
					'<td style="width: 13%!important;"><button id="verEmisor" onclick="editaremisor('+obj[index]['id']+', '+obj[index]['tipoCliente']+');" data-placement="top" rel="tooltip" title="Ver Informacion" class="btn habilitar btn-default btn-xs" data-id='+obj[index]['id']+' data-title="Ver Informacion"><span class="fa fa-search"></span></button>'+
					''+boton+'</td></tr>');
			});
      $("[rel=tooltip]").tooltip();

      var	tablaEmisor = $("#ordertablaE").DataTable(settings);
		})
		.fail(function(response){
					alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
		})
}

function cargareceptoresdt(){

		$.post("../../../paycash/ajax/Afiliacion/consultaClientes.php",{
			tipo: 2
		},
		function(response){
			var obj = jQuery.parseJSON(response);
					//console.log(obj);
					jQuery.each(obj, function(index,value) {

						estatus = obj[index]['estatus'];
						nombre = obj[index]['nombre'];
						if(ID_PERFIL == 1 || ID_PERFIL == 5){
							if(estatus == 0 ){
								boton = '<button id="confirmacionBorradoCadena" data-placement="top" rel="tooltip" title="Inhabilitar Cadena" data-toggle="modal" data-target="#confirmacionCadena" class="btn inhabilitar btn-default btn-xs" data-id='+obj[index]['id']+' data-name="'+nombre+'" data-title="Editar Informacion"><span class="fa fa-times"></span></button>'
							}else{
								boton = '<button id="confirmacionHabilitarCadena" data-placement="top" rel="tooltip" title="Habilitar Cadena" data-toggle="modal" data-target="#confirmacionCadena" class="btn habilitar btn-primary btn-xs" data-id='+obj[index]['id']+' data-name="'+nombre+'" data-title="Editar Informacion"><span class="fa fa-check"></span></button>'
							}
						}else{
							boton ="";
						}

                       // $('#ordertablaR tbody').remove();
						$('#ordertablaR tbody').append('<tr><td>'+obj[index]['nombre']+'</td>'+
							'<td style="text-align:center;">'+obj[index]['retencion']+'</td>'+
							'<td style="text-align:right;">'+obj[index]['liquidacion']+'</td>'+
							'<td style="text-align:right;"> $'+obj[index]['comision']+'</td>'+
							'<td style="text-align:center;"> %'+(obj[index]['porcentajeComision']*100)+'</td>'+
							'<td style="text-align:right;"> $'+obj[index]['comisionAdicional']+'</td>'+
							'<td style="text-align:right;"> %'+(obj[index]['porcentajeAdicional']*100)+'</td>'+
							'<td style="width: 13%!important;"><button data-id='+obj[index]['id']+' id="verCadenas" data-placement="top" rel="tooltip" title="Ver Informacion" class="btn btn-default btn-xs" data-title="Ver Informacion" onclick="editarreceptor('+obj[index]['id']+')"><span class="fa fa-search"></span></button>'+
							''+boton+'</td></tr>');
					});
					$("[rel=tooltip]").tooltip();
                    var tablaReceptor = $("#ordertablaR").DataTable(settings);
		})
		.fail(function(response){
					alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
		});


}

function cargaintegradoresdt(){
  $.post("/ayddo/ajax/Integradores.php",{
    itipo: 1
  },function(response){
    var obj = jQuery.parseJSON(response);
    //console.log(obj);
    jQuery.each(obj, function(index,value) {
      estatus = obj[index]['nIdEstatus'];
      nombre = obj[index]['sRazonSocial'];

      
      idintegardor = obj[index]['nIdIntegrador'];

      if(ID_PERFIL == 1 || ID_PERFIL == 5){
        if(estatus == 0 ){
          boton = '<button id="confirmacionBorradoIntegrador" data-placement="top" rel="tooltip" title="Inhabilitar Integrador"   class="btn inhabilitar btn-default btn-xs"  data-title="Editar Informacion" onclick="actualizaEstatusIntegrador('+ idintegardor +')"><span class="fa fa-times"></span></button>'
        }else{
          boton = '<button id="confirmacionHabilitarIntegrador" data-placement="top" rel="tooltip" title="Habilitar Integrador"  class="btn habilitar btn-primary btn-xs"  data-title="Editar Informacion" onclick="actualizaEstatusIntegrador('+ idintegardor +')"><span class="fa fa-check"></span></button>'
        }
      }else{
        boton = "";
      }

      //$('#ordertablaI tbody').remove();

						$('#ordertablaIntegradores tbody').append('<tr><td style="text-align:left;width:100px">'+obj[index]['sRfc']+'</td>'+
							'<td style="text-align:left;">'+obj[index]['sRazonSocial']+'</td>'+
							'<td style="text-align:right;width:100px">$0'+'</td>'+
							'<td style="text-align:right;width:100px">$0'+'</td>'+
							'<td style="text-align:center;"> '+obj[index]['dFechaAlta']+'</td>'+

      '<td style="width: 13%!important;"><button id="verIntegrador" onclick="editarintegrador('+ idintegardor +');" data-placement="top" rel="tooltip" title="Ver Informacion" class="btn habilitar btn-default btn-xs" data-id='+obj[index]['nIdIntegrador']+' data-title="Ver Informacion"><span class="fa fa-search"></span></button>'+
      ''+boton+'</td></tr>');
    });
    $("[rel=tooltip]").tooltip();
    var tablaIntegrador = $("#ordertablaIntegradores").DataTable(settings);
  }).fail(function(response){
    alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
  })
}

function cargapreemisoresdt(){
  $.post("../../../paycash/ajax/Afiliacion/consultaClientes.php",{
    tipo: 14
  },function(response){

    var obj = jQuery.parseJSON(response);
    //console.log(obj);
    jQuery.each(obj, function(index,value) {
      estatus = obj[index]['idestatus'];
  		idpreemisor = obj[index]['id'];
      rfcpreemisor = obj[index]['rfc'];
  		nombrepreemisor = obj[index]['razonsocial'];
      fechaaltapreemisor = obj[index]['fechaalta'];

      if(ID_PERFIL == 1 || ID_PERFIL == 5){
        if(estatus == 0 ){
          boton = '<button id="confirmacionBorradoIntegrador" data-placement="top" rel="tooltip" title="Autorizar Preemisor"   class="btn inhabilitar btn-default btn-xs"  data-title="Editar Informacion" onclick="autorizaPremisor('+obj[index]['id']+')"><span class="fa fa-times"></span></button>'
        }else{
          boton = '<button id="confirmacionHabilitarIntegrador" data-placement="top" rel="tooltip" title="Autorizar Preemisor",  class="btn habilitar btn-primary btn-xs"  data-title="Editar Informacion" onclick="autorizaPremisor('+obj[index]['id']+')"><span class="fa fa-check"></span></button>'
        }
      }else{
        boton = "";
      }

      //$('#ordertablaI tbody').remove();
			$('#ordertablaPreemisores tbody').append('<tr><td>'+obj[index]['rfc']+'</td>'+
        '<td style="text-align:center;">'+obj[index]['razonsocial']+'</td>'+
        '<td style="text-align:center;">'+obj[index]['nombreIntegrador']+'</td>'+
        '<td style="text-align:right;">'+obj[index]['fechaalta']+'</td>'+
        '<td style="width: 13%!important;"><button id="verIntegrador" onclick="editarpreemisor('+obj[index]['id']+','+obj[index]['idintegrador']+');" data-placement="top" rel="tooltip" title="Ver Informacion" class="btn habilitar btn-default btn-xs" data-id='+obj[index]['id']+' data-title="Ver Informacion"><span class="fa fa-search"></span></button>'+
							''+boton+'</td></tr>');
    });

    $("[rel=tooltip]").tooltip();
    var tablaIntegrador = $("#ordertablaPreemisores").DataTable(settings);
	}).fail(function(response){
    alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
	});
}

function cargarproveedoresdt(){
	$.post("/ayddo/ajax/Proveedores.php",{
    itipo: 1
  },function(response){

    var obj = jQuery.parseJSON(response);
    //console.log(obj);
    jQuery.each(obj, function(index,value) {
      estatus = obj[index]['IdEstatus'];

      //$('#ordertablaI tbody').remove();
			$('#ordertablaProveedores tbody').append('<tr><td>'+obj[index]['sRFC']+'</td>'+
        '<td style="text-align:center;">'+obj[index]['sRazonSocial']+'</td>'+
        '<td style="text-align:center;">'+obj[index]['sNombreComercial']+'</td>'+
				'<td style="text-align:right;">'+obj[index]['sTelefono']+'</td>'+
				'<td style="text-align:right;">'+obj[index]['NombreGiro']+'</td>'+
        '<td style="width: 13%!important;"><button id="verProveedor" onclick="editarproveedor('+obj[index]['IdProveedor']+');" data-placement="top" rel="tooltip" title="Ver Informacion" class="btn habilitar btn-default btn-xs" data-id='+obj[index]['IdProveedor']+' data-title="Ver Informacion"><span class="fa fa-search"></span></button></td></tr>');
    });

    $("[rel=tooltip]").tooltip();
    var tablaIntegrador = $("#ordertablaProveedores").DataTable(settings);
	}).fail(function(response){
    alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
	});
}



//var idestatusintegrador = 0;
var idintegardor = 0;



var maxField = 5; //Limite de inputs para agregar correos
    var addButton = $('.add_button'); //identififcador del boton que agrega los inputs
    var wrapper = $('.field_wrapper'); //contenedor de los inputs
    var fieldHTML = '<div class="col-xs-12" id="formCorreos">'+
						'<input type="text" id="int" class="form-control m-bot15" name="correos" style="width: 300px; display:inline-block;">'+
						'<button  class="remove_button btn btn-sm inhabilitar" id="remove" style="margin-left:3px;">Quitar  <i class="fa fa-minus-circle" aria-hidden="true"></i></button>'+
					'</div>'; //Nuevo campo para agregar correo


   $(document).on('click', '.add_button', function(e){
        if(x < maxField){ // Chequeo de contador maximo de inputs
            x++; // incremento del contador
            $(wrapper).append(fieldHTML); // Se agrega el campo nuevo para captura de correo
        }
    });
    $(document).on('click', '.remove_button', function(e){ // se remueve el campo de que este a lado del boton
        e.preventDefault();
        if (x > 1){
        	$(this).parent('div').remove();
        	x--; // Se decrementa el conteo de campos
    	}
    });



//Inhabilitar Emisor
$(document).on('click', '#confirmacionBorradoEmisor',function (e) {
		var id = $(this).data("id");
		$("#emisorId").val(id);
		$("#estatusEmisor").val(1);
		$('#confirmacion p').empty();
		var nombre = $(this).data("name");
		var texto = "Desea Borrar este emisor :" +nombre;
		$('#confirmacion p').append(texto);
});

$(document).on('click', '#confirmacionHabilitarEmisor',function (e) {
		var id = $(this).data("id");
		$("#emisorId").val(id);
		$("#estatusEmisor").val(0);
		$('#confirmacion p').empty();
		var nombre = $(this).data("name");
		var texto = "Desea Habilitar este emisor :" +nombre;
		$('#confirmacion p').append(texto);
});

$(document).on('click', '#borrarEmisor',function (e) {
		var $this = $(this);
		$this.button('loading');
		id = $("#emisorId").val();
		estatus = $("#estatusEmisor").val();
		actualizaEstatus(id,estatus);
});


//Actualizacion de estatus del emisor
function actualizaEstatus(id,estatus){
	$.post("../../paycash/ajax/Afiliacion/consultaClientes.php",{
			idEmisor : id,
			estatus : estatus,
			tipo: 5
		},
		function(response){
			var obj = jQuery.parseJSON(response);
			if(obj.showMessage == 500){
				jAlert(obj.msg);
				$("#borrarEmisor").button('reset');
			}else{
				jAlert(obj.sMensaje);
				setTimeout("location.reload()", 3000);
			}
		})
		.fail(function(response){
		$("#borrarEmisor").button('reset');
				alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
		})
}



//Inhabilitar Cadena
$(document).on('click', '#confirmacionBorradoCadena',function (e) {
		var id = $(this).data("id");
		$("#cadenaId").val(id);
		$("#estatusCadena").val(1);
		$('#confirmacionCadena p').empty();
		var nombre = $(this).data("name");
		var texto = "Desea inhabilitar esta cadena :" +nombre;
		$('#confirmacionCadena p').append(texto);
});

$(document).on('click', '#confirmacionHabilitarCadena',function (e) {
		var id = $(this).data("id");
		$("#cadenaId").val(id);
		$("#estatusCadena").val(0);
		$('#confirmacionCadena p').empty();
		var nombre = $(this).data("name");
		var texto = "Desea Habilitar esta cadena :" +nombre;
		$('#confirmacionCadena p').append(texto);
});

$(document).on('click', '#borrarCadena',function (e) {
		var $this = $(this);
		$this.button('loading');
		id = $("#cadenaId").val();
		estatus = $("#estatusCadena").val();
		actualizaEstatusCadena(id,estatus);
});



function actualizaEstatusCadena(id,estatus){
	$.post("../../paycash/ajax/Afiliacion/consultaClientes.php",{
			idCadena : id,
			estatus : estatus,
			tipo: 8
		},
		function(response){
			var obj = jQuery.parseJSON(response);
			if(obj.showMessage == 500){
				jAlert(obj.msg);
				$("#borrarCadena").button('reset');
			}else{
				jAlert(obj.sMensaje);
				setTimeout("location.reload()", 3000);
			}
		})
		.fail(function(response){
		$("#borrarCadena").button('reset');
				alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
		})
}

function analizarCLABE1(){
	var CLABE = event.target.value;

	if(CLABE.length == 18){
		var CLABE_EsCorrecta = validarDigitoVerificador(CLABE);
		if(CLABE_EsCorrecta){
			$.post(BASE_PATH + '/inc/Ajax/_Clientes/getBancoCLABE.php',
				{ "CLABE": CLABE }
			).done(function ( data ) {
					var banco = jQuery.parseJSON( data );
					$("#banco").val(banco.bancoID);
					$("#nombreBanco").val(banco.nombreBanco);
					$("#bancoCadena").val(banco.bancoID);
					$("#nombreBancoCadena").val(banco.nombreBanco);
			});
		}
		else{
			alert("La CLABE escrita es incorrecta. Favor de verificarla.");
			$("[name='idBanco'], [name='txtBanco'], [name='numCuenta']").val("");
		}
	}
	else{
		$("[name='idBanco'], [name='txtBanco'], [name='numCuenta']").val("");
	}
}

function analizarCLABE2(clabe){// Analiza la clabe interbancaria cuando llega de la llamada que carga los datos
	var CLABE = clabe;
	var respuesta= "";
	if(CLABE.length == 18){
		var CLABE_EsCorrecta = validarDigitoVerificador(CLABE);
		if(CLABE_EsCorrecta){
			respuesta = true;
			$.post(BASE_PATH + '/inc/Ajax/_Clientes/getBancoCLABE.php',
				{ "CLABE": CLABE }
			).done(function ( data ) {
					var banco = jQuery.parseJSON( data );
					$("#banco").val(banco.bancoID);
					$("#nombreBanco").val(banco.nombreBanco);
					$("#bancoCadena").val(banco.bancoID);
					$("#nombreBancoCadena").val(banco.nombreBanco);
			});
		}
		else{
			alert("La CLABE escrita es incorrecta. Favor de verificarla.");
			$("[name='idBanco'], [name='txtBanco'], [name='numCuenta']").val("");
			 respuesta = false;
		}
	}
	else{
		$("[name='idBanco'], [name='txtBanco'], [name='numCuenta']").val("");
		respuesta = false;
	}
	return respuesta;
}



function editarproveedor(proveedor){

    var formemisor = '<form action="Afiliacionproveedor.php"  method="post" id="formemisorsend"><input type="text" name="p_IdProveedor"  value="'+proveedor+'"/></form>'

    $('body').append(formemisor);
    $( "#formemisorsend" ).submit();
}



function editarintegrador(ideintegrador){

    var formemisor = '<form action="afiliacionIntegrador.php"  method="post" id="formemisorsend"><input type="text" name="p_IdIntegrador"  value="'+ideintegrador+'"/></form>'

    $('body').append(formemisor);

    $( "#formemisorsend" ).submit();

}


function editarpreemisor(idpreemisor,idintegrador){
  var formpreem = '<form action="AfiliacionPreemisor.php"  method="post" id="formpreemsend"><input type="text" name="txtidpreem"  value="'+idpreemisor+'"/><input type="text" name="txtidinteg"  value="'+idintegrador+'"/></form>';
  $('body').append(formpreem);
  $( "#formpreemsend" ).submit();
}


function verreporte(oprep){
  var rutarep = '';
  if(oprep == 1){
    rutarep = '../ajax/Afiliacion/reporteEmisoresPDF.php';
  }else if(oprep == 2){
    rutarep = '../ajax/Afiliacion/reporteReceptorePDF.php';
  }else if(oprep == 3){
    rutarep = '../ajax/Afiliacion/reporteIntegradoresPDF.php';
  }else if (oprep == 4) {
    rutarep = '../ajax/Afiliacion/reporteSubEmisoresAUTORIZADOSPDF.php';
  }else if (oprep == 5) {
    rutarep = '../ajax/Afiliacion/reporteSubEmisoresNOAUTORIZADOSPDF.php';
  }
  //alert(tipliq);
  jQuery('#pdfdata').attr('data', rutarep);
  $('#pdfvisor').css('display','block');
}

function  descargaexcel(valor){
  var excelform = '<form id="formtoexcel" action="../ajax/Afiliacion/generarReporteXLS.php" method="post"><input type="text" name="value" value="'+valor+'"/></form>' ;
  $('body').append(excelform);
  $( "#formtoexcel" ).submit();
  $('#formtoexcel').remove();
}

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




function  actualizaEstatusIntegrador(integ){

   var confx= confirm('Desea Actualizar el Estatus del integrador');

    if(confx == true){

           $.post('/ayddo/ajax/Integradores.php',{idintegardor:integ,itipo:4},function(res){
                if(res.nCodigo == 0){
                    jAlert(res.sMensaje);
                    //$("#ordertablaI").remove();
                   var tablaIntegrador = $("#ordertablaIntegradores").DataTable();
                    tablaIntegrador.fnDestroy();
                   $('#ordertablaIntegradores tbody tr').remove();
                    cargaintegradoresdt();
                }else{
                  jAlert(res.sMensaje);
                }
           },"JSON");

    }


}

function autorizaPremisor(preemisor){

	var confx= confirm('Desea Cambiar De Preemisor a Proveedor');

    if(confx == true){
			$.post('/ayddo/ajax/premisor.php',{p_nIdPreemisor:preemisor,tipo:2},function(res){

				if(res.code == 0){
						jAlert(res.msg);
						//$("#ordertablaI").remove();
					 var tablaIntegrador = $("#ordertablaPreemisores").DataTable();
						tablaIntegrador.fnDestroy();
					 $('#ordertablaPreemisores tbody tr').remove();
					 cargapreemisoresdt();
				}else{
					jAlert(res.msg);
				}
	 },"JSON");
		}

}




function editarreceptor(idreceptors){

     var formreceptor = '<form action="AfiliacionCadena.php?nIdTipoCliente=1"  method="post" id="formreceptorsend"><input type="text" name="txtidreceptor"  value="'+idreceptors+'"/></form>'

    $('body').append(formreceptor);

    $( "#formreceptorsend" ).submit();
}
