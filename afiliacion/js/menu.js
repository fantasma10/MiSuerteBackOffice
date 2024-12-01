$(document).ready(function(){
	$('.collapseBtn').on('click', function(e){
		showActiveOption();
	});
	
	showActiveOption();
});

function resetMenu(){
	Cookies.set('openItemsMenu', '');
}


$('#sidebar li > a').click(function(e){
	//Cookies.set('openItemsMenu', 'the_value');
	if(e.target.tagName.toLowerCase() === 'a'){
		var a = e.target;
	}
	else{
		var a = $(e.target).parent();
	}

	if($(a).attr('opcion')){
		var openItem = $(a).attr('opcion');
		Cookies.set('openItemsMenu', openItem);
	}
	
});


function showActiveOption(){
	if(!$('#sidebarbg').hasClass('collapse-sidebar')){
		if(Cookies.get('openItemsMenu') != undefined){
			openItemOption = Cookies.get('openItemsMenu');

			$('a[opcion='+openItemOption+']').addClass('active');
			var parent = $($('a[opcion='+openItemOption+']').closest('li').parent()).css('display', 'block');
			
			var gParent= $(parent).closest('li').parent();
			if($(gParent).hasClass('sub')){
				$(gParent).css('display', 'block');
			}
		}
	}
}