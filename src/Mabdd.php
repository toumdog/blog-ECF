<?php

namespace ECF;

class Mabdd extends \PDO 
{
    private string $bdd= "mysql";
    private string $host = "localhost";
    private string $dbname = "ecf";
    private string $port = "3306";
    private string $username = "root";
    private string $password = "";
    private array $options =[\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ];

    public function __construct()
    {
        $dsn = "{$this->bdd}:host={$this->host};dbname={$this->dbname};port={$this->port}";
        
        parent::__construct($dsn, $this->username, $this->password, $this->options );

    }

}
