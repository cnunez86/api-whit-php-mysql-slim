<?php
require_once 'config.php';

class DataBase
{
    private static $conexion = false;
    private function __construct()
    {
        try 
        {
            $cadenaConexion = "mysql:host=" . DB_SERVIDOR . ";port=" . DB_PUERTO . ";dbname=" . DB_BASEDATOS . ";charset=utf8";
            self::$conexion = new PDO($cadenaConexion, DB_USUARIO, DB_PASSWORD);
            self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } 
        catch (PDOException $e) 
        {
            die("Error conectando al servidor de Base de Datos: " . $e->getMessage());
        }
    }

    public static function getConexion()
    {
        if (!self::$conexion) 
        {
            new self;
        }
        return self::$conexion;
    }
}
?>