<?php

namespace mineichen\Service\Login;

interface LoginService
{
   public function authenticate($username, $password);
}
