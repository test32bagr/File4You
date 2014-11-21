function getFiles(letter){ 
	var adress = document.location.href;
	$.get(adress.replace("index.php", "")+'data/php/getFiles.php', function(data){ 
		$("#getFiles").html(data); 
	}); 
	
}
$(document).ready(function(){
	setInterval(getFiles, 2000);
});
