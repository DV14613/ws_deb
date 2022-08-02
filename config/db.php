<?php
class Database
{
    public static function Connect()
    {
        try {
            //mysql
            $conexion = new PDO("mysql:host=" . SERVER_DB . ";port=" . PORT_DB . ";dbname=" . DATABASE, USER_DB, PASSWORD_DB);
            $conexion->query("SET NAMES 'utf8'");
            $conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);//Retornara los datos según el tipo real de la DB

            //postgres
            //$conexion = new PDO("pgsql:host=" . SERVER . ";port=5432;dbname=" . DBNAME, USER, PASSWORD);

            return $conexion;
        } catch (Exception $error) {
            die("Error en la conexión: " . $error->getMessage());
        }
    }
}
