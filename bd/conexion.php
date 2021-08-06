<?php

class Conexion{
    public static function Conectar(){
        define('servidor', 'localhost');
        define('nombre_bd','softcob');
        define('usuario','root');
        define('password','');

        // $opciones = array(
        //     PDO::ATTR_EMULATE_PREPARES => FALSE,
        //     PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION  
        //     );
        try{
            $conexion = new PDO("mysql:host=".servidor."; dbname=".nombre_bd, usuario, password);
            return $conexion;

        }catch(Exception $ex){
            die("El error de conexion es:". $ex->getMessage());
        }
    }
}