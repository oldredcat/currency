var IntervalId;

function setUpdate(){
	window.clearInterval(IntervalId);
	IntervalId = window.setInterval('loadData()', 1000 * 60 * 15);
}

function addloading(){
	$('.json-data').html('<tr class="loading"><td colspan="4"></td></tr>');
}

function addNewHtml(html){
	$('.json-data').html('');
	$('.json-data').html(html);
}

function loadData(){
	
	addloading();
	
	$.ajax({
		url: '/currency',
	  	dataType: 'json',
	  	success: function(data){
			if(data.error == '200'){
				
				items = [];
				
				i = 1;
				
				$.each(data.data, function(key, val){
					items.push('<tr><td>' + i + '</td><td>' + val.name + '</td><td>' + val.price + '</td><td>' + val.amount + '</td></tr>');
					i++;
				});
				
				addNewHtml(items.join(''));
				
				setUpdate();
				
			}else{
				addNewHtml('<tr><td colspan="4">' + data.msg + '</td></tr>');
			}
		}
	});

}

$(function(){
	
	loadData();
	
	$('.update').on('click',function(){
		loadData();
	});
	
	setUpdate();
	
});