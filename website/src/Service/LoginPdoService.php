<?php
namespace jrothert\Service;
use jrothert\Entity\UserEntity;
class LoginPdoService implements LoginService {
	private $pdo;
	public function __construct(\PDO $pdo) {
		$this->pdo = $pdo;
	}
	public function authenticator($email) {
		$stmt = $this->pdo->prepare ( "SELECT * FROM user WHERE email=?");
		$stmt->bindValue ( 1, $email );
		$stmt->execute ();
		$obj = $stmt->fetchObject ();
		if ($obj) {
			$user = new UserEntity ($obj->email, $obj->password, $obj->activated, $obj->activationstring );
			return $user;
		} else {
			return $obj;
		}
	}
}