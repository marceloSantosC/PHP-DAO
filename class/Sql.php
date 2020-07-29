<?php
class Sql extends PDO {
    private $conn;

    public function __construct($dsn, $user, $password){
        $this->conn = new PDO($dsn, $user, $password);
    }

    private function setParam($statement, $key, $value){
        $statement->bindParam($key, $value);
    }

    private function setParams($statement, $params = array()){
        foreach($params as $key => $value){
            $this->setParam($key, $value);
        }
    }

    public function query($sqlQuery, $placeholderValues = array()){
        $PDOstatement = $this->conn->prepare($sqlQuery);
        $this->setParams($PDOstatement, $placeholderValues);
        $PDOstatement->execute();
        return $PDOstatement;
    }

    public function select($sqlQuery, $placeholderValues = array()):array
    {
        $PDOstatement = $this->query($sqlQuery, $placeholderValues);
        return $PDOstatement->fetchAll(PDO::FETCH_ASSOC);
    }
}