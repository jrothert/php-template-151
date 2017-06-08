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
    echo (array_key_exists("email", $_SESSION)) ? "Welcome " . $_SESSION["email"] : "Hello Mr. X";
  }

  public function greet($name) {
  	echo $this->template->render("hello.html.php", ["name" => "<b>" . $name . "</b>"]);
  }
}
