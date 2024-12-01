$(function(){
	$("#txtTelSub, #txtMailSub").bind("paste", function(){return false;});

	$("#txtMailSub").attr('maxlength','100');
	$("#txtTelSub").attr('maxlength','15');
});

function consultaCorresponsal(idCorresponsal){
	setValue("ddlCorresponsales", idCorresponsal);

	GoCorresponsal2();
}

function setValue(id, value){
	try{
		$("#" + id).val(value);
	}
	catch(e){
		//console.log(e);
	}
}