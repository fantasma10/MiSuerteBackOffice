var error = 0;
var msg = '';
$(function(){
    $( "#abrirModalGrupos" ).click(function() {
        $("#modalBanner").modal("show");
    });
    $( "#btnCerrar" ).click(function() {
        let bool=confirm("¿Estas seguro que deseas salir? \n Se perderán tus cambios");
        if(bool){
            $("#txtGrupo").val('');
            $("#txtAreaDescripcion").val('');
            $("#tbodyCadenasEnGrupo").html('');
            $("#modalBanner").modal("hide");
            $("#showTable").hide();
        }
    });
    $( "#btnCerrarReporte" ).click(function() {
            $("#modalBannerReporte").modal("hide");
            $('#modalBanner').modal('show');
    });
    $( "#txtGrupo" ).change(function() {
      let nIdGrupo = $( "#nIdGrupo" ).val();
        if (nIdGrupo == 0) {
            consultarCadenasEnGrupo(nIdGrupo);
        }
    });
    $( "#btnAceptar" ).click(function() {
        let nIdGrupo = $( "#nIdGrupo" ).val();
        msg = '';
        error = 0;
        if( $("#txtGrupo").val() ==''){
            msg += 'El nombre es obligatorio \n';
            error ++;
            } 
            if($("#txtAreaDescripcion").val() ==''){
            msg += 'La descripción es obligatoria \n';
            error ++;
            }
            if (error > 0) {
            jAlert(msg);
            }else{
            GuardaClasificacion();
            }

    });
    $( "#apartadoBanner" ).click(function() {
        consultaImagenesCarrusel(0);
        $('#conenedorImg').show('fast');
        $('#imgBanner').val('');
        $("#showTableOrden").hide('fast');
        cancelaImg();
    });
    $( "#abrirModalGruposReporte" ).click(function() {
        abrirModalGruposReporte();
    });

});

function validacionAnuncio(){
    msg = '';
    if( $("#txtNombre").val() ==''){
        msg += 'El nombre es obligatorio \n';
        error ++;
    } 
    if($("#txtDescripcion").val() ==''){
        msg += 'La descripción es obligatoria \n';
        error ++;
    }
    validaTamanoImg('imgAnuncio','Imagen');
    validaImgReal('imgAnuncio','Imagen');
    if (error > 0) {
        jAlert(msg);
        
    }else{
        guardarConf_facturacionAnuncio();
    }
}

function validacionBanner(){
    msg = '';
    if( $("#txtNombreBanner").val() ==''){
        msg += 'El nombre es obligatorio \n';
        error ++;
    }
    validaTamanoImg('imgBanner','Imagen Banner 1');
    validaImgReal('imgBanner','Imagen Banner 1');

    validaTamanoImg('imgBanner2','Imagen Banner 2');
    validaImgReal('imgBanner2','Imagen Banner 2');

    validaTamanoImg('imgBanner3','Imagen Banner 3');
    validaImgReal('imgBanner3','Imagen Banner 3');
    if (error > 0) {
        jAlert(msg);
        
    }else{
        guardarConf_facturacionBanner();
    }
}


function validaTamanoImg(elementoImg = '', text =''){
    if ($('#'+elementoImg)[0].files[0]) {
       if($('#'+elementoImg)[0].files[0].size > 2000000){
            msg += 'El campo '+text+' no puede exceder los 2MB \n';
            error ++;
        } 
    }
}
function validaImgReal(elementoImg = '',text =''){
    let fileName = '';
    if ($('#'+elementoImg)[0].files[0]) {
        fileName = $('#'+elementoImg)[0].files[0].name.replace(' ','');
        if (!(/\.(PNG|png|JPEG|jpeg|JPG|jpg|WEBP|webp|SVGZ|svgz|BMP|bmp|GIF|gif|TIFF|tiff|SVG|svg|TIF|tif)$/i).test(fileName)) {
            msg += 'El campo '+text+' no es una imagen \n';
            error ++;
        }
    }
}


function guardarConf_facturacionAnuncio(){
    var data=[];
    showSpinner();
    let formData = new FormData();
    formData.append('txtNombre', $("#txtNombre").val());
    formData.append('txtDescripcion', $("#txtDescripcion").val());
    formData.append('imgAnuncio', $('#imgAnuncio')[0].files[0]);

    $.ajax({
        url: "../ajax/C_Guardar_conf_anuncio.php",
        type: "post",
        dataType: "json",
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    })
    .done(function(res){
            let dataResponse = res.data;
            if (dataResponse.responseAWS == 1) {
                jAlert('Anuncio guardado correctamente');
                $("#txtNombre").val('')
                $("#txtDescripcion").val('')
                $('#imgAnuncio').val('');
            }else{
                jAlert("Error al guardar archivo");
            }
    }).fail(function(resp){
        jAlert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
    }).always(function(){
        hideSpinner();
    });   
}

