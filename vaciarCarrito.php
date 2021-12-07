<?php
    include("funciones.php");
    autenticado();
    
    if($_GET['id']==""){
        header($ruta."Portada.php");
    }
    echo $_GET['id'];
    $conexion = conectarBD();
    $res = $conexion->query("SELECT `id_user` FROM `carritos` WHERE `id`=".$_GET['id']);
    $resArr = $res->fetch_array(MYSQLI_ASSOC);
    
    if($_SESSION['idusuario'] != $resArr['id_user']){
        header($ruta."Portada.php");
    }
    
    $res = $conexion->query("SELECT `idprod`, `quantity` FROM `item_carrito` WHERE `idCart` = ".$_GET['id']);
    if(mysqli_num_rows($res)>0){
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            actualizarStock($row['idprod'], $row['quantity']);
        }
    }

    $conexion->query("UPDATE `carritos` SET `total` = 0.0 WHERE `id`=".$_GET['id']);
    $conexion->query("DELETE FROM `item_carrito` WHERE `idCart`=".$_GET['id']);
    header($ruta."verCarrito.php");
?>