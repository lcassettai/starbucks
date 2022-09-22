<?php

class DbConection {

    public $conexion;
    const DB = 'starbucks';
    const USUARIO = 'root';
    const PASSWORD = '';
    const HOST = 'localhost';

    function __construct($host = null, $nombre = null, $usuario = null, $password = null){
            $this->host = $host ?? self::HOST;
            $this->dbName = $nombre ?? self::DB;
            $this->usuario = $usuario ?? self::USUARIO;
            $this->password = $password ?? self::PASSWORD;
    }   

    function dbConnect()    {
        try {
            $this->conexion = new PDO("mysql:host=$this->host;dbname=$this->dbName", $this->usuario, $this->password);

            return $this->conexion;
        } catch (PDOException $e) {
            die("No se pudo conectar con la BD");
            print "Error!: " . $e->getMessage() . "<br/>";
        }
    }

    function dbDisconnect() {
        $this -> conexion = NULL;
        $this -> host = NULL;
        $this -> dbName = NULL;
        $this -> usuario = NULL;
        $this -> password = NULL;
    }
}

?>