<?php
include("funciones.php");
autenticado();
$conexion = conectarBD();
$msg = "";
if(isset($_GET['err']) && $_GET['err'] != ""){
    if($_GET['err'] == "0") $msg = "Se aplicó el descuento";
    if($_GET['err'] == "1") $msg = "Se debe utilizar el formulario de registro";
    if($_GET['err'] == "2") $msg = "Ya había un descuento aplicado";
    if($_GET['err'] == "3") $msg = "El código no era válido";
    if($_GET['err'] == "4") $msg = "Descuento desactivado";
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de compras</title>

    <script type="text/javascript">
        function validaFRM(){
            if(document.getElementById("code").value==""){
                document.getElementById("msgAlerta").innerHTML = "Por favor introduza un código válido.";
                return false;
            }
            else{
                return true;
            }
        }
    </script>

</head>
<body>
    <h2>Carrito de compras</h2>
    <a href="portada.php">Regresar a inicio</a><br>

    <form method="get" action = "comprobarDescuento.php" onsubmit="return validaFRM()">
        <h3>Introduce un código de descuento</h3>
        <?php 
            if($msg != "" ){
                echo "<div id=\"msgAlerta\"> $msg </div>";
            }
            else{
                echo "<div id=\"msgAlerta\"></div>";
            }
            $rs = $conexion->query("SELECT * FROM `descuentos`");
            echo "Seleccione un código de descuento:";
            echo "<select name=\"code\" id=\"code\">";
                while($row = $rs->fetch_array(MYSQLI_ASSOC)){
                    echo "<option value='".$row['id']."'>".$row['code']."</option>";
                }
            echo "</select><br>";
        ?>
        <input type="submit" value="Canjear">
    </form>
    
    <h3>Articulos en el carrito</h3>
    <?php
    $resCarrito =  $conexion->query("SELECT * FROM `carritos` WHERE `id_user` = ".$_SESSION['idusuario']);
    
    if(mysqli_num_rows($resCarrito)>0){
        $carrito = $resCarrito->fetch_array(MYSQLI_ASSOC);
        extract($carrito);
        if($discountactive){
            echo "<a href=\"desactivarDescuento.php\">Desactivar descuento</a>";
        }
        echo "<table>";
        echo "<tr>";
        echo "<td>Album</td>";
        echo "<td>Artista</td>";
        echo "<td>Precio</td>";
        echo "<td>Cantidad</td>";
        echo "<td>Formato</td>";
        echo "<td>Imagenes</td>";
        echo "<td>Eliminar</td>";
        echo "<td>Total</td>";
        echo "</tr>";
        $res1 = $conexion->query("SELECT `idprod`, `quantity` FROM `item_carrito` WHERE `idcart`=$id");
        while($row1 = $res1->fetch_array(MYSQLI_ASSOC)){
            $res2 = $conexion->query("SELECT `albumname`, `artistname`, `iddiscount`, `format`, `prices` FROM `productos` WHERE `idprod`=".$row1['idprod']);
            while($row2 = $res2->fetch_array(MYSQLI_ASSOC)){
                echo "<td>".$row2['albumname']."</td>";
                echo "<td>".$row2['artistname']."</td>";
                $precio = precioDescuentoItem($row1['idprod']);
                echo "<td>$precio</td>";
                echo "<td>".$row1['quantity']." <a href=\"sumaRestaCarrito.php?idCart=$id&idProd=".$row1['idprod']."&band=1\"> +++ </a> <a href=\"sumaRestaCarrito.php?idCart=$id&idProd=".$row1['idprod']."&band=0\"> --- </a></td>";
                echo "<td>".$row2['format']."</td>";
                echo "<td>";
                $imageQRY = $conexion->query("SELECT * FROM `imagenes` WHERE `idprod` = ".$row1['idprod']);
                if($imageQRY){
                    while($img = $imageQRY->fetch_array(MYSQLI_ASSOC)){
                        echo "<img src='mostrarImagen.php?id=".$img["id"]."' width='200' height='200'><br>";
                    }
                }
                echo "</td>";
                echo "<td><a href=\"borrarProdCar.php?idProd=".$row1['idprod']."&idCart=$id\">Eliminar articulo</a></td>";
                echo "<td>".$precio*$row1['quantity']."</td>";
                echo "</tr>";
            } 
        }
        $precioFinal = $total * (1-$descuentoaplicado);
        echo "<tr>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td>Total: \$$precioFinal</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td><a href=\"vaciarCarrito.php?id=$id\">Vaciar carrito</td>";
        echo "<td></td>";
        echo "</tr>";
        echo "</table>";
        mysqli_close($conexion);
    }
    else{
        echo "<h3>No hay un carrito para mostrar</h3>";
    }
    ?>
</body>
</html>
