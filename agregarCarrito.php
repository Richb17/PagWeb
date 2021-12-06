<?php
    include("funciones.php");
    autenticado();
    if(!isset($_GET['id'])){
        header($ruta."Portada.php");
    }
    extract($_GET);
    $conexion = conectarBD();

    $res = $conexion->query("SELECT * FROM `carritos` WHERE `id_user`='".$_SESSION['idusuario']."'");

    if(mysqli_num_rows($res) == 0){
        $conexion->query("INSERT INTO `carritos`(`id_user`, `total`) VALUES ('".$_SESSION['idusuario']."','0.0')");
        $res = $conexion->query("SELECT * FROM `carritos` WHERE `id_user`='".$_SESSION['idusuario']."'");
    }
    $ext = $res->fetch_array(MYSQLI_ASSOC);
    $totalcarrito = $ext['total'];
    $idcarrito = $ext['id'];

    $resProd = $conexion->query("SELECT `prices`, `iddiscount` FROM `productos` WHERE `idprod`=$id");
    $valuesProd = $resProd->fetch_array(MYSQLI_ASSOC);
    $precio = $valuesProd['prices'];
    if($valuesProd['iddiscount'] != NULL){ 
        $iddiscount = $valuesProd['iddiscount'];
        echo "SELECT `discount` FROM `descuentos` WHERE `id`=$iddiscount";
        $resDisc = $conexion->query("SELECT `discount` FROM `descuentos` WHERE `id`=$iddiscount");
        $resD = $resDisc->fetch_array(MYSQLI_ASSOC);
        $desc = $resD['discount'];
        $precio *= (1-$desc);
    }

    $consulta = $conexion->query("SELECT * FROM `item_carrito` WHERE `idprod` = $id");
    if(mysqli_num_rows($consulta) == 0){
        $conexion->query("INSERT INTO `item_carrito`(`idcart`, `idprod`, `quantity`, `created_at`, `modified_at`) VALUES 
                                                            ('$idcarrito','$id','1',now(),now())");
        $qty = 1;
    }
    else{
        $qtyRes = $conexion->query("SELECT `quantity` FROM `item_carrito` WHERE `idprod` = $id");
        $resQ = $qtyRes->fetch_array(MYSQLI_ASSOC);
        $qty = $resQ['quantity'] + 1;
        $conexion->query("UPDATE `item_carrito` SET `quantity`='$qty',`modified_at`=now() WHERE `idprod` = $id");
    }
    echo "$totalcarrito = $totalcarrito + ($precio*$qty)";
    $totalcarrito += $precio*$qty;
    $conexion->query("UPDATE `carritos` SET `total` = $totalcarrito WHERE `id` = $idcarrito");

    header($ruta."Portada.php");
?>