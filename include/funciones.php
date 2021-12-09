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

function regresarUltimaUbi($ubi){
    header("location:http://localhost/DesWeb%20PHP/Modulos/".$ubi.".php");
}

function conseguirStock($idprod){
    $conexion = conectarBD();
    $stock = $conexion->query("SELECT `idstock` FROM `productos` WHERE `idprod` = $idprod");
    $idstock = $stock->fetch_array(MYSQLI_ASSOC);
    $res = $conexion->query("SELECT `quantity` FROM `stock` WHERE `id`=".$idstock['idstock']);
    $qty = $res->fetch_array(MYSQLI_ASSOC);
    mysqli_close($conexion);
    return $qty['quantity'];
}

function comprobarStockUnPaso($idprod, $qty){
    $stock = conseguirStock($idprod);
    if( ($stock - $qty) >= 0 ){
        return true;
    }
    return false;
}

function comprobarStockBatch($idprod, $qty){
    $stock = conseguirStock($idprod);
    if( ($stock - $qty) >= 0 ){
        return $qty;
    }
    else{
        return comprobarStockBatch($idprod, $qty-1);
    }
}

function actualizarStock($idprod, $n){
    $stock = conseguirStock($idprod);
    $stock += $n;
    $conexion = conectarBD();
    $res = $conexion->query("SELECT `idstock` FROM `productos` WHERE `idprod` = $idprod");
    $idstock = $res->fetch_array(MYSQLI_ASSOC);
    $conexion->query("UPDATE `stock` SET `quantity`=$stock, `modified_at`=now() WHERE `id`=".$idstock['idstock']);
}

function precioDescuentoItem($idprod){
    $conexion = conectarBD();
    $resProd = $conexion->query("SELECT `prices`, `iddiscount` FROM `productos` WHERE `idprod`=$idprod");
    $valuesProd = $resProd->fetch_array(MYSQLI_ASSOC);
    $precio = $valuesProd['prices'];
    if($valuesProd['iddiscount'] != NULL){ 
        $iddiscount = $valuesProd['iddiscount'];
        $resDisc = $conexion->query("SELECT `discount` FROM `descuentos` WHERE `id`=$iddiscount");
        $resD = $resDisc->fetch_array(MYSQLI_ASSOC);
        $desc = $resD['discount'];
        $precio *= (1-$desc);
    }
    mysqli_close($conexion);
    return $precio;
}

function agregarAlCarrito($id, $n){
    $conexion = conectarBD();
    //Se extraen los datos del carrito si es que existen, basados en el usuario que haya iniciado sesión
    $res = $conexion->query("SELECT * FROM `carritos` WHERE `id_user`='".$_SESSION['idusuario']."'");
    //En caso de que no se haya creado un carrito, se crea uno para el usuario
    if(mysqli_num_rows($res) == 0){
        $conexion->query("INSERT INTO `carritos`(`id_user`, `total`) VALUES ('".$_SESSION['idusuario']."','0.0')");
        $res = $conexion->query("SELECT * FROM `carritos` WHERE `id_user`='".$_SESSION['idusuario']."'");
    }
    //Se pasan a variables los datos extraidos del carrito
    $ext = $res->fetch_array(MYSQLI_ASSOC);
    $totalcarrito = $ext['total'];
    $idcarrito = $ext['id'];
    //Se saca el precio del producto seleccionado, calculando si tiene descuento o no
    $precio = precioDescuentoItem($id);
    //Se seleccionan los datos del item del carrito que corresponde al producto seleccionado, si existe
    $consulta = $conexion->query("SELECT * FROM `item_carrito` WHERE `idprod` = $id AND `idCart` = $idcarrito");
    $n = comprobarStockBatch($id,$n);
    if($n>0){
        if(mysqli_num_rows($consulta) == 0){ //Si no hay ningun articulo que coincida, se crea uno nuevo
            $conexion->query("INSERT INTO `item_carrito`(`id`, `idcart`, `idprod`, `quantity`, `created_at`, `modified_at`) VALUES 
                                                        (NULL,'$idcarrito','$id','$n',now(),now())");
        }
        else{//Si ya hay un articulo se agrega uno a la cuenta
            $conexion->query("UPDATE `item_carrito` SET `quantity`=`quantity`+$n,`modified_at`=now() WHERE idcart = $idcarrito AND idprod = $id;");
        }
        actualizarStock($id,-1);
    }
    //Se suma el precio del articulo al costo total
    $totalcarrito += ($precio*$n);
    $conexion->query("UPDATE `carritos` SET `total` = $totalcarrito WHERE `id` = $idcarrito");
}

function vaciarCarrito($idCar){
    $conexion = conectarBD();
    $res = $conexion->query("SELECT `idprod`, `quantity` FROM `item_carrito` WHERE `idCart` = $idCar");
    if(mysqli_num_rows($res)>0){
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            actualizarStock($row['idprod'], $row['quantity']);
        }
    }
    $conexion->query("UPDATE `carritos` SET `total` = 0.0, `discountactive`='0', `descuentoaplicado`=0.0 WHERE `id`=$idCar");
    $conexion->query("DELETE FROM `item_carrito` WHERE `idCart`=$idCar");
}