function guardarConf_facturacionBanner(){
    var data=[];
    showSpinner();
    let formData = new FormData();
    formData.append('txtNombreBanner', $("#txtNombreBanner").val());
    formData.append('imgBanner', $('#imgBanner')[0].files[0]);
    formData.append('imgBanner2', $('#imgBanner2')[0].files[0]);
    formData.append('imgBanner3', $('#imgBanner3')[0].files[0]);

    $.ajax({
        url: "../ajax/guardar_conf_banner.php",
        type: "post",
        dataType: "json",
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    })
    .done(function(res){
            let dataResponse = res.data;
            if (dataResponse.responseAWS == 1 && dataResponse.responseAWS2 == 1 && dataResponse.responseAWS3 == 1) {
                jAlert('Banners guardados correctamente');
            }else{
                jAlert("Error al guardar los banners");
            }
    }).fail(function(resp){
        jAlert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
    }).always(function(){
        hideSpinner();
    }); 
}

function buscaGrupo() {
    if($("#txtGrupo").length){  
        $("#nIdGrupo").val('0'); 
                 
            $("#txtGrupo").autocomplete({

                source: function( request, respond ) {
                    var arrayData=[{
                                    'case':1,
                                    'sNombreGrupo':request.term
                                    }];  
                    $.post(BASE_PATH+"/amp/anuncios/ajax/consultar_grupos.php",{ data: arrayData[0] },
                    function( response ) {
                        respond(response.data.data);
                    }, "json" );                    
                },
                minLength: 1,
                focus: function( event, ui ) {
                    $("#txtGrupo").val(ui.item.sNombre);
                    return false;
                },
                select: function( event, ui ) {
                    $("#nIdGrupo").val(ui.item.nIdGrupo);
                    $("#txtAreaDescripcion").val(ui.item.sDescripcion);
                    consultarCadenasEnGrupo(ui.item.nIdGrupo);
                    return false;
                }
            })
            .data("ui-autocomplete")._renderItem = function( ul, item ) {
                return $('<li>')
                .append( "<a>"+item.sNombre+"</a>" )
                .appendTo( ul );
            }
    }    
}

