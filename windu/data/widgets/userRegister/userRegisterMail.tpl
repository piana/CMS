{L key = "register.mail.tpl.welcome"} <strong>{$user.username}</strong><br><br>

{L key = "register.mail.tpl.regged"} {config::get('pageName')}<br>
{L key = "register.mail.tpl.tocont"} <a href="{$HOME}do/activateUser/{$sessionKey}/">{L key = "register.mail.tpl.activate"}</a><br><br>

{L key = "register.mail.tpl.iffor"}<br>
{$HOME}do/activateUser/{$sessionKey}/<br><br>

{L key = "register.mail.tpl.team"} {config::get('pageName')}
