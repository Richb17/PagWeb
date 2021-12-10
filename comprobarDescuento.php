<?php
include("include/funciones.php");
autenticado();
$conexion = conectarBD();
if(isset($_GET['code']) && $_GET['code']!=""){
    extract($_GET);
    $res = $conexion->query("SELECT `discountactive` FROM `carritos` WHERE `id_user`=".$_SESSION['idusuario']);
    $resu = $res->fetch_array(MYSQLI_ASSOC);
    if(!$resu['discountactive']){
        echo "SELECT `discount` FROM `descuentos` WHERE `id`='$code'";
        $res = $conexion->query("SELECT `discount` FROM `descuentos` WHERE `id`='$code'");
        if(mysqli_num_rows($res) > 0){
            $resd = $res->fetch_array(MYSQLI_ASSOC);
            $disc = $resd['discount'];
            $conexion->query("UPDATE `carritos` SET `discountactive` = '1', `descuentoaplicado`=$disc WHERE `id_user`=".$_SESSION['idusuario']);
            header($ruta."verCarrito.php?err=0");
        }
        else{
            header($ruta."verCarrito.php?err=3");
        }
    }
    else{
        header($ruta."verCarrito.php?err=2");
    }
}
else{
    header($ruta."verCarrito.php?err=1");
}
?>