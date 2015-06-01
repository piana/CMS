Witaj <strong>{{$user.username}}</strong><br><br>

Zarejestrowałeś się na stronie {{config::get('pageName')}}<br>
Aby aktywować swoje konto naciśnij na poniższy link: <a href="{{$HOME}}do/activateUser/{{$sessionKey}}/">Aktywuj konto!</a><br><br>

Jeśli z jakiegoś powodu link nie jest klikalny, skopiuj jego zawartość i wklej w pasek przeglądarki internetowej po czym naciśnij "enter".<br>
{{$HOME}}do/activateUser/{{$sessionKey}}/<br><br>

Zespół {{config::get('pageName')}} 
<div class="twoja"></div>
