$('#myTabs').tabs();

$('.next-product').click(function(){ 
  var $tabs = $('#myTabs').tabs();
  var selected = $tabs.tabs('option', 'selected');
  $tabs.tabs('select', selected+1);
});

$('.previous-product').click(function(){ 
  var $tabs = $('#myTabs').tabs();
  var selected = $tabs.tabs('option', 'selected');
  $tabs.tabs('select', selected-1);
});