var adress = document.location.href;
var requestMethod = document.getElementById("request-method").content;

var hlasky = {
	open: "Otevřít", 
	close: "Zavřít",
	littleChat: "Malý chat. Nelze posunout.", 
	sended: "Odesláno!", 
	send: "Odeslat"
}

$(document).ready(function(){		
	if(requestMethod == "GET"){
		$("#chat").css("bottom", "-370px");
		$("#openorclose").html(hlasky.open);
	} else if(requestMethod == "POST") {
		$("#openorclose").html(hlasky.close);
		$("#chat").css("bottom:", "0px");
	}
});			
function openClose(){
	if($("#chat").css("bottom") == "-370px"){
		$("#openorclose").html(hlasky.close);
		$("#chat").animate({bottom: 0}, 900);
		try{
			document.getElementById('down').scrollIntoView(); 
		} catch(e){
			console.warn(hlasky.littleChat);
		}
	} else {
		$("#openorclose").html(hlasky.open);
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
		$("#sendMessageChat").val(hlasky.sended);
		$("#message").val("");
		setTimeout(function(){
			$("#sendMessageChat").val(hlasky.send);
		}, 3000);
	});
}

$(document).ready(function(){
	setInterval(getMessages, 2000);
	setTimeout(function(){ 
		try{
			document.getElementById('down').scrollIntoView(); 
		} catch(e){
			console.warn(hlasky.littleChat);
		}
	}, 2500);
});
