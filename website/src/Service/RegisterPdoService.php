<?php
namespace jrothert\Service;
use jrothert\Entity\UserEntity;
class RegisterPdoService implements RegisterService {
	private $pdo;
	public function __construct(\PDO $pdo) {
		$this->pdo = $pdo;
	}
	public function registerUser(UserEntity $user) {
		$stmt = $this->pdo->prepare ( "INSERT INTO user (email, password, activated, activationstring) VALUES (?, ?, 0, ?)" );
		$stmt->bindValue ( 1, $user->getEmail () );
		$stmt->bindValue ( 2, $user->getPassword () );
		$stmt->bindValue ( 3, $user->getActivationstring () );
		$stmt->execute ();
	}
	public function userExists ($email) {
		$stmt = $this->pdo->prepare ( "SELECT * FROM user WHERE email=?" );
		$stmt->bindValue ( 1, $email );
		$stmt->execute ();
		
		return $stmt->rowCount () == 0;
	}
	public function activateUser($activationString) {
		$stmt = $this->pdo->prepare ( "UPDATE user SET activated=1 WHERE activationstring=?" );
		$stmt->execute ( [ 
				$activationString 
		] );
	}
}
