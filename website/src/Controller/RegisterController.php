<?php
namespace jrothert\Controller;
use jrothert\Service\RegisterService;
use jrothert\Entity\UserEntity;
class RegisterController {
	/**
	 *
	 * @var ihrname\SimpleTemplateEngine Template engines to render output
	 */
	private $template;
	
	/**
	 *
	 * @var \RegisterService
	 */
	private $registerService;
	private $mailer;
	
	/**
	 *
	 * @param
	 *        	ihrname\SimpleTemplateEngine
	 */
	public function __construct(\Twig_Environment $template, RegisterService $registerService, \Swift_Mailer $mailer) {
		$this->template = $template;
		$this->registerService = $registerService;
		$this->mailer = $mailer;
	}
	public function showRegister() {
		echo $this->template->render ( "register.html.twig" );
	}
	public function register(array $data) {
		if($_POST['csrf'] !== $_SESSION['csrf_token']) {
			die("Ungültiger Token");
		}
		if (! array_key_exists( 'email', $data ) or ! array_key_exists ( 'password', $data ) or ! array_key_exists ( 'confirmPassword', $data )) {
			$this->showRegister ();
			return;
		}
		
		if (empty ( $data ["email"] ) or empty ( $data ["password"] )) {
			echo $this->template->render ( "register.html.twig", [
					"email" => $data ['email'] 
			] );
			return;
		}
		
		if (! $this->registerService->userExists ($data ["email"] )) {
			echo $this->template->render ( "register.html.twig", [ 
					"errorMessage" => "Email exists already" 
			] );
			return;
		}
		
		if ($data ["password"] == $data ["confirmPassword"]) {
			$activationstring = md5 ( random_bytes ( 1000 ) );
			$user = new UserEntity ( $data ["email"], password_hash ( $data ["password"], PASSWORD_DEFAULT ), 0, $activationstring );
			$this->registerService->registerUser ( $user );
			$this->mailer->send ( \Swift_Message::newInstance ( "User Activation" )->setFrom ( [ 
					'noreply@theblogger.com' 
			] )->setTo ( [ 
					$data ["email"] 
			] )->setBody ( '<html>' . ' <head></head>' . ' <body>' . ' <p>Hello There '. '</p><p>! You are about to create a account for my Personal trainier, to finish your registration Click  <a href="https://' . $_SERVER ["HTTP_HOST"] . '/activate/' . $activationstring . '">here</a> </p>' . ' ' . ' </body>' . '</html>', 'text/html' ) );
			echo $this->template->render ( "registerConfirmation.html.twig" );
		} else {
			echo $this->template->render ( "register.html.twig", [ 
					"email" => $data ["email"],
					"errorMessage" => "Passwords do not match" 
			] );
		}
	}
	public function activate($activationString) {
		$this->registerService->activateUser ( $activationString );
		echo $this->template->render ( "activationConfirmation.html.twig" );
	}
}
