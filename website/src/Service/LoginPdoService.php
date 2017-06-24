<?php

namespace jrothert\Service\Login;

class LoginPdoService implements LoginService
{
    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function authenticate($email, $password) 
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE email=? AND password=?");
        $stmt->bindValue(1, $email);
        $stmt->bindValue(2, $password);
        $stmt->execute();

        return $stmt->rowCount() == 1;
        

    }
}
