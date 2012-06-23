$(document).ready(function() {

	if($("div#tmpl").length)
	{
		uri =  $('#url').val()	
		var templobj = $.getValues(uri);
		console.log(uri);


		var data = {
      children: [{
        name: 'Europe',
        children: [{
          name: 'Belgium',
          children: [{
            name: 'Brussels',
            children:null},{
            name: 'Namur'},{
            name: 'Antwerpen'}]},{
          name: 'Germany'},{
          name: 'UK'}]},{
        name: 'America',
        children: [{
          name: 'US',
          children: [{
            name: 'Alabama'},{
            name: 'Georgia'}]},{
          name: 'Canada'},{
          name: 'Argentina'}]},{
        name: 'Asia'},{
        name: 'Africa'},{
        name: 'Antarctica'}
      ]
    };

    var jss = jQuery.parseJSON(templobj);
    var obj = {nodes:[]};
    obj.nodes = jss;
   	
	console.log(obj);
    console.log(data);

		var directive = {
			'div.item-holder': {
				'node <- nodes': {
					'div.span-templ': 'node.value',
					'div.item-value@id':'alert(\'#{node.value}\');',
					'div.children': function(ctxt){
						return ctxt.node.item.nodes ? rfn(ctxt.node.item):'';
					}
				}
			}
		};
		var rfn = $('div.tmpl').compile( directive );
		$('div.tmpl').render(obj, rfn );

		/*var rfn = $('ul.treeItem').compile( directive );
		$('ul.treeItem').render(obj, rfn );*/

	}

});

jQuery.extend({
	getValues: function(url) {
	var result = null;
	$.ajax({
		url: url,
		type: 'POST',
		dataType: 'json',
		async: false,
		success: function(data) {
		    result = data['data_templ'];
		}
	});
	return result;
	}
})