<?php
session_start();
$ruta = "location:http://localhost/DesWeb%20PHP/Modulos/";

function conectarBD(){
    $conexion = mysqli_connect("localhost", "root", "", "tiendadesweb");
        if (!$conexion) {
            die("Connection failed: " . mysqli_connect_error());
        }
    
    return $conexion;
}

function autenticado(){
    if(!isset($_SESSION["idusuario"])){
        header("location:http://localhost/DesWeb%20PHP/Modulos/Portada.php");
    }
}
?>