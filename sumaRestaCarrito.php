<?php
    include("include/funciones.php");
    autenticado();
    
    if(!isset($_GET['id']) || !isset($_GET['band'])){
        header($ruta."Portada.php");
    }
    if($_GET['id']=="" || $_GET['band']==""){
        header($ruta."verCarrito.php");
    }
    extract($_GET);
    $conexion = conectarBD();
    $precio = precioDescuentoItem($idProd);
    if($band == 1 && comprobarStockUnPaso($idProd,1)){//Suma
        $conexion->query("UPDATE `item_carrito` SET `quantity`=`quantity` + 1,`modified_at`=now() WHERE idcart=$idCart AND idprod=$idProd;");
        actualizarStock($idProd,-1);
        $conexion->query("UPDATE `carritos` SET `total`=`total`+$precio WHERE id=$idCart");
    }
    else if($band == 0){//Resta
        $rs = $conexion->query("SELECT `quantity` FROM `item_carrito` WHERE idcart=$idCart AND idprod=$idProd;");
        $res = $rs->fetch_array(MYSQLI_ASSOC);
        $qty = $res['quantity'];
        if($qty-1>0){
            $conexion->query("UPDATE `item_carrito` SET `quantity`=`quantity` - 1,`modified_at`=now() WHERE idcart=$idCart AND idprod=$idProd;");
        }
        else{
            $conexion->query("DELETE FROM `item_carrito` WHERE idcart=$idCart AND idprod=$idProd;");
        }
        $conexion->query("UPDATE `carritos` SET `total`=`total`-$precio WHERE id=$idCart");
        actualizarStock($idProd,1);
    }

    header($ruta."verCarrito.php");

?>