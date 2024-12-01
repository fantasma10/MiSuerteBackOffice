var nivelDeterminado = 0;
var familiasSeleccionadas = new Array();
var idAfiliacion = 0;

$(function(){
	$("#guardarNivel").on("click", function( index ){
		guardarNivel();
	});
	buscarPaquete(null, desplegarPaquete);

	if(!ES_ESCRITURA){
		$(':input').prop('readonly', true);
		$('select').prop('disabled', true);

		$('.boton_guardar').remove();
	}

	if(!ES_CONSULTA){
		$('.esconsulta').hide();
		$('.noesconsulta').show();
	}
	else{
		$('.esconsulta').show();
		$('.noesconsulta').hide();
	}
});

function buscarPaquete( idNivel, callback ) {
	$.post( "../../inc/Ajax/_Afiliaciones/buscarPaquete.php",
	{ idNivel: idNivel },
	function ( respuesta ) {
		if ( respuesta.codigo == 0 ) {
			callback(respuesta.paquetes, respuesta.niveles, respuesta.familias);
		} else {
			alert( respuesta.mensaje );
		}
	}, "json");
}

function desplegarPaquete( paquetes, niveles, familias ) {
	if ( paquetes ) {
		var contenido = "";
		var totalResultados = paquetes.idNivel.length;
		if ( totalResultados > 0 ) {
			var expedienteNuevo = false;
			for ( var i = 0; i <= totalResultados; i++ ) {
				if ( expedienteNuevo ) {
					i--;
				}
				nivelActual = paquetes.idNivel[i];
				contenido += "<div class=\"col-xs-4\">";
				contenido += "<div class=\"paquetes expediente\" id=\"" + paquetes.idNivel[i] + "\">";
				contenido += "<h6><i class=\"fa fa-file\"></i>  Expediente</h6>";
				contenido += "<h5>" + paquetes.nombreNivel[i] + "</h5>";
				contenido += "<ul id=\"paquetes-lista\">";
				while ( nivelActual == paquetes.idNivel[i] ) {
					contenido += "<li>";
					contenido += "<div class=\"view\">";
					contenido += "<input type=\"checkbox\" class=\"familiaCheckbox\" id=\"" + paquetes.idNivel[i] + "-" + paquetes.idFamilia[i] + "\">";
					contenido += "<label>" + paquetes.descripcionFamilia[i] + "</label>";
					contenido += "</div>";
					contenido += "</li>";
					i++;
				}
				contenido += "</ul>";
				contenido += "</div>";
				contenido += "</div>";
				expedienteNuevo = true;
			}
			$("#seccion-paquetes").html(contenido);
			if ( HAY_SELECCION && !HAY_CLIENTE ) {
				cargarAfiliacion( niveles, familias );
			} else {
				$("#encabezadoCliente").html("Nuevo Cliente");
			}
			if ( HAY_CLIENTE ) {
				cargarCliente( CLIENTE_SELECCION, niveles, familias );
			} else {
				$("#encabezadoCliente").html("Nuevo Cliente");
			}
			$(".view, .views").on("click", function( e ){
				if ( e.target.tagName == "DIV" || e.target.tagName == "LABEL" ) {
					$(this).children("input").each(function( index ){
						if ( $(this).is(":checked") ) {
							$(this).prop("checked", false);
						} else {
							$(this).prop("checked", true);
						}
						analizarSeleccion($(this), paquetes, niveles, familias);
					});
				} else if ( e.target.tagName == "INPUT" ) {
					$(this).children("input").each(function( index ) {
						analizarSeleccion($(this), paquetes, niveles, familias);
					});
				}
			});
		}
	}
}