function consultarCadenasEnGrupo(nIdGrupo){
    var tbody = '';
    showSpinner();
    var arrayData=[{
                    'nIdGrupo':nIdGrupo,
                    'case':2
                    }];
    $.post(BASE_PATH+"/amp/anuncios/ajax/consultar_grupos.php",{data: arrayData[0]},
    function(response){
        let obj = response.data.data;
        let checkedExiste = '';
        $("#showTable").show('fast');
        $.each(obj, function(index, value) {
            if(obj[index]['existe'] == 1){
                checkedExiste = 'checked';
            }
            tbody += '<tr>';
                tbody += '<td class="text-center"><label for ="check'+obj[index]['nIdCadena']+'">'+obj[index]['sNombre']+'</label></td>';
                tbody += '<td class="text-center"><input type="checkbox" id="check'+obj[index]['nIdCadena']+'" '+checkedExiste+' value="'+obj[index]['nIdCadena']+'"></td>';
            tbody += '</tr>';   
            checkedExiste = '';
        });
        $("#tbodyCadenasEnGrupo").html(tbody);
    }, "json" ).fail(function(resp){
        jAlert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
    }).always(function(){
        hideSpinner();
    }); 
}
function GuardaClasificacion(){
    showSpinner();
    var nIdCadenas=[];
    $("input:checkbox:checked").each(function() {
        if ($(this).val()>0){
            nIdCadenas.push($(this).val());
        }
    });
    let arrayData=[{                        
                    'sNombre':$("#txtGrupo").val(),                     
                    'sDescripcion':$("#txtAreaDescripcion").val(),
                    'nIdGrupo':$( "#nIdGrupo" ).val(),
                    'case':3,
                    'nIdCadenas':nIdCadenas
                  }];

    $.post(BASE_PATH+"/amp/anuncios/ajax/consultar_grupos.php",{data: arrayData[0]},
    function(response){
        let obj = response.data.data[0];
        if (obj.nCodigo == 0) {
            jAlert(obj.sMensaje);
            $("#txtGrupo").val('');
            $("#txtAreaDescripcion").val('');
            $("#tbodyCadenasEnGrupo").html('');
            $("#modalBanner").modal("hide");
            $("#showTable").hide();
        }else{
            jAlert(obj.sMensaje);
        }
    }, "json" ).fail(function(resp){
        alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
    }).always(function(){
        hideSpinner();
    });
}
function consultaImagenesCarrusel(nIdCarrusel) {
    var divContent = '';
    showSpinner();
    var arrayData=[{
                    'nIdCarrusel':nIdCarrusel,
                    'nOpcion':1,
                    'case':4
                    }];
    $.post(BASE_PATH+"/amp/anuncios/ajax/consultar_grupos.php",{data: arrayData[0]},
    function(response){
        let obj = response.data.data;
        let checkedExiste = '';
        $.each(obj, function(index, value) {
            if (obj[index]['sImagen'] != null) {
                divContent += '<div class="col-md-4">';
                    divContent += '<input id="'+obj[index]['nIdCarrusel']+'" class="radioCheckMain" type="radio" name="radio" value="'+obj[index]['nIdCarrusel']+'" onchange="consultaGruposOrden('+obj[index]['nIdCarrusel']+')"/>';
                    divContent += '<label class="" for="'+obj[index]['nIdCarrusel']+'">';
                        divContent += '<img src="'+obj[index]['sImagen']+'" width="150" height="150" class="img-responsive">';
                    divContent += '</label>';
                divContent += '</div>';
            }
        });
        $("#conenedorImg").html(divContent);
    }, "json" ).fail(function(resp){
        jAlert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
    }).always(function(){
        hideSpinner();
    });  
}
function consultaGruposOrden(nIdCarrusel) {
    $("#showTableOrden").show('fast');
    var divContent = '';
    showSpinner();
    var arrayData=[{
                    'nIdCarrusel':nIdCarrusel,
                    'nOpcion':2,
                    'case':4
                    }];
    $.post(BASE_PATH+"/amp/anuncios/ajax/consultar_grupos.php",{data: arrayData[0]},
    function(response){
        let obj = response.data.data;
        let tbody = '';
        let checkedExiste = '';
        let checkedExisteOrden1 = '';
        let checkedExisteOrden2 = '';
        let checkedExisteOrden3 = '';
        let disableOrden1 = '';
        let disableOrden2 = '';
        let disableOrden3 = '';
        $.each(obj, function(index, value) {
            
            if(obj[index]['nOrden1'] == 1){
                checkedExisteOrden1 = 'checked';
            }else{
                disableOrden1= 'disabled';
            }
            if(obj[index]['nOrden2'] == 2){
                checkedExisteOrden2 = 'checked';
            }else{
                disableOrden2= 'disabled';
            }
            if(obj[index]['nOrden3'] == 3){
                checkedExisteOrden3 = 'checked';
            }else{
               disableOrden3 = 'disabled';
            }
            if(obj[index]['existe'] == 1){
                checkedExiste = 'checked';
                disableOrden1 = '';
                disableOrden2 = '';
                disableOrden3 = '';
            }
            tbody += '<tr>';
                tbody += '<td class="text-center">'+obj[index]['sNombre']+'</td>';
                tbody += '<td class="text-center"><input type="checkbox" class="checkboxExisteImg" id="checkGrupo'+obj[index]['nIdGrupo']+'" '+checkedExiste+' value="'+obj[index]['nIdGrupo']+'" onchange="boolRadios(\'radioOrden'+obj[index]['nIdGrupo']+'\',\'checkGrupo'+obj[index]['nIdGrupo']+'\')"></td>';
                tbody += '<td class="text-center"><input type="radio" id="'+obj[index]['nIdGrupo']+'" '+disableOrden1+' class="radioOrden radioOrden'+obj[index]['nIdGrupo']+'" name="'+obj[index]['nIdGrupo']+'" '+checkedExisteOrden1+' value="1"></td>';
                tbody += '<td class="text-center"><input type="radio" id="'+obj[index]['nIdGrupo']+'" '+disableOrden2+' class="radioOrden radioOrden'+obj[index]['nIdGrupo']+'" name="'+obj[index]['nIdGrupo']+'" '+checkedExisteOrden2+' value="2"></td>';
                tbody += '<td class="text-center"><input type="radio" id="'+obj[index]['nIdGrupo']+'" '+disableOrden3+' class="radioOrden radioOrden'+obj[index]['nIdGrupo']+'" name="'+obj[index]['nIdGrupo']+'" '+checkedExisteOrden3+' value="3"></td>';
            tbody += '</tr>';   
            checkedExiste = '';
            checkedExisteOrden1 = '';
            checkedExisteOrden2 = '';
            checkedExisteOrden3 = '';
        });
        $("#tbodyGruposOrden").html(tbody);
    }, "json" ).fail(function(resp){
        jAlert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
    }).always(function(){
        hideSpinner();
    });  
}
function guardaGrupoCarruselOrden(){
    showSpinner();
    let nIdGrupos=[];
    let nIdOrdens=[];
    $(".checkboxExisteImg:checked").each(function() {
        if ($(this).val()>0){
            nIdGrupos.push($(this).val());
        }
    });

    $(".radioOrden:checked").each(function() {
        if ($(this).val()>0){
            nIdOrdens.push($(this).val());
        }
    });
    let nIdCarruselx =  $("input[name='radio']:checked").val();
    if (nIdCarruselx == undefined) {
        nIdCarruselx = 0;
    }
    let formData = new FormData();
    formData.append('nIdCarrusel', nIdCarruselx);
    formData.append('nIdGrupos', nIdGrupos);
    formData.append('nIdOrdens', nIdOrdens);
    formData.append('imgBanner', $('#imgBanner')[0].files[0]);
    formData.append('case', 5);

    $.ajax({
        url: BASE_PATH+"/amp/anuncios/ajax/consultar_grupos.php",
        type: "post",
        dataType: "json",
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    })
    .done(function(res){
        let obj = res.data[0];
        if (obj.nCodigo == 0) {
            jAlert(obj.sMensaje);
            $("#showTableOrden").hide();
            $("#tbodyGruposOrden").html('');
            cancelaImg();
        }else{
            jAlert(obj.sMensaje);
        }
    }).fail(function(resp){
        jAlert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
    }).always(function(){
        hideSpinner();
    }); 
}

