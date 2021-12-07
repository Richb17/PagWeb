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

function crearBarraBusqueda(){
    echo "<FORM METHOD='post' ACTION=\"buscar.php\">";
    echo "Buscar: <INPUT TYPE=\"text\" id='busqueda' name='busqueda'>";
    echo "<input type=\"submit\" value=\"Buscar\">";
    echo "</FORM>";
}

function regresarUltimaUbi($ubi){
    header("location:http://localhost/DesWeb%20PHP/Modulos/".$ubi);
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
    if( ($stock - $qty) > 0 ){
        return true;
    }
    return false;
}

function comprobarStockBatch($idprod, $qty){
    $stock = conseguirStock($idprod);
    if( ($stock - $qty) > 0 ){
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
    $conexion->query("UPDATE `stock` SET `quantity`=$stock WHERE `id`=".$idstock['idstock']);
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
?>