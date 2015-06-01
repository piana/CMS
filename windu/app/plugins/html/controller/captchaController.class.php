<?php /*windu.org html controller*/
Class captchaController extends controller{
	public function index() {
		session_start();
		$captcha = new simpleCaptcha();
		$captcha->CreateImage();
	}
}
?>