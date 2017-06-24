<?php
namespace jrothert;
use jrothert\Session;
use jrothert\Controller\PasswordController;
use jrothert\Twig;
class Factory {
	private $config;
	private $session;
	public function __construct(array $config) 
	{
		$this->config = $config;
	}
	public function getIndexController() 
	{
		return new Controller\IndexController(
				$this->getTwigEngine()
				);
	}
	public function getLoginController() 
	{
		return new Controller\LoginController ( $this->getTwigEngine (), $this->getLoginService (), $this->getSession () );
	}
	public function getRegisterController()
	{
		return new Controller\RegisterController ( $this->getTwigEngine (), $this->getRegisterService (), $this->getMailer () );
	}
	public function getPasswordController()
	{
		return new Controller\PasswordController ( $this->getTwigEngine (), $this->getPasswordService (), $this->getMailer () );
	}	
	public function getTemplateEngine() 
	{
		return new SimpleTemplateEngine ( __DIR__ . "/../templates/" );
	}
	public function getTwigEngine() 
	{
		$loader = new \Twig_Loader_Filesystem ( __DIR__ . "/../templates/" );
		$twig = new \Twig_Environment ( $loader );
		$twig->addGlobal ( "_SESSION", $this->getSession () );
		return $twig;
	}
	public function getMailer() 
	{
		return \Swift_Mailer::newInstance ( \Swift_SmtpTransport::newInstance ( $this->config ["mailer"] ["host"], $this->config ["mailer"] ["port"], $this->config ["mailer"] ["security"] )->setUsername ( $this->config ["mailer"] ["email"] )->setPassword ( $this->config ["mailer"] ["password"] ) );
	}
	public function getPDO() 
	{
		return new \PDO(
				"mysql:host=mariadb;dbname=app;charset=utf8",
				$this->config["database"]["user"],
				"my-secret-pw",
				[\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
				);
	}
	public function getLoginService() {
		return new Service\LoginPdoService ( $this->getPDO () );
	}
	public function getRegisterService() 
	{
		return new Service\RegisterPdoService ( $this->getPDO () );
	}
	public function getPasswordService() 
	{
		return new Service\PasswordPdoService ( $this->getPDO () );
	}
	public function getSession() 
	{
		if (! $this->session) {
			$this->session = new \jrothert\Session ();
		}
		return $this->session;
	}
}
