var adress = document.location.href;
var requestMethod = $("#request-method").attr("content");

var hlasky = {
	open: "Otevřít", 
	close: "Zavřít",
	sended: "Odesláno!", 
	send: "Odeslat",
	error: {
		littleChat: "Malý chat. Nelze posunout.",
		emptyMessage: "Nemůžeš odesílat prázdné zprávy."
	}
}

function timeOnChat(time){
	time = Math.floor(time / 1000);
	var minuty = Math.floor(time / 60);
	var sekundy = time % 60;
	
	var formatMinuty = (minuty < 10) ? "0" + minuty : minuty;
	var formatSekundy = (sekundy < 10) ? "0" + sekundy : sekundy;
	
	return (formatMinuty + ":" + formatSekundy).trim();
}
		
function openClose(){
	if($("#chat").css("bottom") == "-370px"){
		$("#openorclose").html(hlasky.close);
		$("#chat").animate({bottom: 0}, 900);
		try{
			$("#down")[0].scrollIntoView(false);
		} catch(e){
			console.warn(hlasky.error.littleChat);
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
	if(dataMessage.message == ""){
		alert(hlasky.error.emptyMessage);
		return;
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
			$("#down")[0].scrollIntoView(false);
		} catch(e){
			console.warn(hlasky.error.littleChat);
		}
	}, 2500);
	
	if(requestMethod == "GET"){
		$("#chat").css("bottom", "-370px");
		$("#openorclose").html(hlasky.open);
	} else if(requestMethod == "POST") {
		$("#openorclose").html(hlasky.close);
		$("#chat").css("bottom:", "0px");
	}
	
	var countup = 0;
	setInterval(function(){
		countup += 1000;
		$("#time").html("(Online: " + timeOnChat(countup) + ")");
	}, 1000);
});