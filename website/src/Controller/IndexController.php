<?php

namespace jrothert\Controller;

use jrothert\SimpleTemplateEngine;

class IndexController 
{
  /**
   * @var ihrname\SimpleTemplateEngine Template engines to render output
   */
  private $template;
  
  /**
   * @param ihrname\SimpleTemplateEngine
   */
  public function __construct(\Twig_Environment $template)
  {
     $this->template = $template;
  }

  public function homepage() {
    echo $this->template->render("hello.html.php", [ 
				"email" => (array_key_exists ( "email", $_SESSION )) ? $_SESSION ["email"] : ""]);
  }

  public function greet($name) {
  	echo $this->template->render("hello.html.php", ["name" => "<b>" . $name . "</b>"]);
  }
}
