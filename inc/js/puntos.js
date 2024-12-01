$(document).ready(function(){
    $("#selcad").live("change",function(){
        $("#selectsubcadena").html("")
        $("#selectcorresponsal").html("")
        $("#selectoperador").html("")
        //Peticion ajax que inserta en la pagina un select con los nombres de las subcadenas
        if($("#selcad").val() != "<Ninguna Cadena>"){
            $.ajax({  url: "../ajax/SelectNombreSubcadena.php",  type: "POST", dataType: "html", beforeSend : function(){ Emergente() } , data: { idcadena : $("#selcad").val() }}).done(function(datos){
                $("#selectsubcadena").html(datos)
                $("#pasos").text("Favor De Seleccionar Una Subcadena")
                $("#opseleccionado").html($("#selcad option:selected").html() + "<span style='color:#6e6e6e'> -> </span>")
                $("#emergente").fadeOut("normal")
            });
        }else{
            $("#pasos").text("Favor De Seleccionar Una Cadena")
            $("#opseleccionado").html("")
        }
    })
    //Peticion ajax que inserta en la pagina un select con los nombres de los corresponsales
    $("#selsubcad").live("change",function(){
        $("#selectcorresponsal").html("")
        $("#selectoperador").html("")
        if($("#selsubcad").val() != "<Ninguna SubCadena>"){
            $.ajax({  url: "../ajax/SelectNombreCorresponsal.php",  type: "POST", dataType: "html", beforeSend : function(){ Emergente() } , data: { idcadena : $("#selcad").val(), idsubcadena : $("#selsubcad").val() }}).done(function(datos){
                $("#selectcorresponsal").html(datos)
                $("#pasos").text("Favor De Seleccionar Un Corresponsal")
                $("#opseleccionado").html($("#selcad option:selected").html() + "<span style='color:#6e6e6e'> -> </span>" + $("#selsubcad option:selected").html() + "<span style='color:#6e6e6e'> -> </span>")
                $("#emergente").fadeOut("normal")
            });
        }else{
            $("#pasos").text("Favor De Seleccionar Una SubCadena")
            $("#opseleccionado").html($("#selcad option:selected").html() + "<span style='color:#6e6e6e'> -> </span>")
        }
    })
    //Peticion ajax que inserta en la pagina un select con los nombres de los operadores
    $("#selcorres").live("change",function(){
        $("#selectoperador").html("")
        if($("#selcorres").val() != "<Ningun Corresponsal>"){
            $.ajax({  url: "../ajax/SelectNombreOperador.php",  type: "POST", dataType: "html", beforeSend : function(){ Emergente() } , data: { idcadena : $("#selcad").val(), idsubcadena : $("#selsubcad").val(), corresponsal : $("#selcorres").val()}}).done(function(datos){
                $("#selectoperador").html(datos)
                $("#pasos").text("Favor De Seleccionar Un Operador")
                $("#opseleccionado").html($("#selcad option:selected").html() + "<span style='color:#6e6e6e'> -> </span>" + $("#selsubcad option:selected").html() + "<span style='color:#6e6e6e'> -> </span>" + $("#selcorres option:selected").html() + "<span style='color:#6e6e6e'> -> </span>")
                $("#emergente").fadeOut("normal")
            });
        }else{
            $("#pasos").text("Favor De Seleccionar Un Corresponsal")
            $("#opseleccionado").html($("#selcad option:selected").html() + "<span style='color:#6e6e6e'> -> </span>" + $("#selsubcad option:selected").html() + "<span style='color:#6e6e6e'> -> </span>")
        }
    })
    //Modifica un label que muestra los pasos de seleccion de cadena->subcadena->corresponsal->operador
    $("#seloperador").live("change",function(){
        if($("#seloperador").val() != "<Ningun Operador>"){
            $("#pasos").text("Favor De Seleccionar Un Periodo De Tiempo")
            $("#opseleccionado").html($("#selcad option:selected").html() + "<span style='color:#6e6e6e'> -> </span>" + $("#selsubcad option:selected").html() + "<span style='color:#6e6e6e'> -> </span>" + $("#selcorres option:selected").html() + "<span style='color:#6e6e6e'> -> </span>" +  $("#seloperador option:selected").html())
        }else{
            //$("#contenedor").text("Seleccione Un Operador")
        }
    })
    
    
    //Al dar click al boton de buscar verificara si la busqueda se realiza
    //en los periodos de tiempo mensual,semestral o anual
    $("#btnbuscar").click(function(){
        $("#resultados").html("")
        $('#filtro').slideUp("normal")
        $("#updown").attr("src","../../img/down.png")
        oculto = true
        $("#mostrar").css({"visibility":"visible"})
        switch($("input:checked").attr("id")){
            case "rdbmes":PeticionM()
                break
            case "rdbsemestral":PeticionS()
                break
            case "rdbanual":PeticionA()
                break
        }
        
        
    })
    //Se ejecuta para mostrar los puntos en el preiodo de tiempo mensual
    function PeticionM(){
        if($("#seloperador").val() != "<Ningun Operador>"){
            $("#opid").text("Id De Operador: "+ $("#seloperador").val())
            $("#opnombre").text("Nombre: "+ $("#seloperador option:selected").html())
            $.ajax({  url: "../ajax/ReportePuntosSimple.php",  type: "POST", dataType: "html", beforeSend : function(){ Emergente() } , data: { idoperador : $("#seloperador").val(), tipo: 1 }}).done(function(datos){
                $("#resultados").html(datos)
                //$("#emergente").fadeOut("normal")
            });
            $.ajax({  url: "../ajax/ReportePuntosSimple.php",  type: "POST", dataType: "html", beforeSend : function(){ Emergente() } , data: { idoperador : $("#seloperador").val(), tipo: 4 }}).done(function(datos){
                $("#optrans").text("Transacciones: "+datos[0])
                $("#oppuntos").text("Puntos: "+datos[2])
                $("#emergente").fadeOut("normal")
            });
        }else{
            $("#opid").text("")
            $("#opnombre").text("")
            $("#optrans").text("")
            $("#oppuntos").text("")
            $("#updown").attr("src","../../img/down.png")
            
            
        }
    }
    
    function PeticionS(){
        if($("#seloperador").val() != "<Ningun Operador>"){
            $("#opid").text("Id De Operador: "+ $("#seloperador").val())
            $("#opnombre").text("Nombre: "+ $("#seloperador option:selected").html())
            $.ajax({  url: "../ajax/ReportePuntosSimple.php",  type: "POST", dataType: "html", beforeSend : function(){ Emergente() } , data: { idoperador : $("#seloperador").val(), tipo: 2 }}).done(function(datos){
                $("#resultados").html(datos)
                //$("#emergente").fadeOut("normal")
            });
            $.ajax({  url: "../ajax/ReportePuntosSimple.php",  type: "POST", dataType: "html", beforeSend : function(){ Emergente() } , data: { idoperador : $("#seloperador").val(), tipo: 4 }}).done(function(datos){
                $("#optrans").text("Transacciones: "+datos[0])
                $("#oppuntos").text("Puntos: "+datos[2])
                $("#emergente").fadeOut("normal")
            });
        }else{
            $("#opid").text("")
            $("#opnombre").text("")
            $("#optrans").text("")
            $("#oppuntos").text("")
            $("#updown").attr("src","../../img/down.png")
            
            
        }
    }
    
    function PeticionA(){
        if($("#seloperador").val() != "<Ningun Operador>"){
            $("#opid").text("Id De Operador: "+ $("#seloperador").val())
            $("#opnombre").text("Nombre: "+ $("#seloperador option:selected").html())
            $.ajax({  url: "../ajax/ReportePuntosSimple.php",  type: "POST", dataType: "html", beforeSend : function(){ Emergente() } , data: { idoperador : $("#seloperador").val(), tipo: 3 }}).done(function(datos){
                $("#resultados").html(datos)
                //$("#emergente").fadeOut("normal")
            });
            $.ajax({  url: "../ajax/ReportePuntosSimple.php",  type: "POST", dataType: "html", beforeSend : function(){ Emergente() } , data: { idoperador : $("#seloperador").val(), tipo: 4 }}).done(function(datos){
                $("#optrans").text("Transacciones: "+datos[0])
                $("#oppuntos").text("Puntos: "+datos[2])
                $("#emergente").fadeOut("normal")
            });
        }else{
            $("#opid").text("")
            $("#opnombre").text("")
            $("#optrans").text("")
            $("#oppuntos").text("")
            $("#updown").attr("src","../../img/down.png")
            
            
        }
    }
    
    //Oculta y muestra los filtros de busqueda
    var oculto = false
    $("#mostrar").click(function(e){
        e.preventDefault()
        if(oculto){
            $('#filtro').slideDown("normal")
            //$("#mostrar").attr("value","Cambiar Busqueda")
            $("#updown").attr("src","../../img/up.png")
        }
        else{
            $('#filtro').slideUp("normal")
            //$("#mostrar").attr("value","Cambiar Busqueda")
            $("#updown").attr("src","../../img/down.png")
        }
        oculto = !oculto
    })
    //Muestra un div emergente que contiene una imagen de cargando
    //que indica que se esta esperandon una respuesta del servidor
    function Emergente(){
        $("#emergente").css({"visibility":"visible"});
        $("#emergente").fadeTo("normal",0.4)
    }
    
    //El dar doble click a algun renglon de la tabla de puntos
    //se mostrara un div emergente que muestra mas detalladamente
    //las operaciones que se realizaron asi como los puntos por cada una de ellas
    $("#resultados table tr").live("dblclick",function(){
        if($(this).find(".idtransaccion").val() != "0")
        {
            var t = $(this).find(".cantidadtrans").text()
            var p = $(this).find(".puntostrans").text()
            $("#cont").html("")
            $.ajax({  url: "../ajax/ReportePuntosSimple.php",  type: "POST", dataType: "html", beforeSend : function(){ Emergente() } , data: { idoperador : $("#seloperador").val(), tipo: 5 , idtransaccion: $(this).find(".idtransaccion").val() }}).done(function(datos){
                $("#opid2").text("Id De Operador: "+ $("#seloperador").val())
                $("#opnombre2").text("Nombre: "+ $("#seloperador option:selected").html())
                $("#optrans2").text("Transacciones: " + t)
                $("#oppuntos2").text("Puntos: " + p)
                $("#cont").html(datos)
                $("#emergente").fadeOut("normal")
            });
            EmergenteDetalles()
        }
    })
    //metodo que muestra los div emergentes con detalles de las operaciones
    function EmergenteDetalles(){
        $("#base").css({"visibility":"visible"});
        $("#base").fadeTo("normal",0.4)
        $("#base2").css({"visibility":"visible"});
        $("#base2").fadeIn("normal")
    }
    
    //al dar click sobre la imagen de cerrar ocultara el div emergente
    //que muestra las operaciones detalladamente
    $("#cerrar").click(function(){
        $("#base").fadeOut("normal")
        $("#base2").fadeOut("normal")
    })
    
    
    //$("#filtro").fadeOut("normal")
    
    
    
    //recarga de la pagina basada en el tipo de premio
    //al darle click a una imagen
    $("#pim").click(function(e){
        e.preventDefault()
        $("#valor").val(0)
        $("#formvalor").submit()
    })
    
     $("#pimto").click(function(e){
        e.preventDefault()
        $("#valor").val(1)
        $("#formvalor").submit()
    })
    
    $("#pis").click(function(e){
        e.preventDefault()
        $("#valor").val(2)
        $("#formvalor").submit()
    })
    
    $("#pia").click(function(e){
        e.preventDefault()
        $("#valor").val(3)
        $("#formvalor").submit()
    })
    
    $("#pes").click(function(e){
        e.preventDefault()
        $("#valor").val(4)
        $("#formvalor").submit()
    })
    
    $("#bp").click(function(e){
        e.preventDefault()
        $("#valor").val(5)
        $("#formvalor").submit()
    })
    
    //al darle dobleclick a las tablas con los resultados de los ganadores
    $("#tabpm tr").live("dblclick",function(){
        if($(this).find(".idoperador").val() != "0"){
            //alert($(this).find(".idoperador").val())
            $("#cont").html("")
            $.ajax({  url: "../ajax/ReportePuntosSimple.php",  type: "POST", dataType: "html", beforeSend : function(){ Emergente() } , data: { idoperador : $(this).find(".idoperador").val(), tipo: 7 }}).done(function(datos){
                //$("#opid2").text("Id De Operador: "+ $("#seloperador").val())
                //$("#opnombre2").text("Nombre: "+ $("#seloperador option:selected").html())
                //$("#optrans2").text("Transacciones: " + t)
                //$("#oppuntos2").text("Puntos: " + p)
                $("#cont").html(datos)
                $("#emergente").fadeOut("normal")
            });
            EmergenteDetalles()
        }   
    })
    $("#tabpmo tr").live("dblclick",function(){
        if($(this).find(".idoperador").val() != "0"){
            $("#cont").html("")
            $.ajax({  url: "../ajax/ReportePuntosSimple.php",  type: "POST", dataType: "html", beforeSend : function(){ Emergente() } , data: { idoperador : $(this).find(".idoperador").val(), tipo: 7 }}).done(function(datos){
                $("#cont").html(datos)
                $("#emergente").fadeOut("normal")
            });
            EmergenteDetalles()
        }   
    })
    $("#tabps tr").live("dblclick",function(){
        if($(this).find(".idoperador").val() != "0"){
            //alert($(this).find(".idoperador").val())
            $("#cont").html("")
             $.ajax({  url: "../ajax/ReportePuntosSimple.php",  type: "POST", dataType: "html", beforeSend : function(){ Emergente() } , data: { idoperador : $(this).find(".idoperador").val(), tipo: 8 }}).done(function(datos){
                //$("#opid2").text("Id De Operador: "+ $("#seloperador").val())
                //$("#opnombre2").text("Nombre: "+ $("#seloperador option:selected").html())
                //$("#optrans2").text("Transacciones: " + t)
                //$("#oppuntos2").text("Puntos: " + p)
                $("#cont").html(datos)
                $("#emergente").fadeOut("normal")
            });
            EmergenteDetalles()
        }   
    })
    $("#tabpa tr").live("dblclick",function(){
        if($(this).find(".idoperador").val() != "0"){
            //alert($(this).find(".idoperador").val())
             $("#cont").html("")
             $.ajax({  url: "../ajax/ReportePuntosSimple.php",  type: "POST", dataType: "html", beforeSend : function(){ Emergente() } , data: { idoperador : $(this).find(".idoperador").val(), tipo: 9 }}).done(function(datos){
                //$("#opid2").text("Id De Operador: "+ $("#seloperador").val())
                //$("#opnombre2").text("Nombre: "+ $("#seloperador option:selected").html())
                //$("#optrans2").text("Transacciones: " + t)
                //$("#oppuntos2").text("Puntos: " + p)
                $("#cont").html(datos)
                $("#emergente").fadeOut("normal")
            });
            EmergenteDetalles()
        }   
    })
    
    $("#tabcorr tr").live("dblclick",function(){
        if($(this).find(".idoperador").val() != "0"){
            $("#cont").html("")
            //alert($(this).find(".idoperador").val())
             $.ajax({  url: "../ajax/ReportePuntosSimple.php",  type: "POST", dataType: "html", beforeSend : function(){ Emergente() } , data: { idoperador : $(this).find(".idoperador").val(), tipo: 6 }}).done(function(datos){
                //$("#opid2").text("Id De Operador: "+ $("#seloperador").val())
                //$("#opnombre2").text("Nombre: "+ $("#seloperador option:selected").html())
                //$("#optrans2").text("Transacciones: " + t)
                //$("#oppuntos2").text("Puntos: " + p)
                $("#cont").html(datos)
                $("#emergente").fadeOut("normal")
            });
            
            EmergenteDetalles()
        }   
    })
    
    
    $("#exportar").click(function(){
        $("#datos").val( $("<div>").append( $("#tabpm").eq(0).clone()).html());
	$("#formularioexcel").submit();
    })
    
})