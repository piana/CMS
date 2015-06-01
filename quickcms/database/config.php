<?php
/*
* Główne dane konfiguracyjne strony, niezależne od języka
* Więcej: http://opensolution.org/docs/?p=pl-settings
*/
unset( $config, $lang, $aData );

/*
* Jeśli strona jest w trakcie tworzenia, warto pozostawić włączoną opcję DEVELOPER_MODE
* Więcej: http://opensolution.org/docs/?p=pl-settings#DEVELOPER_MODE
*/
define( 'DEVELOPER_MODE', true ); // po uruchomieniu strony zakomentuj ta linie
if( defined( 'DEVELOPER_MODE' ) ){
  error_reporting( E_ALL | E_STRICT );
}

/*
* Login w postaci emaila i hasło do zalogowania się do panelu administracyjnego
* Dbaj o ich bezpieczeństwo. Nie ustawiaj hasła na "admin", "1234", "qwerty" itp.
* Więcej: http://opensolution.org/docs/?p=pl-settings#login_email
*/
$config['login_email'] = "piancur@tlen.pl";
$config['login_pass'] = "admin";

/*
* Ustawienie adresu IP do logowania do administracji
* Więcej: http://opensolution.org/docs/?p=pl-settings#allowed_ip_admin_panel
*/
$config['allowed_ip_admin_panel'] = null; // domyślna wartość: null

/*
* Zmienna przechowuje nazwę katalogu skórki
* Więcej: http://opensolution.org/docs/?p=pl-settings#skin
*/
$config['skin'] = 'default'; // domyślna wartość: 'default'

/*
* Rozmiary miniaturek i lokalizacje zdjęć. Dodając nową lokalizację, nadaj jej cyfrę nie mniejszą niż 50
* Więcej: http://opensolution.org/docs/?p=pl-settings#images_thumbnails
*/
$config['images_thumbnails'] = Array( 100, 200 ); // domyślna wartość: Array( 100, 200 )
$config['images_locations'] = Array( 1 => 'Lewa strona', 2 => 'Prawa strona', 0 => 'Tylko lista' ); // domyślna wartość: 1 => 'Lewa', 2 => 'Prawa', 0 => 'Tylko lista'

/*
* Rodzaje menu przedstawione w postaci tablicy. Klucz 0 w zmiennej jest zarezerwowany dla ukrytego menu!
* Więcej: http://opensolution.org/docs/?p=pl-settings#pages_menus
*/
$config['pages_menus'] = Array( 1 => 'Menu górne', 0 => 'Ukryte' ); // domyślna wartość: Array( 1 => 'Menu górne', 0 => 'Ukryte' )

/*
* Ustawienia motywów do wyboru w czasie edycji strony
* Więcej: http://opensolution.org/docs/?p=pl-settings#themes
*/
$config['themes'] = Array(
  1 => Array( 'header.php', 'page.php', 'footer.php' ), // domyślna wartość: 1 => Array( 'header.php', 'page.php', 'footer.php' )
);

/*
* Zmienna przechowuje domyślną wersję języka. Strona będzie się wyświetlać w tej wersji języka dopóki klient nie zmieni tłumaczenia
* Więcej: http://opensolution.org/docs/?p=pl-settings#default_language
*/
$config['default_language'] = 'pl'; // domyślna wartość: 'pl'

/*
* Tłumaczenie opisów pól i komunikatów w panelu administracyjnym
*/
$config['admin_lang'] = 'pl'; // domyślna wartość: 'pl'

/*
* Nazwa pliku administracji
* Więcej: http://opensolution.org/docs/?p=pl-settings#admin_file
*/
$config['admin_file'] = 'admin.php'; // domyślna wartość: 'admin.php'

/*
* Zmienna wyłącza wczytywanie się slidera po stronie klienta
* Więcej: http://opensolution.org/docs/?p=pl-settings#enabled_sliders
*/
$config['enabled_sliders'] = true; // możliwe wartości: true (domyślne), null

