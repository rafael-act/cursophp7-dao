<?php
    class Sql extends PDO{
        private $conn;

        public function __construct()
        {
            //cria a conexao com o banco
            $this->conn =new PDO("mysql:host=localhost;dbname=dbphp7", "root","");

        }

        public function query($rawQuery,$params=array())//ignora o erro ta com sobrecarga
        {
            //adiciona o comando a conexao
            $stmt=$this->conn->prepare($rawQuery);

            $this->setParams($stmt,$params);
            $stmt->execute();
            
            return $stmt;
        }

        private function setParams($statment,$parameters=array())
        {

            //adiciona os paramentros ao comando
            foreach ($parameters as $key => $value) {
                $this->setParam($statment,$key,$value);
            }
        }

        private function setParam($statment,$key,$value)
        {
            $statment->bindParam($key,$value);
        }

        public function select($rawQuery,$params=array())
        {
            $stmt = $this->query($rawQuery,$params);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>