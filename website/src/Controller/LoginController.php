<?php

namespace jrothert\Controller;

use jrothert\SimpleTemplateEngine;
use jrothert\Service\Login\LoginService;

class LoginController 
{
  /**
   * @var ihrname\SimpleTemplateEngine Template engines to render output
   */
  private $template;
 
  private $loginService;

  /**
   * @param ihrname\SimpleTemplateEngine
   * @param PDO
   */
  public function __construct(SimpleTemplateEngine $template, LoginService $loginService)
  {
     $this->template = $template;
     $this->loginService = $loginService;
  }
  
  public function showLogin()
  {
  	 echo $this->template->render("login.html.php");
  }
  public function login(array $data)
  {
  	if(array_key_exists("email", $data) OR array_key_exists("password", $data)) {
  		if($this->loginService->authenticate($data["email"], $data["password"])) {
  			$_SESSION["email"] = $data["email"];
  			header('Location: /');
  		}
  	}
  	
  	 else {
  		echo $this->template->render("login.html.php", [
  			"email" => $data["email"]
  		]);
  	}
  	
  }
  public function logout($token) {
  	if ($this->session->compareToken ( $token )) {
  		$this->session->unset ();
  		header ( "Location: /" );
  	}
  }
}
















