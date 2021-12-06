<?php
include("funciones.php");
autenticado();
echo "<a href=\"portada.php\">Regresar a inicio</a><br>";

$conexion = conectarBD();

$resCarrito =  $conexion->query("SELECT * FROM `carritos` WHERE `id_user` = ".$_SESSION['idusuario']);

if($resCarrito){
    $carrito = $resCarrito->fetch_array(MYSQLI_ASSOC);
    extract($carrito);
    echo "<table>";
    echo "<tr>";
    echo "<td>Album</td>";
    echo "<td>Artista</td>";
    echo "<td>Precio</td>";
    echo "<td>Cantidad</td>";
    echo "<td>Formato</td>";
    echo "<td>Imagenes</td>";
    echo "<td>Total</td>";
    echo "</tr>";
    $res1 = $conexion->query("SELECT `idprod`, `quantity` FROM `item_carrito` WHERE `idcart`=$id");
    while($row1 = $res1->fetch_array(MYSQLI_ASSOC)){
        $res2 = $conexion->query("SELECT `albumname`, `artistname`, `iddiscount`, `format`, `prices` FROM `productos` WHERE `idprod`=".$row1['idprod']);
        while($row2 = $res2->fetch_array(MYSQLI_ASSOC)){
            echo "<td>".$row2['albumname']."</td>";
            echo "<td>".$row2['artistname']."</td>";
            if($row2['iddiscount'] == NULL){
                echo "<td>".$row2['prices']."</td>";
            }
            else{
                $resu = $conexion->query("SELECT `discount` FROM `descuentos` WHERE `id` = ".$row2['iddiscount'].";");
                $disc = $resu->fetch_array(MYSQLI_ASSOC);
                $descuento = $disc['discount'];
                $precioFinal = $row2['prices'] * (1-$descuento);
                echo "<td>$precioFinal</td>";
            }
            echo "<td>".$row1['quantity']."</td>";
            echo "<td>".$row2['format']."</td>";
            echo "<td>";
            $imageQRY = $conexion->query("SELECT * FROM `imagenes` WHERE `idprod` = ".$row1['idprod']);
            if($imageQRY){
                while($img = $imageQRY->fetch_array(MYSQLI_ASSOC)){
                    echo "<img src='mostrarImagen.php?id=".$img["id"]."' width='200' height='200'><br>";
                }
            }
            echo "</td>";
            echo "</tr>";
        } 
    }
    echo "<tr>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td>Total: \$$total</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td><a href=\"vaciarCarrito.php\">Vaciar carrito</td>";
    echo "</tr>";
    echo "</table>";
    mysqli_close($conexion);
}

?>