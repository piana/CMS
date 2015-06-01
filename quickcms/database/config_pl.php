<?php
/*
* Dane konfiguracyjne strony zależne od języka
* Więcej: http://opensolution.org/docs/?p=pl-settings
*/
setlocale( LC_CTYPE, 'pl_PL' );

/*
* Id strony startowej (głównej)
* Więcej: http://opensolution.org/docs/?p=pl-settings#start_page
*/
$config['start_page'] = "1";

/*
* Logo strony. Możesz wstawić tu także obrazek stosując kod HTML
* Więcej: http://opensolution.org/docs/?p=pl-settings#logo
*/
$config['logo'] = "Dawid<span>.</span><strong>Pianka</strong>";

/*
* Tytuł wyświetlający się w znaczniku TITLE obok nazwy aktualnie przeglądanej podstrony
* Więcej: http://opensolution.org/docs/?p=pl-settings#title
*/
$config['title'] = "Quick.Cms - szybki i prosty system zarządzania treścią";

/*
* Opis strony wyświetlający się w znaczniku META DESCRIPTION, jeśli strona nie posiada wpisanego opisu meta
* Więcej: http://opensolution.org/docs/?p=pl-settings#description
*/
$config['description'] = "Szybki i prosty system zarządzania treścią. Skrypt napisany w języku PHP, oparty o plikową bazę danych i zgodny ze standardami XHTML 1.1 i WAI.";

/*
* Slogan, który wyświetla się domyślnie pod logo. Można tu zastosować kod HTML
* Więcej: http://opensolution.org/docs/?p=pl-settings#slogan
*/
$config['slogan'] = "Najprostszy CMS ever";

/*
* Treść stopki strony, która domyślnie znajduje się po lewej stronie
* Więcej: http://opensolution.org/docs/?p=pl-settings#foot_info
*/
$config['foot_info'] = 'Wszelkie prawa zastrzeżone';
?>