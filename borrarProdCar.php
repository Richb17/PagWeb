<?php
    include("include/funciones.php");
    autenticado();
    
    if($_GET['idProd']==""){
        header($ruta."verCarrito.php");
    }
    $conexion = conectarBD();
    $res = $conexion->query("SELECT `id_user` FROM `carritos` WHERE `id`=".$_GET['idProd']);
    $resArr = $res->fetch_array(MYSQLI_ASSOC);
    
    
    $resT = $conexion->query("SELECT `total` FROM `carritos` WHERE `id`=".$_GET['idCart']);
    $rs = $resT->fetch_array(MYSQLI_ASSOC);
    $totalcarrito = $rs['total'];
    $resQ = $conexion->query("SELECT `quantity` FROM `item_carrito` WHERE `idCart` = ".$_GET['idCart']." AND `idProd`=".$_GET['idProd']);
    $row = $resQ->fetch_array(MYSQLI_ASSOC);
    actualizarStock($_GET['idProd'], $row['quantity']);
    echo "$totalcarrito<br>";
    $precio = precioDescuentoItem($_GET['idProd']);
    echo $qty = $row['quantity'];
    echo "<br>$precio<br>";
    echo $resta = $precio * $qty;
    $totalcarrito = $totalcarrito - $resta;
    if($totalcarrito < 0.009){
        $totalcarrito = 0.0;
    }
    echo "<br>$totalcarrito<br>";
    echo "UPDATE `carritos` SET `total` = $totalcarrito WHERE `id`=".$_GET['idCart'];
    $conexion->query("UPDATE `carritos` SET `total` = $totalcarrito WHERE `id`=".$_GET['idCart']);
    $conexion->query("DELETE FROM `item_carrito` WHERE `idcart`=".$_GET['idCart']." AND `idprod`=".$_GET['idProd']);
    header($ruta."verCarrito.php");  
?>