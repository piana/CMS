+------ INSTALACJA:

	1. Wyślij pliki skryptu na serwer.

	2. Nadaj uprawnienia (chmody) 775 lub 777 dla:
		• .htaccess
		• install.php
		• inc/data
		• inc/data/db

	3. Otwórz w przeglądarce ścieżkę zawierajacą skrypt.

	4. Uzupełnij formularz instalacyjny.

+------ WYMAGANIA:

	• PHP 5.3+


+------ FATAL ERROR: Cannot use string offset as an array

	Należy wyłączyć funkcję register_globals poprzez plik .htaccess dodając do niego:
	
	php_flag register_globals Off


+------ PRZYJAZNE LINKI:

	Jeżeli przyjazne linki są włączone w PA, a nie działają, to
	prawdopodobnie skrypt nie mógł nadpisać pliku .htaccess.
	W takim razie należy edytować plik ręcznie w katalogu skryptu:

	RewriteEngine on
	RewriteBase /katalog_skryptu/
	RewriteRule ^([^-]+),([^-]+),([a-z0-9._.-]+).html$ index.php?go=$1&lang=$2 [L]

	Inną przyczyną może być brak funkcji mod_rewrite na serwerze.