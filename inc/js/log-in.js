$(document).ready(function(){
	/*$("#login").fadeOut("slow");
	$("#login").fadeIn("slow");*/
	
	document.Login.txtUser.focus();
})

function cambio(ctrl, ctrl2) {
	//$("#"+ctrl).fadeOut("fast")
	$("#"+ctrl).css({"-moz-box-shadow":"0 0 15px #000033"})
	$("#"+ctrl).css({"-webkit-box-shadow":"0 0 15px #000033"})
	$("#"+ctrl).css({"box-shadow":"0 0 15px #000033"})
	$("#"+ctrl).css({"behavior":"url(css/PIE.htc)"})
	
	$("#"+ctrl2).css({"-moz-box-shadow":"0 0 15px"})
	$("#"+ctrl2).css({"-webkit-box-shadow":"0 0 15px"})
	$("#"+ctrl2).css({"box-shadow":"0 0 15px"})
	$("#"+ctrl2).css({"behavior":"url(css/PIE.htc)"})
	
	//$("#"+ctrl).fadeIn("normal")
	//document.getElementByName("Usuario").focus(); 

//"Helvetica Neue", Helvetica, Arial, sans-serif
}
function Clear(ctrl) {
	//$("#"+ctrl).fadeOut("fast")
	/*alert("entro");
	if(ctrl == "Usuario")
	{
		ctrl = document.getElementById("Usuario"); 
		if(ctrl.value == "Usuario" )
		{
			//alert(d.currentStyle.color);
			ctrl.value="";
		}
	}
	if(ctrl == "Contraseña")
	{
		ctrl = document.getElementById("Contraseña");
		alert(ctrl.value);
		if(ctrl.value == ".......")
		{
			ctrl.value="";
			
			if(ctrl.currentStyle.color == "#000000" )
			{
				//alert("funciono");
				}
		}
	}*/
	//$("#"+ctrl).fadeIn("normal")

//"Helvetica Neue", Helvetica, Arial, sans-serif
}


function Borrar(ctrl)
{

	console.log("informacion: " + ctrl);
	
	if( window.event )  
        var key = window.event.keyCode;//
	
	switch(key){ 
		case 40: 
//        alert('enter'); 
        break;
		
		case 8: 
		if(ctrl == "txtUser")
		{
			var ctrl2 = document.getElementById("txtUser");
			if(ctrl2.value.length == 1 || ctrl2.value.length == 0)
			{
				CssGris(ctrl);
				ctrl2.value ="Usuario ";
			}
		}
		if(ctrl == "txtPass")
		{
			var ctrl2 = document.getElementById("txtPass");
			if(ctrl2.value.length == 1 || ctrl2.value.length == 0)
			{
				CssGris(ctrl);
				ctrl2.value = "~~~~~~~ ";
			}
		}
  //      alert('borrar'); 
        break;
	}
	
	if(ctrl == "txtUser")
	{
		ctrl = document.getElementById("txtUser");
		//alert(ctrl.value);
		if(ctrl.value == "Usuario" )
		{
			CssBlack('txtUser');
			ctrl.value ="";
		}
	}
	if(ctrl == "txtPass")
	{
		ctrl = document.getElementById("txtPass");
		//alert(ctrl.value);
		if(ctrl.value == "~~~~~~~" )
		{
			CssBlack('txtPass');
			ctrl.value ="";
		}
	}
}

function CssGris(ctrl)
{
	document.getElementById(ctrl).style.color = "#777";
	document.getElementById(ctrl).style.fontFamily = "'Helvetica Neue', Helvetica, Arial, sans-serif";
	document.getElementById(ctrl).style.fontSize = "14px";
}

function CssBlack(ctrls)
{
	document.getElementById(ctrls).style.color = "#000";
	document.getElementById(ctrls).style.fontFamily = "'Trebuchet MS', Verdana, Helvetica, Arial, sans-serif";
	document.getElementById(ctrls).style.fontSize = "16px";
}