<?php
include("include/funciones.php");
autenticado();

$conexion = conectarBD();
if($_GET['un']==$_SESSION['username'] || $_SESSION['role']>1){
    $conexion->query("DELETE FROM `reseña` WHERE `username` = '".$_GET['un']."' AND `idprod` =".$_GET['id']);
    
    regresarUltimaUbi($_GET['ubi']);
}
else{
    echo "sali";
    regresarUltimaUbi($_GET['ubi']);
}
