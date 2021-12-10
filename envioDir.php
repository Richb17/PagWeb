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
        function validaFRM_d() {
            if (document.getElementById("dir").value == "" || document.getElementById("ciudad").value == "" ||
                document.getElementById("pais").value == "" || document.getElementById("codP").value == "") {
                alert("Por favor llene todos los campos.");
                return false;
            } else {
                return true;
            }
        }

        function validaFRM_p() {
            if (document.getElementById("direccion").value == "") {
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
        <h3>Pedido - Seleccione dirección de envio</h3>
        <a href="verCarrito.php" class="btn btn-outline-primary">Regresar a ver carrito</a><br><br>
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
                echo "<tr class=\"table-success\">";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td>";
                if ($discountactive) {
                    echo "<a href=\"desactivarDescuento.php\" class=\"btn btn-outline-secondary\">Desactivar descuento</a>";
                }
                echo "</td>";
                echo "</table>";
            } else {
                echo "<h3>Su carrito está vacio</h3>";
            }
        }

        ?>
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="registrarDireccion.php?ubi=envioDir.php" onsubmit="return validaFRM_d()">
                            <h3 class="card-title">Ingrese nueva dirección</h3>
                            <div class="form-floating">
                                <input class='form-control' type="text" id="dir" name="dir" placeholder="Calle #, Colonia">
                                <label for="dir">Ingrese su dirección</label>
                            </div>
                            <div class="form-floating">
                                <input class='form-control' type="text" id="ciudad" name="ciudad" placeholder="Ciudad">
                                <label for="ciudad">Ingrese su ciudad</label>
                            </div>
                            <div class="form-floating">
                                <input class='form-control' type="text" id="pais" name="pais" placeholder="País">
                                <label for="pais">Ingrese su país</label>
                            </div>
                            <div class="form-floating">
                                <input class='form-control' type="text" id="codP" name="codP" placeholder="Cod. Postal">
                                <label for="codP">Ingrese su código postal</label>
                            </div>
                            <br>
                            <input type="submit" class="btn btn-primary" value="Registrar">
                            <input type="reset" class="btn btn-secondary" value="Cancelar"> <br>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Seleccione una dirección de envio.</h3>
                        <?php
                        echo "<form method=\"get\" action=\"selPago.php\" onsubmit=\"return validaFRM_p()\">";
                        ?>
                        <div class="form-floating">
                            <select class="form-select" name="direccion" id="direccion" aria-label="Floating label select example">
                                <?php
                                $rsDireccion = $conexion->query("SELECT * FROM `direccion_usuario` WHERE `iduser`=" . $_SESSION['idusuario']);
                                echo "<option value=\"\">Seleccionar</option>";
                                if (mysqli_num_rows($rsDireccion) > 0) {
                                    while ($row = $rsDireccion->fetch_array(MYSQLI_ASSOC)) {
                                        echo "<option value=\"" . $row['id'] . "\">" . $row['address_line1'] . ", " . $row['city'] . ", " . $row['country'] . ", " . $row['postal_code'] . "</option>";
                                    }
                                ?>
                            </select>
                            <label for="direccion">Direcciones registradas:</label><br>
                            <input class="btn btn-primary" type="submit" value="Confirmar Dirección">
                            </form>
                        </div>
                    <?php
                                } else {
                    ?>
                        <h4>No hay direcciones registradas, por favor registre una</h4>
                    </div>
                </div>
            </div>
        </div>
    <?php
                                }
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