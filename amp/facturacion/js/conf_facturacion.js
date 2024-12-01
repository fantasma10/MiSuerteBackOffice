$(function(){
    getConfiguracion();
});
function validacion(){
    var conteo=0;
    var conteoS=0;
    var respuesta=0;
    if( $("#txtSerie").val() !=''   && 
        $("#cmbMetodoPago").val() !='' && 
        $("#cmbFormaPago").val() !='' && 
        $("#cmbCFDI").val() !='' &&
        $("#cmbProducto").val() !='' &&
        $("#cmbIVA").val() !=''){
        conteo++;
    }else{
        if( $("#txtSerie").val() !=''   || 
            $("#cmbMetodoPago").val() !='' || 
            $("#cmbFormaPago").val() !='' || 
            $("#cmbCFDI").val() !='' ||
            $("#cmbProducto").val() !='' ||
            $("#cmbIVA").val() !=''
        ){
            alert('Favor de llenar todos los campos de la configuracion de Tiempo Aire');
            return false;
        }
    }

    if( $("#txtSerieS").val() !=''   &&  
        $("#cmbMetodoPagoS").val() !='' && 
        $("#cmbFormaPagoS").val() !='' && 
        $("#cmbCFDIS").val() !='' &&
        $("#cmbProductoS").val() !='' &&
        $("#cmbIVAS").val() !=''){
            conteoS++;
    }else{
        if( $("#txtSerieS").val() !=''   ||  
            $("#cmbMetodoPagoS").val() !='' ||  
            $("#cmbFormaPagoS").val() !='' ||  
            $("#cmbCFDIS").val() !='' || 
            $("#cmbProductoS").val() !='' || 
            $("#cmbIVAS").val() !=''){
            alert('Favor de llenar todos los campos de la configuracion Servicios');
            return false;
        }
    }
    if(conteo == 1 && conteoS == 1)
        respuesta = 1;
    if(conteo ==  1)
        respuesta = 2;
    if(conteoS == 1)
        respuesta = 3;

    return respuesta;    
}
 function getCatalogos(){
    return new Promise(resolve =>{
        $.post("../ajax/conf_facturacion.php",{id:0},
            function(response){
                var obj = jQuery.parseJSON(response);
                var catalogoFormaPago = jQuery.parseJSON(obj.result.catalogoFormaPago);
                    catalogoFormaPago = catalogoFormaPago.GetFormaPagoResult.FormaPago;
                
                var catalogoCFDI = jQuery.parseJSON(obj.result.catalogoCFDI);
                    catalogoCFDI = catalogoCFDI.GetUsoCFDIResult.UsoCFDI;
                
                var catalogoMetodoPago= jQuery.parseJSON(obj.result.catalogoMetodoPago);
        
                var catalogoProducto= jQuery.parseJSON(obj.result.catalogoProducto);
                    catalogoProducto = catalogoProducto.GetProductoServicioResult.ProductoServicio;
                
                $.each(catalogoFormaPago, function(i, item) {
                    $('#cmbFormaPago').append($('<option>', { 
                        value: item.nIdFormaPago,
                        text : item.strDescripcion+' ('+item.strFormaPago+')'
                    }));
                    $('#cmbFormaPagoS').append($('<option>', { 
                        value: item.nIdFormaPago,
                        text : item.strDescripcion+' ('+item.strFormaPago+')'
                    }));
                });
                $.each(catalogoCFDI, function(i, item) {
                    $('#cmbCFDI').append($('<option>', { 
                        value: item.nIdUsoCFDI,
                        text : item.strDescripcion+' ('+item.strUsoCFDI+')'
                    }));
                    $('#cmbCFDIS').append($('<option>', { 
                        value: item.nIdUsoCFDI,
                        text : item.strDescripcion+' ('+item.strUsoCFDI+')'
                    }));
                });
                $.each(catalogoMetodoPago, function(i, item) {
                    $('#cmbMetodoPago').append($('<option>', { 
                        value: item.nIdMetodoPago,
                        text : item.strDescripcion+' ('+item.strMetodoPago+')'
                    }));
                    $('#cmbMetodoPagoS').append($('<option>', { 
                        value: item.nIdMetodoPago,
                        text : item.strDescripcion+' ('+item.strMetodoPago+')'
                    }));
                });
                
                $.each(catalogoProducto, function(i, item) {
                    $('#cmbProducto').append($('<option>', { 
                        value: item.nIdClaveProducto,
                        text : item.strClaveProducto+' '+item.strDescripcion
                    }));
                    $('#cmbProductoS').append($('<option>', { 
                        value: item.nIdClaveProducto,
                        text : item.strClaveProducto+' '+item.strDescripcion
                    }));
                });
                resolve(true);
            }
            
        ).fail(function(resp){alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde'); resolve(false);});
    });
    
}
function guardarConf_facturacion(){
    var data=[];
    let validacion=0;
    validacion=this.validacion();
    console.log(validacion)
    switch (validacion) {
        case 1://todos
            data=[{
                "txtSerie":$("#txtSerie").val(),
                "cmbMetodoPago":$("#cmbMetodoPago").val(),
                "scmbMetodoPago":$( "#cmbMetodoPago option:selected" ).text(),
                "cmbFormaPago":$("#cmbFormaPago").val(),
                "scmbFormaPago":$( "#cmbMetodoPago option:selected" ).text(),
                "cmbCFDI":$("#cmbCFDI").val(),
                "scmbCFDI":$( "#cmbCFDI option:selected" ).text(),
                "cmbProducto":$("#cmbProducto").val(),
                "scmbProducto":$( "#cmbProducto option:selected" ).text(),
                "cmbIVA":$("#cmbIVA").val(),
                "idFacturacionTAE":$("#idFacturacionTAE").val(),
                "txtSerieS":$("#txtSerieS").val(),
                "cmbMetodoPagoS":$("#cmbMetodoPagoS").val(),
                "scmbMetodoPagoS":$( "#cmbMetodoPagoS option:selected" ).text(),
                "cmbFormaPagoS":$("#cmbFormaPagoS").val(),
                "scmbFormaPagoS":$( "#cmbFormaPagoS option:selected" ).text(),
                "cmbCFDIS":$("#cmbCFDIS").val(),
                "scmbCFDIS":$( "#cmbCFDIS option:selected" ).text(),
                "cmbProductoS":$("#cmbProductoS").val(),
                "scmbProductoS":$( "#cmbProductoS option:selected" ).text(),
                "cmbIVAS":$("#cmbIVAS").val(),
                "idFacturacionServicios":$("#idFacturacionServicios").val()
                

                
            }]
        break;
        case 2://TAE
            data=[{
                "txtSerie":$("#txtSerie").val(),
                "cmbMetodoPago":$("#cmbMetodoPago").val(),
                "scmbMetodoPago":$( "#cmbMetodoPago option:selected" ).text(),
                "cmbFormaPago":$("#cmbFormaPago").val(),
                "scmbFormaPago":$( "#cmbMetodoPago option:selected" ).text(),
                "cmbCFDI":$("#cmbCFDI").val(),
                "scmbCFDI":$( "#cmbCFDI option:selected" ).text(),
                "cmbProducto":$("#cmbProducto").val(),
                "scmbProducto":$( "#cmbProducto option:selected" ).text(),
                "cmbIVA":$("#cmbIVA").val(),
                "idFacturacionTAE":$("#idFacturacionTAE").val()
            }]
        break;
        case 3://SERVICIOS
            data=[{
                "txtSerieS":$("#txtSerieS").val(),
                "cmbMetodoPagoS":$("#cmbMetodoPagoS").val(),
                "scmbMetodoPagoS":$( "#cmbMetodoPagoS option:selected" ).text(),
                "cmbFormaPagoS":$("#cmbFormaPagoS").val(),
                "scmbFormaPagoS":$( "#cmbFormaPagoS option:selected" ).text(),
                "cmbCFDIS":$("#cmbCFDIS").val(),
                "scmbCFDIS":$( "#cmbCFDIS option:selected" ).text(),
                "cmbProductoS":$("#cmbProductoS").val(),
                "scmbProductoS":$( "#cmbProductoS option:selected" ).text(),
                "cmbIVAS":$("#cmbIVAS").val(),
                "idFacturacionServicios":$("#idFacturacionServicios").val()
            }]
        break;
        default://NINGUNO DE LOS 2
         // alert('Favor de llenar los campos.');
          return false;
        break;  
    }
     
    
    $.post("../ajax/guardar_conf_facturacion.php",{data},
    function(response){
        var data =JSON.parse(response);
        switch (validacion) {
            case 1:
                $("#idFacturacionTAE").val(data.data.TAE);
                $("#idFacturacionServicios").val(data.data.Servicio);
                alert('Se han agregado correctamente los datos');
            break;
            case 2:
                $("#idFacturacionTAE").val(data.data.TAE);
                alert('Se han agregado correctamente los datos');
            break; 
            case 3:
                $("#idFacturacionServicios").val(data.data.Servicio);
                alert('Se han agregado correctamente los datos');
            break;  
        }  
           
    });
    
}
async function getConfiguracion(){
    showSpinner();
var resultado= await getCatalogos();
console.log(resultado);
    if(resultado){
        $.post("../ajax/conf_getConfiguracion.php",{id:0},
            function(response){
                hideSpinner();
                var data =JSON.parse(response);
                console.log(data.data.Resp);
                $.each(data.data.Resp, function(i, item) {
                    if(item.nTipoFactura==1){
                        $("#idFacturacionTAE").val(item.nIdFacturacion);
                        $("#txtSerie").val(item.sSerie);
                        $("#cmbMetodoPago").val(item.nMetodoPago);
                        $("#cmbFormaPago").val(item.nFormaPago);
                        $("#cmbCFDI").val(item.nCFDI);
                        $("#cmbProducto").val(item.nProducto);
                        $("#cmbIVA").val(item.nIva);
                    }else{
                        $("#idFacturacionServicios").val(item.nIdFacturacion);
                        $("#txtSerieS").val(item.sSerie);
                        $("#cmbMetodoPagoS").val(item.nMetodoPago);
                        $("#cmbFormaPagoS").val(item.nFormaPago);
                        $("#cmbCFDIS").val(item.nCFDI);
                        $("#cmbProductoS").val(item.nProducto);
                        $("#cmbIVAS").val(item.nIva);
                        
                    }
                })
                
            }   
        ).fail(function(resp){alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');})
    }
}