function validacionBannerList(){
    msg = '';
    error = '';
    let banderaImg = '';
    if ($('#imgBanner')[0].files[0]) {
        validaTamanoImg('imgBanner','Imagen');
        validaImgReal('imgBanner','Imagen');
    }else{
        banderaImg = 1;
    }
    let  datoradiogeneral = $("input[name='radio']:checked").val();
    if (datoradiogeneral == undefined || datoradiogeneral == null) {
        datoradiogeneral = '';
    }
    if (banderaImg == 1 &&  datoradiogeneral =="") {
        msg = 'No se selecciono una Imagen';
        error = 1;
    }
    if (error > 0) {
        jAlert(msg);
    }else{
        guardaGrupoCarruselOrden();
    }
}
function cancelaImg(){
    $('#imgPreview').hide('fast');
        $('#conenedorImg').show('fast');
        consultaImagenesCarrusel(0);
        $('#divCancela').hide('fast');
        $('#imgBanner').val('');
}
function validaImgNueva(){

    if ($('#imgBanner')[0].files[0]) {
        $('.radioCheckMain').attr('checked',false);
        $('#conenedorImg').html('');
        $('#conenedorImg').hide('fast');
        consultaGruposOrden(0);
        $('#imgPreview').show('fast');
        $('#imgPreview').attr('src', URL.createObjectURL($('#imgBanner')[0].files[0]));
        $('#divCancela').show('fast');
    }else{
        $('#imgPreview').hide('fast');
        $('#conenedorImg').show('fast');
        consultaImagenesCarrusel(0);
        $('#divCancela').hide('fast');
        $('#imgBanner').val('');
    }

}

function boolRadios(claseAfectar,idCheckBoxGrupo){
    if ($('#'+idCheckBoxGrupo).is(':checked')) {
        $('.'+claseAfectar).attr('disabled',false);
    }else{
        $('.'+claseAfectar).attr('checked',false);
        $('.'+claseAfectar).attr('disabled','disabled');
    }
}

function abrirModalGruposReporte(){
    
    $('#modalBanner').modal('hide');
    $('#modalBannerReporte').modal('show');
    consultarGruposReporte();

}

function consultarGruposReporte(){
    var tbody = '';
    showSpinner();
    var arrayData=[{
                    'case':6
                    }];
    $.post(BASE_PATH+"/amp/anuncios/ajax/consultar_grupos.php",{data: arrayData[0]},
    function(response){
        let obj = response.data.data;
        let checkedExiste = '';
        $("#showTable").show('fast');
        $.each(obj, function(index, value) {
            if(obj[index]['existe'] == 1){
                checkedExiste = 'checked';
            }
            tbody += '<tr>';
                tbody += '<td class="text-center">'+obj[index]['dFecRegistro']+'</td>';
                tbody += '<td class="text-center">'+obj[index]['sNombre']+'</td>';
                tbody += '<td class="text-center">'+obj[index]['TotalCadenas']+'</td>';
            tbody += '</tr>';   
            checkedExiste = '';
        });
        $("#tbodyGrupos").html(tbody);
    }, "json" ).fail(function(resp){
        jAlert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
    }).always(function(){
        hideSpinner();
    }); 
}