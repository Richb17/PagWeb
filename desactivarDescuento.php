<?php
include("include/funciones.php");
autenticado();
$conexion = conectarBD();
$res = $conexion->query("SELECT `discountactive` FROM `carritos` WHERE `id_user`=".$_SESSION['idusuario']);
$resu = $res->fetch_array(MYSQLI_ASSOC);
if($resu['discountactive']){
    $conexion->query("UPDATE `carritos` SET `discountactive` = '0', `descuentoaplicado`='0.0' WHERE `id_user`=".$_SESSION['idusuario']);
    header($ruta."verCarrito.php?err=4");
}
else{
    header($ruta."verCarrito.php?");
}
?>