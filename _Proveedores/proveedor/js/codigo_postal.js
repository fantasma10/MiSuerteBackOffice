//para los combos de direccion
document.addEventListener('DOMContentLoaded', function () {
	var txtCP = document.getElementById('txtCP');

	if (txtCP) {
		txtCP.addEventListener('keyup', buscar_cp);
	}
});

function buscar_cp(e) {
	e.preventDefault();

	(e.keyCode);
	var code = e.keyCode || e.which;
	if (code != '9') {//tab
		var cp = e.target.value;
		buscarColonias(cp);
	}
}

function buscarColonias(nCodigoPostal, nIdColonias) {
	var idColonia = nIdColonias
	if (nCodigoPostal == undefined) {
		resetDatosColonias();
		return false;
	}

	var sCodigoPostal = customTrim(nCodigoPostal.toString());

	resetDatosColonias();
	if (sCodigoPostal.length > 5) {
		resetDatosColonias();
		return false;
	}

	if (sCodigoPostal.length < 5 || sCodigoPostal.length > 5) {
		resetDatosColonias();
		return false;
	}

	$.ajax({
		url: '../ajax/codigoPostal.php',
		type: 'POST',
		dataType: 'json',
		data: { tipo: 1, nCodigoPostal: sCodigoPostal }
	})
		.done(function (resp) {
			if (resp.bExito == true) {
				customLlenarComboColonia('cmbColonia', resp.data);
				customLlenarComboCiudad('cmbCiudad', resp.data);
				customLlenarComboEstado('cmbEntidad', resp.data);

				if (idColonia == undefined) {

				} else {
					$('#cmbColonia').val(idColonia);
					// $('#cmbColonia').prop('disabled', true);
				}

			}
		})
		.fail(function () { }).always(function () { });
}

function customTrim(txt) {
	txt = txt.toString();
	return txt.replace(/^\s+|\s+$/g, '');
}

function customEmptyStore(id) {
	var cmb = document.getElementById(id);
	var i;
	for (i = cmb.options.length - 1; i >= 0; i--) {
		cmb.remove(i);
	}
}

function resetDatosColonias() {
	customEmptyStore('cmbColonia');
	customEmptyStore('cmbEntidad');
	customEmptyStore('cmbCiudad');
}

//cmbColonia,cmbEntidad,cmbCiudad
function customLlenarComboEstado(id, data) {
	customEmptyStore('cmbEntidad');
	var cmb = document.getElementById(id);
	var option = document.createElement("option");

	if (typeof option.textContent === 'undefined') {
		option.innerText = data[0].sDEstado;
	}
	else {
		option.textContent = data[0].sDEstado;
		option.value = data[0].nIdEstado;
		//console.log("id_entidad:"+data[0].nIdEstado+"entidad: "+data[0].sDEstado);
	}
	option.value = data[0].nIdEstado;
	cmb.appendChild(option);
}

function customLlenarComboCiudad(id, data) {
	customEmptyStore('cmbCiudad');
	var cmb = document.getElementById(id);
	var option = document.createElement("option");

	if (typeof option.textContent === 'undefined') {
		option.innerText = data[0].sDMunicipio;
	}
	else {
		option.textContent = data[0].sDMunicipio;
		option.value = data[0].nNumMunicipio;
		//console.log("num_municipio:"+data[0].nNumMunicipio+"municipio: "+data[0].sDMunicipio);
	}
	option.value = data[0].nNumMunicipio;
	cmb.appendChild(option);
}

function customLlenarComboColonia(id, data) {
	var data = data;
	var length = data.length;
	var cmb = document.getElementById(id);

	customEmptyStore('cmbColonia');

	for (var i = 0; i < length; i++) {
		var option = document.createElement("option");
		option.text = data[i].sNombreColonia;

		if (typeof option.textContent === 'undefined') {
			option.innerText = data[i].sNombreColonia;
		}
		else {
			option.textContent = data[i].sNombreColonia;
		}
		option.value = data[i].nIdColonia;
		cmb.appendChild(option);
	}
}