<?php 

namespace jrothert;

class Factory 
{
	private $config;
	public function __construct(array $config)
	{
		$this->config = $config;	
	}
	
	public function getTemplateEngine()
	{
		return new SimpleTemplateEngine(__DIR__ . "/../templates/");
	}
	
	private function getTwigEngine()
	{
		$loader = new \Twig_Loader_Filesystem(__DIR__ . "/../templates/");
		
		return new \Twig_Environment($loader);
	}
	
	public function getIndexController()
	{
		return new Controller\IndexController(
			$this->getTwigEngine()		
		);
	}
	
	public function getLoginController()
	{
		return new Controller\LoginController(
			$this->getTemplateEngine(), 
			$this->getLoginService()
		);
	}
	
	public function getPdo() 
	{
		return new \PDO(
			"mysql:host=mariadb;dbname=app;charset=utf8",
			$this->config["database"]["user"],
			"my-secret-pw",
			[\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
		);
	}
	
	public function getLoginService() {
		return new Service\Login\LoginPdoService(
		 	$this->getPdo()		
	    );
	}
	
	public function getMailer()
	{
		return \Swift_Mailer::newInstance(
				\Swift_SmtpTransport::newInstance("smtp.gmail.com", 465, "ssl")
				->setUsername("gibz.module.151@gmail.com")
				->setPassword("Pe$6A+aprunu")
				);
	}
}