function ordenarArticulos($ord, $conexion, $limit){
    switch($ord){
        case 0:
            $res = $conexion->query("SELECT `idprod` FROM `productos` ORDER BY `artistname` ASC LIMIT $limit");
            break;
        case 1:
            $res = $conexion->query("SELECT `idprod` FROM `productos` ORDER BY `artistname` DESC LIMIT $limit");
            break;
        case 2:
            $res = $conexion->query("SELECT `idprod` FROM `productos` ORDER BY `albumname` ASC LIMIT $limit");
            break;
        case 3:
            $res = $conexion->query("SELECT `idprod` FROM `productos` ORDER BY `albumname` DESC LIMIT $limit");
            break;
        case 4:
            $res = $conexion->query("SELECT `idprod` FROM `productos` ORDER BY `prices` DESC LIMIT $limit");
            break;
        case 5:
            $res = $conexion->query("SELECT `idprod` FROM `productos` WHERE `format`='CD' LIMIT $limit");
            break;
        case 6:
            $res = $conexion->query("SELECT `idprod` FROM `productos` WHERE `format`='Vinilo' LIMIT $limit");
            break;
        case 7:
            $res = $conexion->query("SELECT `idprod` FROM `productos` WHERE `format`='Cassete' LIMIT $limit");
            break;
    }
    return $res;
}

function ordenarArticulosGenero($ord, $conexion, $limit, $gen){
    switch($ord){
        case 0:
            $res = $conexion->query("SELECT `idprod` FROM `productos` WHERE `genre` = '$gen' ORDER BY `artistname` ASC LIMIT $limit");
            break;
        case 1:
            $res = $conexion->query("SELECT `idprod` FROM `productos` WHERE `genre` = '$gen' ORDER BY `artistname` DESC LIMIT $limit");
            break;
        case 2:
            $res = $conexion->query("SELECT `idprod` FROM `productos` WHERE `genre` = '$gen' ORDER BY `albumname` ASC LIMIT $limit");
            break;
        case 3:
            $res = $conexion->query("SELECT `idprod` FROM `productos` WHERE `genre` = '$gen' ORDER BY `albumname` DESC LIMIT $limit");
            break;
        case 4:
            $res = $conexion->query("SELECT `idprod` FROM `productos` WHERE `genre` = '$gen' ORDER BY `prices` DESC LIMIT $limit");
            break;
        case 5:
            $res = $conexion->query("SELECT `idprod` FROM `productos` WHERE `format`='CD' AND `genre` = '$gen' LIMIT $limit");
            break;
        case 6:
            $res = $conexion->query("SELECT `idprod` FROM `productos` WHERE `format`='Vinilo' AND `genre` = '$gen' LIMIT $limit");
            break;
        case 7:
            $res = $conexion->query("SELECT `idprod` FROM `productos` WHERE `format`='Cassete' AND `genre` = '$gen' LIMIT $limit");
            break;
    }
    return $res;
}
?>