/*
* Opcja włączania edytora WYSIWYG (domyslnie tinyMCE)
* Więcej: http://opensolution.org/docs/?p=pl-settings#wysiwyg
*/
$config['wysiwyg'] = 'tinymce'; // możliwe wartości: 'tinymce' (domyślne), null

/*
* Zmienna umożliwia przyśpieszenie działania skryptu przez użycie pamięci podręcznej w database/cache/
* Więcej: http://opensolution.org/docs/?p=pl-settings#enable_cache
*/
$config['enable_cache'] = null; // możliwe wartości: true, null (domyślne)

/*
* Zmienna wyłącza wyświetlanie się linka do podstrony aktualnie przeglądanej w scieżce nawigacji
* Więcej: http://opensolution.org/docs/?p=pl-settings#page_link_in_navigation_path
*/
$config['page_link_in_navigation_path'] = true; // możliwe wartości: true (domyślne), null

/*
* Możliwość przeglądania stron ukrytych jeśli administrator zalogowany jest do panelu administracyjnego
* Więcej: http://opensolution.org/docs/?p=pl-settings#display_hidden_pages
*/
$config['display_hidden_pages'] = null; // możliwe wartości: true, null (domyślne)

/*
* Opcja usuwania nieużywanych plików w czasie usuwania strony
* Więcej: http://opensolution.org/docs/?p=pl-settings#delete_unused_files
*/
$config['delete_unused_files'] = true; // możliwe wartości: true (domyślne), null

/*
* Przechowują możliwe rozszerzenia dla zdjęć i zwykłych plików
* Więcej: http://opensolution.org/docs/?p=pl-settings#allowed_not_image_extensions
*/
// Rozszerzenia dla plików - nie zdjęć
$config['allowed_not_image_extensions'] = 'pdf|swf|doc|txt|xls|ppt|rtf|odt|ods|odp|rar|zip|7z|bz2|tar|gz|tgz|arj|docx'; // domyślna wartość: 'pdf|swf|doc|txt|xls|ppt|rtf|odt|ods|odp|rar|zip|7z|bz2|tar|gz|tgz|arj|docx'
// Rozszerzenia dla zdjęc
$config['allowed_image_extensions'] = 'jpg|jpeg|gif|png'; // domyślna wartość: 'jpg|jpeg|gif|png'

/*
* Ustawienia dla rozmiarów i jakości wgrywanych zdjęć
* Więcej: http://opensolution.org/docs/?p=pl-settings#max_image_size
*/
// Maksymalny rozmiar dłuższego boku zdjęcia dla którego wygeneruje się miniaturka
$config['max_image_size'] = 2000; // domyślna wartość: 2000
// Maksymalna wielkość dłuższego boku zdjęcia. Gdy poniższa wartość zostanie przekroczona, to zostanie pomniejszony do niżej zdefiniowanej.
$config['max_dimension_of_image'] = 1100; // domyślna wartość: 1100
// Jakość zapisywanego i pomniejszanego zdjęcia
$config['image_quality'] = 80; // domyślna wartość: 80

/*
* Zmiana nazwy pliku do nazwy strony, do której jest dodawany
* Więcej: http://opensolution.org/docs/?p=pl-settings#change_files_names
*/
$config['change_files_names'] = null; // możliwe wartości: true, null (domyślne)

/*
* Ustawienia domyślne dla niektórych opcji
* Więcej: http://opensolution.org/docs/?p=pl-settings#default_pages_menu
*/
// Domyślny typ strony. Opcja dla zmiennej: $config['pages_menus']
$config['default_pages_menu'] = 1; // domyślna wartość: 1

// Domyślna lokalizacja zdjęcia dla strony. Opcja dla zmiennej: $config['images_locations']
$config['default_image_location'] = 1; // domyślna wartość: 1

// Domyślny rozmiar miniaturki zdjęcia dla strony. Opcja dla zmiennej: $config['images_thumbnails']
$config['default_image_size'] = 200; // domyślna wartość: 200

// Domyślny motyw. Opcja dla zmiennej: $config['themes']
$config['default_theme'] = 1; // domyślna wartość: 1

