<?php

class Sql extends PDO {
    
    private $conn;

    public function __construct(){

        $this->conn = new PDO("mysql:host=localhost;dbname=dbphp7", "root", "");

    }

    private function setParams($statment, $parameters = array()){

        foreach($parameters as $k => $v){
            $this->setParam($k, $v);
        }

    }

    private function setParam($statment, $chave, $valor){

        $statment->bindParam($chave, $valor);

    }

    public function query($rowQuery, $params = array()){

        $stmt = $this->conn->prepare($rowQuery);

        $this->setParams($stmt, $params);

        $stmt->execute();

        return $stmt;

    }

    public function select($rowQuery, $params = array()):array{

        $stmt = $this->query($rowQuery, $params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);



    }
}

?>