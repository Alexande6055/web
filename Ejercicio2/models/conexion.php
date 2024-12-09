<?php
 class conexion {
    public function conectar(){
        define('server','localhost'); 
        define('db','soa'); 
        define('user','root');
        define('password','');
        try {
        $conn= new PDO("mysql:host=".server.";dbname=".db,user,password);
        return $conn;
        } catch (Exception $e) {
        echo($e->getMessage());
        }
    }
}
?>