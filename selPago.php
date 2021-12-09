<?php
include("include/funciones.php");
autenticado();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprar</title>

    <script type="text/javascript">
        function validaFRM_registrar(){
            if(document.getElementById("tipoP").value=="" || document.getElementById("prov").value=="" ||
               document.getElementById("cuenta").value=="" || document.getElementById("vencimiento").value==""){
                alert("Por favor llene todos los campos.");
                return false;
            }
            else{
                return true;
            }
        }

        function validaFRM_pagar(){
            if(document.getElementById("metodo").value==""){
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
    <h2>Registrar nuevo método de pago</h2>
    <form method="post" action="registrarMetodoPago.php?ubi=selPago.php" onsubmit="return validaFRM_registrar()">
        Tipo de tarjeta: <select name="tipoP" id="tipoP">
            <option value="">Seleccionar</option>
            <option value="debito">Tarjeta de debito</option>
            <option value="credito">Tarjeta de credito</option>
        </select>
        Proveedor de tarjeta: <input type="text" id="prov" name = "prov" placeholder="Ej. Santander, Bancomer, etc."><br>
        Número de tarjeta: <input type="text" id="cuenta" name = "cuenta" placeholder="xxxx-xxxx-xxxx-xxxx"><br>
        Fecha de vencimiento: <input type="month" id="vencimiento" name = "vencimiento"><br>
        <input type="submit" value="Registrar">
        <input type="reset" value="Cancelar"> <br>
    </form>


    
    <?php
    echo "<form method=\"post\" action=\"registrarPedido.php\" onsubmit=\"return validaFRM_pago()\">";
    ?>
    <h4>Seleccionar método de pago</h4>
    Métodos registrados:<select name="metodo" id="metodo">
    <?php
    $rs = $conexion->query("SELECT * FROM `pago_usuario` WHERE `iduser`=".$_SESSION['idusuario']);
    echo "<option value=\"\">Seleccionar</option>";
    if(mysqli_num_rows($rs)>0){
        
        while($row = $rs->fetch_array(MYSQLI_ASSOC)){
            echo "<option value=\"".$row['id']."\">".$row['account_no']."</option>";
        }
        echo "</select>";
    }
    else{
        ?>
        </select>
        <h4>No hay métodos registrados, por favor registre uno</h4>
        <?php
    }
    echo "<input type='hidden' name='idDireccion' value='".$_POST['direccion']."'>";
    echo "<input type='hidden' name='idCart' value='$id'>";
    echo "<input type='hidden' name='total' value='$precioFinal'>";
    ?>
    <input type="submit" value="Confirmar Dirección">
    </form>
</body>
</html>