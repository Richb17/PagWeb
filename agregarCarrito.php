<?php
    include("funciones.php");
    autenticado();
    if(!isset($_GET['id'])){
        header($ruta."Portada.php");
    }
    echo "<a href=\"portada.php\">Regresar a inicio</a><br><br>";
    extract($_GET);//Se extrae el dato pasado por get
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
   
    if(mysqli_num_rows($consulta) == 0){ //Si no hay ningun articulo que coincida, se crea uno nuevo
        echo "INSERT INTO `item_carrito`(`id`, `idcart`, `idprod`, `quantity`, `created_at`, `modified_at`) VALUES 
        (NULL,'$idcarrito','$id','1',now(),now())";
        echo "<br>";
        $conexion->query("INSERT INTO `item_carrito`(`id`, `idcart`, `idprod`, `quantity`, `created_at`, `modified_at`) VALUES 
                                                            (NULL,'$idcarrito','$id','1',now(),now())");
        if(comprobarStockUnPaso($id,1)){
            $qty = 1;
            actualizarStock($id,-1);
        }
        else{
            header($ruta."Portada.php");
        }
    }
    else{//Si ya hay un articulo se agrega uno a la cuenta
        echo "SELECT `quantity` FROM `item_carrito` WHERE `idprod` = $id AND `idcart`=$idcarrito";
        echo "<br>";
        $qtyRes = $conexion->query("SELECT `quantity` FROM `item_carrito` WHERE `idprod` = '$id' AND `idcart`= '$idcarrito'");
        $resQ = $qtyRes->fetch_array(MYSQLI_ASSOC);
        if(comprobarStockUnPaso($id,1)){
            echo $resQ['quantity'];
            echo "<br>";
            $qty = $resQ['quantity'] + 1;
            echo $qty;
            echo "<br>";
            actualizarStock($id,-1);
        }
        else{
            header($ruta."Portada.php");
        }
        $conexion->query("UPDATE `item_carrito` SET `quantity`='$qty',`modified_at`=now() WHERE `idprod` = $id");
    }
    //Se suma el precio del articulo al costo total
    $totalcarrito += $precio;
    $conexion->query("UPDATE `carritos` SET `total` = $totalcarrito WHERE `id` = $idcarrito");
 
    header($ruta."Portada.php");
?>