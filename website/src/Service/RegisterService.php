<?php
namespace jrothert\Service;
use jrothert\Entity\UserEntity;
interface RegisterService {
	public function userExists($email);
	public function registerUser(UserEntity $user);
	public function activateUser($activationString);
}