// Domyślne ustawienie dla slidera, więcej możliwych opcji znajdziesz w core/libraries/quick.slider.js
$config['default_slider_config'] = 'sAnimation:"fade",iPause:4000'; // domyślna wartość: 'sAnimation:"fade",iPause:4000'

/*
* Ukrywanie zaawansowanych opcji użytkownikowi o małej wiedzy na temat obsługi panelu administracyjnego
* Opcja ukrywa m.in. wybór szablonu czy strony startowej.
* Więcej: http://opensolution.org/docs/?p=pl-settings#disable_advanced_options
*/
$config['disable_advanced_options'] = null; // możliwe wartości: true, null (domyślne)

/*
* Format daty
* Więcej: http://opensolution.org/docs/?p=pl-settings#date_format_admin_default
*/
// Prezentacja daty w panelu administracyjnym
$config['date_format_admin_default'] = 'Y-m-d H:i'; // domyślna wartość: 'Y-m-d H:i'

/*
* Dodaj różnicę czasu (w minutach) między czasem lokalnym a czasem na serwerze
* Więcej: http://opensolution.org/docs/?p=pl-settings#time_diff
*/
$config['time_diff'] = 0; // domyślna wartość: 0

/*
* Jeśli w adresie URL nazwy strony ma być dodawany znacznik języka, to dodaj do niego separator np. _
* Po wypełnieniu poniższej zmiennej, edytuj jakąkolwiek stronę w administracji i zapisz ją (nie musisz w niej nic zmieniać),
* aby adresy stron zaktualizowały się o nazwę języka i separator.
* Więcej: http://opensolution.org/docs/?p=pl-settings#language_separator
*/
$config['language_separator'] = null; // domyślna wartość: null

/*
* Katalog z bazą danych. Istnieje możliwość zmiany jego nazwy i w tym przypadku zapoznaj się koniecznie z dokumentacją
* Więcej: http://opensolution.org/docs/?p=pl-settings#dir_database
*/
$config['dir_database'] = 'database/'; // domyślna wartość: 'database/'
$config['database'] = $config['dir_database'].'database.db'; // domyślna wartość: $config['dir_database'].'database.db'

/*
* Lista rozszerzeń oraz przypisanych do nich klas (styli CSS)
* Więcej: http://opensolution.org/docs/?p=pl-settings#ext_icons
*/
$config['ext_icons'] = Array( 'rar'=>'zip', 'zip'=>'zip', 'bz2'=>'zip', 'gz'=>'zip', 'fla'=>'fla', 'mp3'=>'media', 'mpeg'=>'media', 'mpe'=>'media', 'mov'=>'media', 'mid'=>'media', 'midi'=>'media', 'asf'=>'media', 'avi'=>'media', 'wav'=>'media', 'wma'=>'media', 'msg'=>'eml', 'eml'=>'eml', 'pdf'=>'pdf', 'jpg'=>'pic', 'jpeg'=>'pic', 'jpe'=>'pic', 'gif'=>'pic', 'bmp'=>'pic', 'tif'=>'pic', 'tiff'=>'pic', 'wmf'=>'pic', 'png'=>'png', 'chm'=>'chm', 'hlp'=>'chm', 'psd'=>'psd', 'swf'=>'swf', 'pps'=>'pps', 'ppt'=>'pps', 'sys'=>'sys', 'dll'=>'sys', 'txt'=>'txt', 'doc'=>'txt', 'rtf'=>'txt', 'vcf'=>'vcf', 'xls'=>'xls', 'xml'=>'xml', 'tpl'=>'web', 'html'=>'web', 'htm'=>'web', 'com'=>'exe', 'bat'=>'exe', 'exe'=>'exe' );

/*
* Uwaga!
* Zmienne i kod znajdujący się poniżej przeznaczony jest jedynie dla zaawansowanych użytkowników i nie zalecamy jego modyfikacji
*/
$config['language_cookie_name'] = defined( 'CUSTOMER_PAGE' ) ? 'sLanguage' : 'sLanguageBackEnd';

