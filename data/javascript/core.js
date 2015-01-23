document.onmousedown = function(event){
	if(event.button == 2){
		alert("Pravé tlačítko je zablokováno.");
		return false;
	}
}

function getFiles(letter){
	var adress = document.location.href;
	$.get(adress.replace("index.php", "")+'data/php/getFiles.php', function(data){ 
		$("#getFiles").html(data); 
	}); 
}

function uploadForm(){ $("#upload_window").toggle(600); }

$(document).ready(function(){
	setInterval(getFiles, 2000);
	$("#upload_window").hide();
});