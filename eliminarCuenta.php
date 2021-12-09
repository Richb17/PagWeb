<?php
include("include/funciones.php");

$conexion = conectarBD();

echo "DELETE FROM `usuario` WHERE `idusuario`= '" . $_SESSION['idusuario'] . "';";
$conexion->query("DELETE FROM `usuario` WHERE `idusuario`= '" . $_SESSION['idusuario'] . "';");

header($ruta."logout.php");
?>