<?php
include("funciones.php");
autenticado();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprar</title>

    <script type="text/javascript">
        function validaFRM_d(){
            if(document.getElementById("dir").value=="" || document.getElementById("ciudad").value=="" ||
               document.getElementById("pais").value=="" || document.getElementById("codP").value==""){
                alert("Por favor llene todos los campos.");
                return false;
            }
            else{
                return true;
            }
        }

        function validaFRM_p(){
            if(document.getElementById("direccion").value==""){
                alert("Por favor llene todos los campos.");
                return false;
            }
            else{
                return true;
            }
        }
    </script>
</head>
<body>
    <h3>Pedido</h3>
    <?php
    echo "<a href=\"Portada.php\">Regresar al inicio</a>";
    $conexion = conectarBD();
    $resCarrito =  $conexion->query("SELECT * FROM `carritos` WHERE `id_user` = ".$_SESSION['idusuario']);
    
    if(mysqli_num_rows($resCarrito)>0){
        $carrito = $resCarrito->fetch_array(MYSQLI_ASSOC);
        extract($carrito);
        if($discountactive){
            echo "<a href=\"desactivarDescuento.php\">Desactivar descuento</a>";
        }
        $res1 = $conexion->query("SELECT `idprod`, `quantity` FROM `item_carrito` WHERE `idcart`=$id");
        if(mysqli_num_rows($res1) > 0){
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
            while($row1 = $res1->fetch_array(MYSQLI_ASSOC)){
                $res2 = $conexion->query("SELECT `albumname`, `artistname`, `iddiscount`, `format`, `prices` FROM `productos` WHERE `idprod`=".$row1['idprod']);
                while($row2 = $res2->fetch_array(MYSQLI_ASSOC)){
                    echo "<td>".$row2['albumname']."</td>";
                    echo "<td>".$row2['artistname']."</td>";
                    $precio = precioDescuentoItem($row1['idprod']);
                    echo "<td>$precio</td>";
                    echo "<td>".$row1['quantity']."</td>";
                    echo "<td>".$row2['format']."</td>";
                    echo "<td>";
                    $imageQRY = $conexion->query("SELECT * FROM `imagenes` WHERE `idprod` = ".$row1['idprod']);
                    if($imageQRY){
                        $img = $imageQRY->fetch_array(MYSQLI_ASSOC);
                        echo "<img src='mostrarImagen.php?id=".$img["id"]."' width='150' height='150'><br>";
                    }
                    echo "</td>";
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
            echo "<td>Total: \$$precioFinal</td>";
            echo "</tr>";
            echo "<tr>";
            echo "</table>";
        }
        else{
            echo "<h3>Su carrito está vacio</h3>";
        }
    }

    ?>

    <form method="post" action="registrarDireccion.php?ubi=envioDir" onsubmit="return validaFRM_d()">
        Ingresa la linea 1 de la dirección: <input type="text" id="dir" name = "dir" placeholder="Calle #, Colonia"><br>
        Escribe tu ciudad: <input type="text" id="ciudad" name = "ciudad"><br>
        Escribe tu país: <input type="text" id="pais" name = "pais"><br>
        Escribe tu código postal: <input type="text" id="codP" name = "codP"><br>
        <input type="submit" value="Registrar">
        <input type="reset" value="Cancelar"> <br>
    </form>


    
    <?php
    echo "<form method=\"post\" action=\"selPago.php\" onsubmit=\"return validaFRM_p()\">";
    ?>
    <h4>Seleccionar direccion de envio</h4>
    Direcciones registradas:<select name="direccion" id="direccion">
    <?php
    $rsDireccion = $conexion->query("SELECT * FROM `direccion_usuario` WHERE `iduser`=".$_SESSION['idusuario']);
    echo "<option value=\"\">Seleccionar</option>";
    if(mysqli_num_rows($rsDireccion)>0){
        
        while($row = $rsDireccion->fetch_array(MYSQLI_ASSOC)){
            echo "<option value=\"".$row['id']."\">".$row['address_line1'].", ".$row['city'].", ".$row['country'].", ".$row['postal_code']."</option>";
        }
        echo "</select>";
    }
    else{
        ?>
        </select>
        <h4>No hay direcciones registradas, por favor registre una</h4>
        <?php
    }
    ?>
    <input type="submit" value="Confirmar Dirección">
    </form>
</body>
</html>