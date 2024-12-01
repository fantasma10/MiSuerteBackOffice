function getXMLHTTPRequest(){
		try{
			xhttp = new XMLHttpRequest();
		}catch(err1){
			try {
				xhttp = new ActiveXObject("Msxml2.XMLHTTP");
			}catch (err2) {
				try {
					xhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}catch (err3) {
					xhttp = false;
				}
			}
		}
		return xhttp;
	}
	
	var http = getXMLHTTPRequest();
	
var error="";


function Modificar(BAct1, BAct2, BCan, Cont){
	document.getElementById(BAct1).style.display="none";
	document.getElementById(BAct2).style.display="block";
	document.getElementById(BCan).style.display="block";
	document.getElementById(Cont).style.display="block";
}

function Cancelar(BAct1,BAct2,BCan,Cont,Valor){
	document.getElementById(BAct1).style.display="block";
	document.getElementById(BAct2).style.display="none";
	document.getElementById(BCan).style.display="none";
	document.getElementById(Cont).style.display="none";
	document.getElementById(Valor).value="";
}

function Aceptar(BAct1,BAct2,BCan,Cont,Bacept,RespS,Valor){
	document.getElementById(BAct1).style.display="block";
	document.getElementById(BAct2).style.display="none";
	document.getElementById(BCan).style.display="none";
	document.getElementById(Cont).style.display="none";
	document.getElementById(Bacept).style.display="none";
	document.getElementById(RespS).style.display="none";
	document.getElementById(Valor).value="";
}

function otra(tipoliq,selectipoLiq,selectipoLiq2,tipoliq2){
	var tipo = document.getElementById(tipoliq).value;//alert(tipo);
	
	if( tipo == 5 ){
		document.getElementById(selectipoLiq2).style.display="block";
		document.getElementById(tipoliq).disabled=true;
		document.getElementById(tipoliq2).disabled=false;
	}else{
		document.getElementById(selectipoLiq).style.display="block";
		document.getElementById(selectipoLiq2).style.display="none";
		document.getElementById(tipoliq2).disabled=true;
	}
}

function volverotra(tipoliq,selectipoLiq,selectipoLiq2,tipoliq2){
	document.getElementById(selectipoLiq).style.display="block";
	document.getElementById(selectipoLiq2).style.display="none";
	document.getElementById(tipoliq).disabled=false;
	document.getElementById(tipoliq2).disabled=true;
}

function selecB(CORR,SUB,CAD,IDENT,SELEC){
	if(IDENT==1){
		document.getElementById(CORR).style.display="block";
		document.getElementById(SUB).style.display="none";
		document.getElementById(CAD).style.display="none";
		document.getElementById(SELEC).style.display="none";
	}else{if(IDENT==2){
			document.getElementById(CORR).style.display="none";
			document.getElementById(SUB).style.display="block";
			document.getElementById(CAD).style.display="none";
			document.getElementById(SELEC).style.display="none";
		}else{if(IDENT==3){
				document.getElementById(CORR).style.display="none";
				document.getElementById(SUB).style.display="none";
				document.getElementById(CAD).style.display="block";
				document.getElementById(SELEC).style.display="none";
			}
		}
	}
}
//===============================================================================
//====================== Calendario =========================================================
function calendario(cas,cal){ //alert(cas+"-"+cal);
				new Calendar({ 
                          inputField: cas,
                          dateFormat: "%Y-%m-%d",
                          trigger: cal,
                          bottomBar: false,
                          onSelect: function(){
                                  var date = Calendar.intToDate(this.selection.get());
                                  
                                  this.hide();
                          }
                  });
				new Calendar({ 
                          inputField: cas,
                          dateFormat: "%Y-%m-%d",
                          trigger: cal,
                          bottomBar: false,
                          onSelect: function(){
                                  var date = Calendar.intToDate(this.selection.get());
                                  
                                  this.hide();
                          }
                  });
			}
