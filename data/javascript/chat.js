var config = {
	getChat: 0, 
	maxChatLen: 512,
	adress: document.location.href, 
	request: {
		method: $("#request-method").attr("content")
	}
}

var hlasky = {
	open: "Otevřít", 
	close: "Zavřít",
	sended: "Odesláno!", 
	send: "Odeslat",
	error: {
		littleChat: "Malý chat. Nelze posunout.",
		emptyMessage: "Nemůžeš odesílat prázdné zprávy.",
		bigMessage: "Maximální velikost zprávy může být "+config.maxChatLen+" znaků."
	}
}

function getCaret(el) {
	if (el.selectionStart)  return el.selectionStart;
	else if (document.selection) {
		el.focus();
		var r = document.selection.createRange();
		if (r == null) return 0;
		var re = el.createTextRange(),
		rc = re.duplicate();
		re.moveToBookmark(r.getBookmark());
		rc.setEndPoint('EndToStart', re);
		return rc.text.length;
	}  
	return 0;
}

function timeOnChat(time){
	time = Math.floor(time / 1000);
	var minuty = Math.floor(time / 60);
	var sekundy = time % 60;
	
	var formatMinuty = (minuty < 10) ? "0" + minuty : minuty;
	var formatSekundy = (sekundy < 10) ? "0" + sekundy : sekundy;
	
	return (formatMinuty + ":" + formatSekundy).trim();
}

function logovani(type, info){
	var dataLen = info.length;
	var what;
	
	if(type == "GET") what = "Přijato";
	else if(type == "POST") what = "Odesláno";
	else what = "";
	
	if(dataLen >= 1024) {
		dataLen = dataLen / 1024 //kB
		if(dataLen >= 1024){
			//v MB
			dataLen = dataLen / 1024;
			dataLen = dataLen.toString();
			console.log("Chat "+type+": "+what+": " + dataLen.substr(0, 5) + " MB");
		} else {
			//v kB
			dataLen = dataLen.toString();
			console.log("Chat "+type+": "+what+": " + dataLen.substr(0, 5) + " kB");
		}
	} else {
		dataLen = dataLen.toString();
		console.log("Chat "+type+": "+what+": " + dataLen + " B");
	}
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
	$.get(config.adress.replace("index.php", "")+'data/php/ajaxChat.php', function(data){
		$("#messages").html(data + "<span id=\"down\"></span>");
		
		//Zapisování do konzole velikost přijatých dat
		config.getChat++;
		if(config.getChat == 10) {
			logovani("GET", data);
			config.getChat = 0;
		}
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
	if($("#message").val().length >= config.maxChatLen){
		alert(hlasky.error.bigMessage);
		$("#message").val("");
		return;
	}
	
	$.post(config.adress.replace("index.php", "")+"data/php/sendChatMessage.php", dataMessage, function(data){
		$("#sendMessageChat").val(hlasky.sended);
		$("#message").val("");
		
		setTimeout(function(){
			$("#sendMessageChat").val(hlasky.send);
			document.getElementById("down").scrollIntoView(false);	
		}, 3000);
		
		logovani("POST", dataMessage.message);
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
	}, 4000);
	
	if(config.request.method == "GET"){
		$("#chat").css("bottom", "-370px");
		$("#openorclose").html(hlasky.open);
	} else if(config.request.method == "POST") {
		$("#openorclose").html(hlasky.close);
		$("#chat").css("bottom:", "0px");
	}
	
	var countup = 0;
	setInterval(function(){
		countup += 1000;
		$("#time").html("(Online: " + timeOnChat(countup) + ")");
	}, 1000);
});