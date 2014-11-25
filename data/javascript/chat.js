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
		try{
			document.getElementById('down').scrollIntoView(); 
		} catch(e){
			console.warn("Je malý chat. Nelze posunout.");
		}
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

function sendMessage(){
	var dataMessage = {
		nick: $("#nick").html(),
		message: $("#message").val()
	}
	$.post(adress.replace("index.php", "")+"data/php/sendChatMessage.php", dataMessage, function(data){
		$("#sendMessageChat").val("Odesláno!");
		$("#message").val("");
		setTimeout(function(){
			$("#sendMessageChat").val("Odeslat");
		}, 3000);
	});
}

$(document).ready(function(){
	setInterval(getMessages, 2000);
	setTimeout(function(){ 
		try{
			document.getElementById('down').scrollIntoView(); 
		} catch(e){
			console.warn("Je malý chat. Nelze posunout.");
		}
	}, 2500);
});