function analizarSeleccion( checkbox, paquetes, niveles, familias ) {
	if ( checkbox && paquetes && niveles && familias ) {
		if ( checkbox.is(":checked") ) {
			var id = checkbox.attr("id");
			var idNivelSeleccion = id.split("-")[0];
			var idFamiliaSeleccion = id.split("-")[1];
			if ( idNivelSeleccion > nivelDeterminado ) {
				marcarNoSeleccionadoExpediente( nivelDeterminado );
				var nombreNivelSeleccion = niveles.nombreNivel[idNivelSeleccion-1];
				nivelDeterminado = idNivelSeleccion;
				$("#nivelDeterminado").html(nombreNivelSeleccion);
			}
			var nombreFamiliaSeleccion = familias.nombreFamilia[idFamiliaSeleccion-1];
			var yaExiste = false;
			for ( var i = 0; i < familiasSeleccionadas.length; i++ ) {
				var familia = familiasSeleccionadas[i];
				if ( familia.id == idFamiliaSeleccion ) {
					yaExiste = true;
				}
			}
			if ( !yaExiste ) {
				familiasSeleccionadas.push({ id: idFamiliaSeleccion, nombre: nombreFamiliaSeleccion, nivel: idNivelSeleccion });
			}
			$("#familiasSeleccionadas").empty();
			for ( var i = 0; i < familiasSeleccionadas.length; i++ ) {
				var familia = familiasSeleccionadas[i];
				$("#familiasSeleccionadas").append(familia.nombre);
				if ( i != familiasSeleccionadas.length - 1 ) {
					$("#familiasSeleccionadas").append(", ");
				}
			}
			marcarSeleccionadoExpediente( nivelDeterminado );
		} else {
			marcarNoSeleccionadoExpediente( nivelDeterminado );
			var idNivel;
			nivelDeterminado = 0;
			$(".familiaCheckbox:checked").each(function( index ){
				var id = $(this).attr("id");
				idNivel = id.split("-")[0];
				var idFamilia = id.split("-")[1];
				if ( idNivel > nivelDeterminado ) {
					nivelDeterminado = idNivel;
				}
			});
			marcarSeleccionadoExpediente( nivelDeterminado );
			var id = checkbox.attr("id");
			var idNivelSeleccion = id.split("-")[0];
			var idFamiliaSeleccion = id.split("-")[1];
			var nombreNivelSeleccion = niveles.nombreNivel[nivelDeterminado-1];
			$("#nivelDeterminado").html(nombreNivelSeleccion);
			for ( var i = 0; i < familiasSeleccionadas.length; i++ ) {
				var familia = familiasSeleccionadas[i];
				if ( familia.id == idFamiliaSeleccion ) {
					familiasSeleccionadas.splice(i, 1);	
				}
			}
			$("#familiasSeleccionadas").empty();
			for ( var i = 0; i < familiasSeleccionadas.length; i++ ) {
				var familia = familiasSeleccionadas[i];
				$("#familiasSeleccionadas").append(familia.nombre);
				if ( i != familiasSeleccionadas.length - 1 ) {
					$("#familiasSeleccionadas").append(", ");
				}
			}
		}
		if ( nivelDeterminado == 0 ) {
			$("#nivelDeterminado").empty();
		}
	} else {
		alert("No es posible analizar la selecci\u00F3n. Faltan parametros para determinar el expediente correspondiente.");
	}
}

function marcarSeleccionadoExpediente( nivelDeterminado ) {
	$(".expediente[id=" + nivelDeterminado + "]").each(function( index ){
		$(this).attr("class", "paquetes-active expediente");
		($(this).children("ul")).removeAttr("id");
		(($(this).children("ul")).children("li")).children("div[class=view]").each(function( index ){
			$(this).attr("class", "views");
		});
	});
}

function marcarNoSeleccionadoExpediente( nivelDeterminado ) {
	$(".expediente[id=" + nivelDeterminado + "]").each(function( index ){
		$(this).attr("class", "paquetes expediente");
		($(this).children("ul")).attr("id", "paquetes-lista");
		(($(this).children("ul")).children("li")).children("div[class=views]").each(function( index ){
			$(this).attr("class", "view");
		});
	});
}

function guardarNivel() {
	if ( nivelDeterminado == 0 || familiasSeleccionadas.length == 0 ) {
		alert("No es posible seguir con el proceso porque no se ha seleccionado ninguna familia.");
		return false;
	} else {
		var listaFamilias = "";
		for ( var i = 0; i < familiasSeleccionadas.length; i++ ) {
			listaFamilias += familiasSeleccionadas[i].id;
			if ( i != familiasSeleccionadas.length - 1 ) {
				listaFamilias += "|";
			}
		}
		if ( HAY_CLIENTE ) {
			actualizarFamilias( CLIENTE_SELECCION, listaFamilias );
		} else {
			$("[name='idNivel']").val(nivelDeterminado);
			$("[name='familias']").val(listaFamilias);
			$("[name='idCliente']").val(CLIENTE_SELECCION);
			$("#formSiguiente").submit();
		}
	}
}

