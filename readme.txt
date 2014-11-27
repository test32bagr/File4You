File4You

Internetová služba ke sdílení souborů za pomocí PHP, Javascript a MySQL databáze.
Aplikace je šířená jako Open source (MIT License)

Konfigurační soubor pro připojení k MySQL databázi je umístěn v "data/php/mysqli.php"

Pro správné připojení k databázi potřebujete mít nastavený uživatele a heslo v MySQL a PHP souboru(mysqli.php).
Pro vytvoření databáze a tabulek použijte SQL soubor "set_db.sql"

Registrace je umožněna pouze přes speciální registrační klíče, které jsou uloženy v databázi v tabulce 'cloud_reg_allow'
Jediný uživatel, který je povolen a registrován je účet Superuser.
Přístupové údaje pro Superuser jsou zde: 
	
	Nick: Superuser
	Heslo: Superuser
	
Není zaručen neoprávněný přístup pokud heslo do Superuser nezměníte.

Služba je vybavena automatickým odhlášením o půlnoci, kvůli aktivnímu AJAX.

Varování:
	Některé věci nemusí fungovat v závislosti na konfiguraci WebServeru.
	
	Doporučuje se změnit tyto vlastnosti: 
		
		upload_max_filesize = 20M
		post_max_size = 20M
		display_errors = On
	
	Doporučuje se také povolit podporu souboru .htaccess

Aplikace má volitelnou možnost CRON úlohy pro zálohování databáze na jiný server nebo do souborů.
Zálohování do souboru se ukládá do několika různých typů a poté se ukládá do archívu na serveru.

Typy záloh:
	Další databáze: MySQL
	Do souboru: PHP, XML, JSON
	
Jestli chcete zálohování databáze provádět a nebo ne záleží jenom na vás. Pro spuštění zálohování stačí
pouze nastavit cron úlohu ve složce "cron" soubor "cron.php"