//===============================================================================
//====================== Imprimir Operaciones de un Corresponsal segun fechas ===================================================
function envDconsultOperaciones(fec1,fec2,idCad,idSubCad,idCorr){
	var fecha1 = document.getElementById(fec1).value;
	var fecha2 = document.getElementById(fec2).value;
	var Aleatorio = Math.random();
			
	return  "fecha1="+fecha1+
			"&fecha2="+fecha2+
			"&idCad="+idCad+
			"&idSubCad="+idSubCad+
			"&idCorr="+idCorr+
			"&Aleatorio="+Aleatorio;
}
function consultOperaciones(fec1,fec2,RES,idCad,idSubCad,idCorr)
{
	http.open("POST", "../../inc/AjaxOperacion/consultarOperaciones.php", true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	var datconsultOperaciones=envDconsultOperaciones(fec1,fec2,idCad,idSubCad,idCorr);
	
	http.onreadystatechange=function() 
	{ 
		if (http.readyState==1)
		{
			document.getElementById(RES).style.display="none";
			document.getElementById(RES).style.display="block";
			document.getElementById(RES).innerHTML = '<div aling="center"><img src="../../img/loadAJAX.gif" /></div>';	
		}
		if (http.readyState==4)
		{
			var RespuestaServidor = http.responseText;
			document.getElementById(RES).innerHTML = RespuestaServidor;
		} 
	}
	http.send(datconsultOperaciones);
}
//===============================================================================
//====================== Siguiente de n en n ===================================================
function envDsiguientePop(nPag,idCad,idSubCad,idCorr,sigAtras,pAct,total,depxPag){
	var Aleatorio = Math.random();
			
	return  "nPag="+nPag+
			"&sigAtras="+sigAtras+
			"&idCad="+idCad+
			"&idSubCad="+idSubCad+
			"&idCorr="+idCorr+
			"&pAct="+pAct+
			"&total="+total+
			"&depxPag="+depxPag+
			"&Aleatorio="+Aleatorio;
}
function siguientePop(nPag,RES,idCad,idSubCad,idCorr,sigAtras,pAct,total,depxPag)
{
	http.open("POST", "../../inc/AjaxOperacion/navegarOperaciones.php", true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	var datsiguientePop=envDsiguientePop(nPag,idCad,idSubCad,idCorr,sigAtras,pAct,total,depxPag);
	
	http.onreadystatechange=function() 
	{ 
		if (http.readyState==1)
		{
			document.getElementById(RES).style.display="none";
			document.getElementById(RES).style.display="block";
			document.getElementById(RES).innerHTML = '<div aling="center"><img src="../../img/loadAJAX.gif" /></div>';	
		}
		if (http.readyState==4)
		{
			var RespuestaServidor = http.responseText; //alert(RespuestaServidor);
			document.getElementById(RES).innerHTML = RespuestaServidor;
		} 
	}
	http.send(datsiguientePop);
}
//===============================================================================
//====================== Regreso de n en n ===================================================
function envDregresarPop(nPag,idCad,idSubCad,idCorr,sigAtras,pAct,total,depxPag){
	var Aleatorio = Math.random();
			
	return  "nPag="+nPag+
			"&sigAtras="+sigAtras+
			"&idCad="+idCad+
			"&idSubCad="+idSubCad+
			"&idCorr="+idCorr+
			"&pAct="+pAct+
			"&total="+total+
			"&depxPag="+depxPag+
			"&Aleatorio="+Aleatorio;
}
function regresarPop(nPag,RES,idCad,idSubCad,idCorr,sigAtras,pAct,total,depxPag)
{
	http.open("POST", "../../inc/AjaxOperacion/navegarOperaciones.php", true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	var datregresarPop=envDregresarPop(nPag,idCad,idSubCad,idCorr,sigAtras,pAct,total,depxPag);
	
	http.onreadystatechange=function()
	{ 
		if (http.readyState==1)
		{
			document.getElementById(RES).style.display="none";
			document.getElementById(RES).style.display="block";
			document.getElementById(RES).innerHTML = '<div aling="center"><img src="../../img/loadAJAX.gif" /></div>';	
		}
		if (http.readyState==4)
		{
			var RespuestaServidor = http.responseText; //alert(RespuestaServidor);
			document.getElementById(RES).innerHTML =  RespuestaServidor;
		} 
	}
	http.send(datregresarPop);
}
//===============================================================================