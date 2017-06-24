<?php

namespace jrothert\Service\Login;

interface LoginService
{
   public function authenticate($email, $password);
}
