<?php
include("include/funciones.php");
include("include/partesPag.php");
autenticado();
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprar</title>

    <script type="text/javascript">
        function validaFRM_registrar() {
            if (document.getElementById("tipoP").value == "" || document.getElementById("prov").value == "" ||
                document.getElementById("cuenta").value == "" || document.getElementById("vencimiento").value == "") {
                alert("Por favor llene todos los campos.");
                return false;
            } else {
                return true;
            }
        }

        function validaFRM_pagar() {
            if (document.getElementById("metodo").value == "") {
                alert("Por favor llene todos los campos.");
                return false;
            } else {
                return true;
            }
        }
    </script>

    <link href="styles/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">
    <link href="styles/main.css" rel="stylesheet">
</head>

<body>
    <?php
    navbar();
    ?>

    <div class="container-fluid" style="padding-top: 100px; max-width: 1468px;">
        <h3>Pedido - Seleccione método de pago</h3>
        <a href="envioDir.php" class="btn btn-outline-primary">Regresar a seleccionar dirección</a><br><br>
        <div class="row justify-content-center">
            <?php
            $conexion = conectarBD();
            $resCarrito =  $conexion->query("SELECT * FROM `carritos` WHERE `id_user` = " . $_SESSION['idusuario']);

            if (mysqli_num_rows($resCarrito) > 0) {
                $carrito = $resCarrito->fetch_array(MYSQLI_ASSOC);
                extract($carrito);
                $res1 = $conexion->query("SELECT `idprod`, `quantity` FROM `item_carrito` WHERE `idcart`=$id");
                if (mysqli_num_rows($res1) > 0) {
                    echo "<table class=\"table table-hover\">";
                    echo "<thead>";
                    echo "<tr class=\"table-primary\">";
                    echo "<th scope=\"col\">Album</td>";
                    echo "<th scope=\"col\">Artista</td>";
                    echo "<th scope=\"col\">Precio</td>";
                    echo "<th scope=\"col\">Cantidad</td>";
                    echo "<th scope=\"col\">Formato</td>";
                    echo "<th scope=\"col\">Portada</td>";
                    echo "<th scope=\"col\">Total</td>";
                    echo "</tr>";
                    echo "</thead>";
                    while ($row1 = $res1->fetch_array(MYSQLI_ASSOC)) {
                        $res2 = $conexion->query("SELECT `albumname`, `artistname`, `iddiscount`, `format`, `prices` FROM `productos` WHERE `idprod`=" . $row1['idprod']);
                        while ($row2 = $res2->fetch_array(MYSQLI_ASSOC)) {
                            echo "<tr class=\"table-secondary\">";
                            echo "<th scope=\"row\">" . $row2['albumname'] . "</td>";
                            echo "<td>" . $row2['artistname'] . "</td>";
                            $precio = precioDescuentoItem($row1['idprod']);
                            echo "<td>$precio</td>";
                            echo "<td>" . $row1['quantity'] . "</td>";
                            echo "<td>" . $row2['format'] . "</td>";
                            echo "<td>";
                            $imageQRY = $conexion->query("SELECT * FROM `imagenes` WHERE `idprod` = " . $row1['idprod']);
                            if ($imageQRY) {
                                $img = $imageQRY->fetch_array(MYSQLI_ASSOC);
                                echo "<img src='mostrarImagen.php?id=" . $img["id"] . "' width='150' height='150'><br>";
                            }
                            echo "</td>";
                            echo "<td>" . $precio * $row1['quantity'] . "</td>";
                            echo "</tr>";
                        }
                    }
                    $precioFinal = $total * (1 - $descuentoaplicado);
                    echo "<tr class=\"table-success\">";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td>Total: \$$precioFinal</td>";
                    echo "</tr>";
                    echo "</table>";
                } else {
                    echo "<h3>Su carrito está vacio</h3>";
                }
            }

            ?>
        </div>
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <?php
                        echo "<form method=\"post\" action=\"registrarMetodoPago.php?ubi=selPago.php?direccion=" . $_GET['direccion'] . "\" onsubmit=\"return validaFRM_registrar()\">";
                        ?>
                        <h3 class="card-title">Ingrese nuevo método de pago</h3>
                        <div class="form-floating">
                            <select class="form-select" name="tipoP" id="tipoP" aria-label="Floating label select example">
                                <option value="">Seleccionar</option>
                                <option value="debito">Tarjeta de debito</option>
                                <option value="credito">Tarjeta de credito</option>
                            </select>
                            <label for="tipoP">Seleccione el tipo de tarjeta:</label><br>
                        </div>

                        <div class="form-floating">
                            <input class="form-control" type="text" id="prov" name="prov" placeholder="Ej. Santander, Bancomer, etc.">
                            <label for="prov">Escriba el nombre de su proveedor, Ej. Santander, Bancomer, etc.</label><br>
                        </div>
                        <div class="form-floating">
                            <input class="form-control" type="text" id="cuenta" name="cuenta" placeholder="xxxx-xxxx-xxxx-xxxx">
                            <label for="cuenta">Escriba su número de tarjeta</label><br>
                        </div>

                        <div class="form-floating">
                            <input class="form-control" type="month" id="vencimiento" name="vencimiento"><br>
                            <label for="vencimiento">Fecha de vencimiento</label><br>
                        </div>
                        <input type="submit" value="Registrar" class="btn btn-primary">
                        <input type="reset" value="Cancelar" class="btn btn-secondary"> <br>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Seleccione un método de pago.</h3>
                        <?php
                        echo "<form method=\"post\" action=\"registrarPedido.php\" onsubmit=\"return validaFRM_pago()\">";
                            echo "<input type='hidden' name='total' value='$precioFinal'>";
                            echo "<input type='hidden' name='idCart' value='$id'>";
                            echo "<input type='hidden' name='idDireccion' value='".$_GET['direccion']."'>"
                        ?>
                        <div class="form-floating">
                            <select class="form-select" name="metodo" id="metodo" aria-label="Floating label select example">
                                <?php
                                $rs = $conexion->query("SELECT * FROM `pago_usuario` WHERE `iduser`=" . $_SESSION['idusuario']);
                                echo "<option value=\"\">Seleccionar</option>";
                                if (mysqli_num_rows($rs) > 0) {

                                    while ($row = $rs->fetch_array(MYSQLI_ASSOC)) {
                                        echo "<option value=\"" . $row['id'] . "\">" . $row['account_no'] . "</option>";
                                    }
                                    echo "</select><br><label for=\"metodo\">Seleccione un método de pago:</label><br";
                                } else {
                                ?>
                                    <h4>No hay métodos registrados, por favor registre uno</h4>
                            </select>
                        <?php
                                }
                                
                        ?>
                        <input class="btn btn-primary" type="submit" value="Confirmar Dirección">
                        <input class="btn btn-primary" type="submit" value="Confirmar Dirección">
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        ?>
    </div>
    </div>
    </div>
    </div>
    </div>
    <div style="height: 100px"></div>
    <?php
    footer();
    ?>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>