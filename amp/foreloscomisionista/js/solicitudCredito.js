function CapturaSolicitudCredito() {



  var params  = $('#formMovimiento').getSimpleParams();
  var tipos = $('#formMovimiento :input[name=tipo]:checked');

  params.nNumCuenta = $('form[name=formFiltrosCuenta] :input[name=nNumCuenta]').val();

  if(tipos.length != 1){
    jAlert('Seleccione si es Cargo \u00F3 Abono', 'Mensaje');
    return false;
  }

  params.nIdTipo = tipos[0].value;

  if(params.nMonto == undefined || params.nMonto == ''){
    jAlert('Capture Monto', 'Mensaje');
    return false;
  }

  if(params.nMonto <= 0){
    jAlert('Capture un Monto Mayor a Cero', 'Mensaje');
    return false;
  }

  if(params.nIdTipoMovimiento == undefined || params.nIdTipoMovimiento == '' || params.nIdTipoMovimiento <= 0){
    jAlert('Seleccione Tipo de Movimiento', 'Mensaje');
    return false;
  }

  var sDescripcion = $('#formMovimiento :input[name=sDescripcion]').val();

  if(sDescripcion == undefined){
    jAlert('Capture Descripci\u00F3n', 'Mensaje');
    return false;
  }

  if(sDescripcion.trim() == ''){
    jAlert('Capture Descripci\u00F3n', 'Mensaje');
    return false;
  }

  params.sDescripcion = sDescripcion.trim();

  if(params.nIdTipoMovimiento == 11 && params.nIdTipo == 2){
    if(params.dFechaCobro == undefined || params.dFechaCobro == ''){
      jAlert('Seleccione una Fecha de Cobro', 'Mensaje');
      return false;
    }

    var hoy   = fnHoy();
    var diff  = restaFechas(hoy, params.dFechaCobro);

    if(diff < 0){
      jAlert('Seleccione una Fecha de Cobro Igual o Posterior al D\u00EDa de Hoy', 'Mensaje');
      return false;
    }

    var tiposCobro = $('#formMovimiento :input[name=nIdTipoCobro]:checked');

    if(tiposCobro.length != 1){
      jAlert('Seleccione si es Cobro con Cargo a Forelo o Dep\u00F3sito en Banco', 'Mensaje');
      return false;
    }
  }


  jConfirm('\u00BFDesea Continuar\u003F', 'Confirmaci\u00F3n', function(r){
    if(r==true){
      showSpinner();
      var rutaForelosComisionista=BASE_PATH+"/amp/foreloscomisionista/controllers/CapturaSolicitudCredito.php"; 
      let formData = new FormData();
      formData.append('tipo', $('input:radio[name=tipo]:checked').val() );
      formData.append('nIdTipoCobro', $('input:radio[name=nIdTipoCobro]:checked').val() );
      formData.append('nIdTipoMovimiento', $('#nIdTipoMovimiento').val() );
      formData.append('nMonto', $('input[name=nMonto]').val() );
      formData.append('sDescripcion', $('input[name=sDescripcion]').val() );
      formData.append('dFechaCobro', $('input[name=dFechaCobro]').val() );
      formData.append('nNumCuenta', $('#nNumCuenta').val() );
      formData.append('idU', $('input[name=idU]').val() );
      var producto="";
      $.ajax({
        url: rutaForelosComisionista,
        data: formData,
        type: "post",
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false
      }).done(function(resp) {
          var obj =  (resp.data.data);
          jAlert(resp.sMensaje, 'Mensaje');
          if(resp.nCodigo == 0){
            $('#modal-captura_movimiento').modal('hide');
            buscarMovimientos();
          }
         
      }).fail(function(resp){
              alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
      }).always(function(){
          hideSpinner();
      });
      
    }
  });
    
}
