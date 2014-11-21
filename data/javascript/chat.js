var adress = document.location.href;
var requestMethod = document.getElementById("request-method").content;

$(document).ready(function(){		
	if(requestMethod == "GET"){
		$("#chat").css("bottom", "-370px");
		$("#openorclose").html("Otevřít");
	} else if(requestMethod == "POST") {
		$("#openorclose").html("Zavřít");
		$("#chat").css("bottom:", "0px");
	}
});			
function openClose(){
	if($("#chat").css("bottom") == "-370px"){
		$("#openorclose").html("Zavřít");
		$("#chat").animate({bottom: 0}, 900);
		document.getElementById('down').scrollIntoView();
	} else {
		$("#openorclose").html("Otevřít");
		$("#chat").animate({bottom: -370}, 900);
	}
}

function getMessages(letter){
	$.get(adress.replace("index.php", "")+'data/php/ajaxChat.php', function(data){ 
		$("#messages").html(data+"<span id=\"down\"></span>"); 
	}); 
	
}
$(document).ready(function(){
	setInterval(getMessages, 2000);
	setTimeout(function(){ document.getElementById('down').scrollIntoView(); }, 2500);
});