if( isset( $_GET['sLanguage'] ) && strlen( $_GET['sLanguage'] ) == 2 && is_file( $config['dir_database'].'config_'.$_GET['sLanguage'].'.php' ) ){
  setCookie( $config['language_cookie_name'], $_GET['sLanguage'], time( ) + 86400 );
  $config['language'] = $_GET['sLanguage'];
  $config['current_page_id'] = true;
}
else{
  if( !empty( $_COOKIE[$config['language_cookie_name']] ) && is_file( $config['dir_database'].'config_'.$_COOKIE[$config['language_cookie_name']].'.php' ) && strlen( $_COOKIE[$config['language_cookie_name']] ) == 2 )
    $config['language'] = $_COOKIE[$config['language_cookie_name']];
  else
    $config['language'] = $config['default_language'];
}

if( !isset( $_GET['p'] ) && !isset( $config['current_page_id'] ) && defined( 'CUSTOMER_PAGE' ) ){
  $config['current_page_id'] = getPageId( );
  if( is_numeric( $config['current_page_id'] ) && isset( $_COOKIE[$config['language_cookie_name']] ) && $config['language'] != $_COOKIE[$config['language_cookie_name']] ){
    setCookie( $config['language_cookie_name'], $config['language'], time( ) + 86400 );
  }
}

require $config['dir_database'].'config_'.$config['language'].'.php';
require defined( 'CUSTOMER_PAGE' ) ? $config['dir_database'].'lang_'.$config['language'].'.php' : ( is_file( $config['dir_database'].'lang_'.$config['admin_lang'].'.php' ) ? $config['dir_database'].'lang_'.$config['admin_lang'].'.php' : $config['dir_database'].'lang_'.$config['language'].'.php' );

if( isset( $config['current_page_id'] ) && $config['current_page_id'] === true ){
  $config['current_page_id'] = $config['start_page'];
}
$config['disable_agents'] = 'spider|crawler|curl|google|Ezooms|bot|Slurp|yandex|yahoo|BPImageWalker';
$config['version'] = '6.0';
$config['manual_link'] = 'http://opensolution.org/docs/?p='.( ( $config['admin_lang'] == 'pl' ) ? 'pl' : 'en' ).'-';

/*
* Sprawdza ustawienia serwera i konfiguracji skryptu
*/
if( defined( 'DEVELOPER_MODE' ) ){
  $sValue = (float) phpversion( );
  if( $sValue < '5.2' )
    exit( '<h1>Required PHP version is <u>5.2.0</u>, your version is '.phpversion( ).'</h1>' );
  elseif( !extension_loaded( 'pdo_sqlite' ) )
    exit( '<h1>Required <u>PDO</u> library with <u>pdo_sqlite</u> extension is not available</h1>' );
  elseif( !is_file( $config['database'] ) )
    exit( '<h1>Required file <u>'.$config['database'].'</u> is not available</h1>' );
  elseif( defined( 'ADMIN_PAGE' ) && ini_get( 'allow_url_fopen' ) != 1 ){
    exit( '<h1>Turn ON <u>allow_url_fopen</u> in PHP configuration (php.ini)</h1>' );
  }
}
elseif( isset( $_GET['error'] ) && $_GET['error'] == md5( $_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'] ) ){
  exit( '<h1>This page is temporary unavailable</h1>' );
}

/**
* Returns page id from the $_GET
* @return array
*/
function getPageId( ){
  global $config;
  if( !is_file( $config['dir_database'].'cache/links' ) )
    exit( '<h1>'.( defined( 'DEVELOPER_MODE' ) ? 'There is no required file: '.$config['dir_database'].'cache/links' : 'This page is temporary unavailable' ).'</h1>' );

  $config['pages_links'] = unserialize( file_get_contents( $config['dir_database'].'cache/links' ) );
  if( isset( $_GET ) && is_array( $_GET ) ){
    foreach( $_GET as $mKey => $mValue ){
      if( isset( $config['pages_links']['?'.$mKey] ) ){
        $config['language'] = $config['pages_links']['?'.$mKey][1];
        return $config['pages_links']['?'.$mKey][0];
      }
      else
        return false;
    }
    return true;
  }
} // end function getPageId
?>