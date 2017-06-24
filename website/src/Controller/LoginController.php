<?php
namespace jrothert\Controller;
use jrothert\SimpleTemplateEngine;
use jrothert\Service\LoginService;
use jrothert\Session;
class LoginController {
	/**
	 *
	 * @var ihrname\SimpleTemplateEngine Template engines to render output
	 */
	private $template;

	/**
	 *
	 * @var \LoginService
	 */
	private $loginService;
	private $session;

	/**
	 *
	 * @param
	 *        	ihrname\SimpleTemplateEngine
	 */
	public function __construct(\Twig_Environment $template, LoginService $loginService, Session $session) {
		$this->template = $template;
		$this->loginService = $loginService;
		$this->session = $session;
	}
	public function showLogin() {
		$this->session->generateToken ();
		echo $this->template->render ( "login.html.twig" );
	}
	public function login(array $data) {
		$_SESSION['csrf_token'] = uniqid('', true);
		if($_POST['csrf'] !== $_SESSION['csrf_token']) {
			die("Ungültiger Token");
		}
		if (! array_key_exists ( 'email', $data ) or ! array_key_exists ( 'password', $data )) {
			$this->showLogin ();
			return;
		}
		if (empty ( $data ['email'] )) {
			echo $this->template->render ( "login.html.twig", [
					"errorMessage" => "Enter a valid Username"
			] );
			return;
		}
		$user = $this->loginService->authenticator( $data ['email'] );
		if ($user and $user->getActivated () and password_verify ( $data ['password'], $user->getPassword () )) {
			$this->session->set ( "email", $user->getEmail () );
			header ( "Location: /" );
		} else {
			echo $this->template->render ( "login.html.twig", [
					"email" => $data ["email"],
					"errorMessage" => "Email or Password are not correct or your account has not been activated yet. Try again ;)"
			] );
		}
	}
	public function logout($token) {
		if ($this->session->compareToken ( $token )) {
			$this->session->unset ();
			header ( "Location: /" );
		}
	}
}