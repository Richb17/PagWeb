<?php
include("include/funciones.php");
include("include/partesPag.php");
autenticado();
$conexion = conectarBD();
$msg = "";
if (isset($_GET['err']) && $_GET['err'] != "") {
    if ($_GET['err'] == "0") $msg = "Se aplicó el descuento";
    if ($_GET['err'] == "1") $msg = "Se debe utilizar el formulario de registro";
    if ($_GET['err'] == "2") $msg = "Ya había un descuento aplicado";
    if ($_GET['err'] == "3") $msg = "El código no era válido";
    if ($_GET['err'] == "4") $msg = "Descuento desactivado";
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de compras</title>

    <script type="text/javascript">
        function validaFRM() {
            if (document.getElementById("code").value == "") {
                document.getElementById("msgAlerta").innerHTML = "Por favor introduza un código válido.";
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
    <div class="container-fluid" style="padding-top: 120px; max-width: 1468px;">
        <h3>Carrito de compras</h3>

        <br>

        <h3>Articulos en el carrito</h3>
        <?php
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
                echo "<th scope=\"col\">Eliminar</td>";
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
                        echo "<td>" . $row1['quantity'] . " <a href=\"sumaRestaCarrito.php?idCart=$id&idProd=" . $row1['idprod'] . "&band=1\"> <i class=\"fas fa-plus-circle\"></i> </a>  <a href=\"sumaRestaCarrito.php?idCart=$id&idProd=" . $row1['idprod'] . "&band=0\"> <i class=\"fas fa-minus-circle\"></i> </a></td>";
                        echo "<td>" . $row2['format'] . "</td>";
                        echo "<td>";
                        $imageQRY = $conexion->query("SELECT * FROM `imagenes` WHERE `idprod` = " . $row1['idprod']);
                        if ($imageQRY) {
                            while ($img = $imageQRY->fetch_array(MYSQLI_ASSOC)) {
                                echo "<img src='mostrarImagen.php?id=" . $img["id"] . "' width='200' height='200'><br>";
                            }
                        }
                        echo "</td>";
                        echo "<td><a href=\"borrarProdCar.php?idProd=" . $row1['idprod'] . "&idCart=$id\"><i class=\"fas fa-trash-alt\"></i></a></td>";
                        echo "<td>" . $precio * $row1['quantity'] . "</td>";
                        echo "</tr>";
                    }
                }
                $precioFinal = $total * (1 - $descuentoaplicado);
                $rs = $conexion->query("SELECT * FROM `descuentos`");
                echo "<tr class=\"table-secondary\">";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td><a href=\"vaciarCarrito.php?id=$id\">Vaciar carrito</td>";
                echo "<td></td>";
                echo "</tr>";
                echo "<tr class=\"table-success\">";
                echo "<td></td>";
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
                echo "</td>";
                echo "<td>";
                if ($discountactive) {
                    echo "<a href=\"desactivarDescuento.php\" class=\"btn btn-outline-secondary\">Desactivar descuento</a>";
                } else {
                    echo "<form method=\"get\" action = \"comprobarDescuento.php\">
                <div class=\"form-floating\">
                    <select class=\"form-select\" id=\"floatingSelect\" name=\"code\" aria-label=\"Floating label select example\">";
                    while ($row = $rs->fetch_array(MYSQLI_ASSOC)) {
                        echo "<option value='" . $row['id'] . "'>" . $row['code'] . "</option>";
                    }
                    echo    "</select>
                        <label for=\"floatingSelect\" class=\"form-label\">Seleccione un descuento</label>
                    </div> <br>
                    <input type=\"submit\" value=\"Canjear\" class=\"btn btn-outline-primary\">
                    
                </form>";
                }
                echo "</td>";
                echo "</tr>";
                echo "<tr class=\"table-secondary\">";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td><a href=\"envioDir.php\" class=\"btn btn-primary\">Proceder al pago</a></td>";
                echo "</tr>";
                echo "</table>";
            } else {
                echo "<h3>Su carrito está vacio</h3>";
            }
            mysqli_close($conexion);
        } else {
            echo "<h3>No hay un carrito para mostrar</h3>";
        }
        ?>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>