<?php
include("include/funciones.php");
autenticado();
$conexion = conectarBD();
echo "DELETE FROM `generoscat` WHERE `name`='".$_GET['name']."'";
$conexion->query("DELETE FROM `generoscat` WHERE `name`='".$_GET['name']."'");
header($ruta."agregarGenero.php?err=4");
?>