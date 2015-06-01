<h1>{L key = "admin.mail.registeradminuser.tpl.welcome"} {config::get('pageName')}</h1>
{L key = "admin.mail.registeradminuser.tpl.yourusername"}: <strong>{$data.email}</strong><br>
{L key = "admin.mail.registeradminuser.tpl.yourpassword"}: <strong>{$data.password}</strong><br><br>
{L key = "admin.mail.registeradminuser.tpl.loginlink"}: <a href="{$HOME}admin/">{$HOME}admin/</a><br><br>

{L key = "admin.mail.registeradminuser.tpl.reminder"}