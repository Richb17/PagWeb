<?php
include("include/funciones.php");
autenticado();

if( !isset($_POST['metodo']) || !isset($_POST['idCart']) ||
    !isset($_POST['idDireccion']) || !isset($_POST['total'])){
    header($ruta."Portada.php");
}
else if($_POST['metodo']=="" || $_POST['idCart']=="" || $_POST['idDireccion']=="" || $_POST['total']==""){
    header($ruta."Portada.php");
}
else{
    extract($_POST);
    $conexion = conectarBD();

    $res1 = $conexion->query("SELECT `idprod`, `quantity` FROM `item_carrito` WHERE `idcart`=$idCart");
    $texto = "";
    while($row1 = $res1->fetch_array(MYSQLI_ASSOC)){
        $idProd = $row1['idprod'];
        $qty = $row1['quantity'];
        $res2 = $conexion->query("SELECT `albumname`,`artistname`,`format`,`prices` FROM `productos` WHERE `idprod`=$idProd");
        $row2 = $res2->fetch_array(MYSQLI_ASSOC);
        extract($row2);
        $texto = $texto."$albumname de $artistname, $format - \$$prices x $qty ||\n";
    }
    echo "INSERT INTO `detalles_pedido`(`id`, `id_user`, `total`, `id_pay`, `created_at`, `iddireccion`, `descripcion`, `status`) VALUES 
                                        (NULL,'".$_SESSION['idusuario']."','$total','$metodo',now(),$idDireccion,'$texto','Pagado')";
    $conexion->query("INSERT INTO `detalles_pedido`(`id`, `id_user`, `total`, `id_pay`, `created_at`, `iddireccion`, `descripcion`, `status`) VALUES 
                                        (NULL,'".$_SESSION['idusuario']."','$total','$metodo',now(),$idDireccion,'$texto','Pagado')");
    vaciarCarrito($idCart);
    header($ruta."mostrarPedidos.php");
}
?>