function cargarAfiliacion( niveles, familias, familiasObjeto ) {
	var nivel = NIVEL_SELECCION;
	var familiasAfiliacion;
	if ( !familiasObjeto ) {
		familiasAfiliacion = FAMILIAS_SELECCION.split("|");
	} else {
		familiasAfiliacion = familiasObjeto.split("|");	
	}
	marcarSeleccionadoExpediente( nivel );
	$(".familiaCheckbox").each(function( index ){
		var id = $(this).attr("id");
		var paquete = id.split("-")[0];
		var familia = id.split("-")[1];
		for( var i = 0; i < familiasAfiliacion.length; i++ ) {
			if ( familia == familiasAfiliacion[i] ) {
				$(this).prop("checked", true);
			}
		}
	});
	for ( var i = 0; i < familiasAfiliacion.length; i++ ) {
		var nombreFamiliaSeleccion = familias.nombreFamilia[familiasAfiliacion[i]-1];
		familiasSeleccionadas.push({ id: familiasAfiliacion[i], nombre: nombreFamiliaSeleccion, nivel: null });
	}
	//console.log(familiasSeleccionadas);
	$("#familiasSeleccionadas").empty();
	for ( var i = 0; i < familiasSeleccionadas.length; i++ ) {
		var familia = familiasSeleccionadas[i];
		$("#familiasSeleccionadas").append(familia.nombre);
		if ( i != familiasSeleccionadas.length - 1 ) {
			$("#familiasSeleccionadas").append(", ");
		}
	}
	nivelDeterminado = nivel;
	var nombreNivelSeleccion = niveles.nombreNivel[nivel-1];
	$("#nivelDeterminado").html(nombreNivelSeleccion);
}

function getParametro(val) {
	var result = null, tmp = [];
	location.search
	.substr(1)
		.split("&")
		.forEach(function (item) {
		tmp = item.split("=");
		if (tmp[0] === val) result = decodeURIComponent(tmp[1]);
	});
	return result;
}

function cargarCliente( idCliente, niveles, familias ) {
	$.post( "../../inc/Ajax/_Afiliaciones/loadAfiliacion.php",
	{ idAfiliacion : idCliente },
	function( respuesta ) {
		if ( respuesta.showMsg == 0 ) {
			/*switch ( respuesta.data.tipoPersona ) {
				case "1":
					$("#encabezadoCliente").html( respuesta.data.nombrePersona + " " + respuesta.data.apPPersona + " " + respuesta.data.apMPersona );
				break;
				case "2":
					$("#encabezadoCliente").html( respuesta.data.razonSocial );
				break;
				case "3":
					if ( respuesta.data.nombrePersona != "" && respuesta.data.apPPersona != "" && respuesta.data.apMPersona != "" ) {
						$("#encabezadoCliente").html( respuesta.data.nombrePersona + " " + respuesta.data.apPPersona + " " + respuesta.data.apMPersona );
					} else {
						$("#encabezadoCliente").html( respuesta.data.razonSocial );
					}
				break;
				default:
					$("#encabezadoCliente").html( "Nuevo Cliente" );
			}*/
			NIVEL_SELECCION = respuesta.data.idNivel;
			$("#encabezadoCliente").html(respuesta.data.nombreCompletoCliente);
			cargarAfiliacion( niveles, familias, respuesta.data.familias );
		} else {
			alert( respuesta.mensaje );
		}
	}, "json");
}

function actualizarFamilias( idCliente, listaFamilias ) {
	$.post( "../../inc/Ajax/_Afiliaciones/actualizarFamilias.php",
	{ idCliente: idCliente, nuevasFamilias: listaFamilias, idNivel: nivelDeterminado },
	function( respuesta ) {
		if ( respuesta.codigo == 0 ) {
			$("[name='idNivel']").val(nivelDeterminado);
			$("[name='familias']").val(listaFamilias);
			$("[name='idCliente']").val(CLIENTE_SELECCION);
			if(!ES_CONSULTA){
				$("#formSiguiente").submit();
			}
		} else {
			alert( respuesta.mensaje );
		}
	}, "json");
}