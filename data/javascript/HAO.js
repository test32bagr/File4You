var datum = new Date();
var ted = Date.parse(datum);
var pulnoc = Date.parse(new Date(datum.getFullYear(), datum.getMonth(), datum.getDate()+1, 0, 0, 0, 0));
setTimeout(function(){
	location.href = location.href+"?odhlasit=true"
}, pulnoc-ted);

// Zobrazeni zpravy o odhlášení
setTimeout(function(){
	var countdown = pulnoc-ted;
	setInterval(function(){
		$("#shutdown").html("<b>POZOR!</b><br>Za "+formatTime(countdown)+" budete z bezpečnostních důvodů automaticky odhlášeni.").css("border", "1px solid");
		countdown-=1000;
	}, 1000);
}, pulnoc-ted-1000*60*2);

function formatTime(time){
	time = Math.floor(time/1000);
	var minuty = Math.floor(time/60);
	var sekundy = time % 60;
	var formatMinuty = "";
	var formatSekundy = "";
	if(minuty >= 5) formatMinuty = minuty+" minut";
	else if(minuty >= 2) formatMinuty = minuty+" minuty";
	else if(minuty == 1) formatMinuty = minuty+" minutu";
	
	if(sekundy >= 5) formatSekundy = sekundy+" sekund";
	else if(sekundy >= 2) formatSekundy = sekundy+" sekundy";
	else if(sekundy == 1) formatSekundy = sekundy+" sekundu";
	
	return (formatMinuty+" "+formatSekundy).trim();
}