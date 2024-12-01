$(document).ready(function(){

    datatablaprosp();
    formatosiniciales(); 
    $('#nuevospn').click(function(){ resetform();$('#pannel1').css('display','block');});  
    

});

var idemisor = 0;


function datatablaprosp(){     
        
        	/* Crear la tabla de PreSubCadenas */
	var tablaPreSubCadenas = $('#presubcadenas').dataTable( {
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "./ajax/emisores/emisoresDT.php",
		/*"bJQueryUI": true,*/
		/*"sDom": '<"H"<"elementos"lr><"search-box"f>>t<"F"ip>',*/
		"aaSorting": [ [1, "desc"] ],
		"aoColumnDefs": [
            //1ra columna
			{ "mRender": function ( data, type, row ) {// familia
				return row[0];
			}, "aTargets": [ 0 ] },
            //segunda columna
			{ 	"mRender": function ( data, type, row ) {//subfamilia
				return row[1];
			}, /*"sWidth": "20px",*/ "aTargets": [ 1 ] },
            //3a columna
			{ "mRender": function ( data, type, row ) { //descripcion
								
					return row[2];
				
			
			}, "aTargets": [ 2 ] },
            
             //4a columna
			{ "mRender": function ( data, type, row ) { //inicio vigencia
                
				return row[3];
                
			},  "aTargets": [ 3] },
       
            //5a columna
			
			{ "mRender": function ( data, type, row ) {//fin vigencia
               
				var iconoEditar = "<a href='#' onclick='editaremisor("+row[0]+")'><center><img src=\"../img/edit.png\" title='Editar'></center></a>";
				return iconoEditar;
                
                //src=\"../img/edit.png\"
			
            }, "bSortable": false, "aTargets": [4] },
          
		],
		"fnDrawCallback": function ( oSettings ) {
			/* Aplicar tooltips */
			tablaPreSubCadenas.$('img').tooltip({
				"delay": 0,
				"track": true,
				"fade": 250					  
			});
			//tablaPreSubCadenas.$('tr:odd').css( "background-color", "#D4DDED" );

		},
		"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
			$('td:eq(0)', nRow).addClass( "dataTableNombre" );
			$('td:eq(1)', nRow).addClass( "dataTableAvance" );
		},		
		"oLanguage": {
			"sLengthMenu": "Mostrar _MENU_ registros por p&aacute;gina.",
			"sZeroRecords": "No se encontr&oacute; ning&uacute;n resultado.",
			"sInfo": "Mostrando del _START_ al _END_ de un total de _TOTAL_ registros.",
			"sInfoEmpty": "Mostrando 0 de 0 de 0 registros.",
			"sInfoFiltered": "(filtrados de un total de _MAX_ registros)",
			"sSearch": "Buscar",
			"sProcessing": "Procesando..."
		}
	} );
        
   }// este esl datatable donde se carga toda la info


function RefreshTable(tableId, urlData){
  $.getJSON(urlData, null, function( json )
  {
    table = $(tableId).dataTable();
    oSettings = table.fnSettings();

    table.fnClearTable(this);

    for (var i=0; i<json.aaData.length; i++)
    {
      table.oApi._fnAddData(oSettings, json.aaData[i]);
    }

    oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
    table.fnDraw();
  });
    
} //recargra la informacion del datatatble funcion principal


function formatosiniciales(){ 
     
     	$('#txtnombre, #txtabrev').alphanum({
			allow			    : 'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA',
			disallow			: '',
			allowSpace			: true,
			allowNumeric		: true,
			allowUpper			: true,
			allowLower			: false,
			allowLatin			: false,
			allowOtherCharSets	: false,
			maxLength			: 50
		});
        

}//caracteres admitidos en los campos del formulario


function validarform(){ 
       
     var  nombre  = $('#txtnombre').val();
     var  abrev      = $('#txtabrev').val();
   
   
    if(nombre == '' || nombre.length < 3){toasts('Capture el nombre del Emisor de al menos 3 caracteres'); return;}
    if(abrev == '' || abrev.length < 3){toasts('Capture una abreviacion al menos 3 caracteres'); return;}
    
    guardaremisor();
  
} //valida los datos de los campos del formulario antes de  enviarlos


function toasts(mensaje){ // contraer el toast
       $().toastmessage('showToast', {
       text	: mensaje,
		sticky: false, position	: 'top-center', type: 'warning'}); 
} // contraccion de la funcion toastmsg
    

function guardaremisor(){ 
    
 var guard = confirm('¿Desea guardar los datos del Emisor?');
    
     var  nombre  = $('#txtnombre').val();
     var  abrev   = $('#txtabrev').val();
     var  estat   = $('#txtestatus').val();
       
    if(guard == true){
       $.post('./ajax/emisores/emisoresGuardar.php',{idemisor:idemisor,nombre:nombre,abrev:abrev,usr:usr,estat:estat},function(res){
        
            if(res.code == 0){
                toasts(res.msg);
                resetform();

                $('#pannel1').css('display','none');
                RefreshTable('#presubcadenas',"./ajax/emisores/emisoresDT.php");

            }else{toasts(res.msg);}
        
        },"JSON");  
        
    }
   
    
}   // guardar los datos del emisor 

function resetform(){ 
    
  $('#txtnombre').val('');
  $('#txtabrev').val('');
$('#txtestatus').val(0);     
 idemisor = 0;     
}//limpiar los datos del formulario


function editaremisor(idemisors){
   
   $.post('./ajax/emisores/cargaemisor.php',{emisor:idemisors},function(res){
    
        idemisor = res.idemisor;
        $('#txtnombre').val(res.descripcion);
        $('#txtabrev').val(res.abrev);
        $('#txtestatus').val(res.estatus);
   
   },"JSON");
    
   $('#pannel1').css('display','block'); 
}






