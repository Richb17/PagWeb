<?php
include("include/funciones.php");
include("include/partesPag.php");

$conexion = conectarBD();
$res = $conexion->query("SELECT * FROM `productos` WHERE `idprod`=" . $_GET['id']);
$rs = $res->fetch_array(MYSQLI_ASSOC);
extract($rs);

$msg = "";
if (isset($_GET['err']) && $_GET['err'] != "") {
    if ($_GET['err'] == "0") $msg = "Se actualizo correctamente el producto";
    if ($_GET['err'] == "1") $msg = "Se debe utilizar el formulario de registro";
    if ($_GET['err'] == "2") $msg = "Se deben llenar todos los campos";
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    echo "<title>$albumname | SoundStream</title>";
    ?>

    <link href="styles/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">
    <link href="styles/main.css" rel="stylesheet">
</head>

<body>
    <?php
    navbar();
    ?>

    <div class="container-fluid" style="padding:100px 0px; max-width: 1468px;">
        <div class="card mb-3" style="max-width: 1400px;">
            <div class="row  justify-content-start">
                <?php
                $imageQRY = $conexion->query("SELECT * FROM `imagenes` WHERE `idprod` = $idprod");
                if ($imageQRY) {
                    $img = $imageQRY->fetch_array(MYSQLI_ASSOC);
                }
                echo "
                <div class='col-md-6'>
                    <img src='mostrarImagen.php?id=" . $img["id"] . "' class=\"img-fluid rounded-start img_prod_max\">
                </div>";
                if(isset($_SESSION['role'])){
                    if ($_SESSION['role'] > 1) {
                        echo "<div class='col-md-4 align-self-center'>";
                        echo "<div class='container' style='padding:10px 15px 10px;'>";
                        echo "<form method=\"get\" action=\"actualizaProd.php\">";
                        if ($msg != "") {
                            if ($_GET['err'] != "0") {
                                echo "
                            <div class=\"alert alert-dismissible alert-danger\" id=\"alertaPwd\">
                                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                                <strong>Oh no!</strong> $msg
                            </div>
                            ";
                            } else {
                                echo "
                            <div class=\"alert alert-dismissible alert-success\" id=\"alertaPwd\">
                                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                                <strong>Muy bien!</strong> $msg
                            </div>
                            ";
                            }
                        }
                        echo "<input  type='hidden' id='idP' name='idprod' value='$idprod'>";
                        echo "<input  type='hidden' id='idU' name='ubi' value='verProducto.php?id=$idprod'>";
                        echo "Ingrese el nombre del álbum: <input class='form-control' type=\"text\" id=\"album\" name = \"album\" value=\"$albumname\"><br>";
                        echo "Ingrese el nombre del artista: <input class='form-control' type=\"text\" id=\"artista\" name = \"artista\" value=\"$artistname\"><br>";
                    ?>
                        Formato: <select class="form-select" name="formato" id="formato" aria-label="Floating label select example">
                            <option value="CD">CD</option>
                            <option value="Vinilo">Vinilo</option>
                            <option value="Cassete">Cassete</option>
                        </select><br>
                        Género: <select class="form-select" name="genero" id="genero" aria-label="Floating label select example">
                            <?php
                            $conexion = conectarBD();
                            $res = $conexion->query("SELECT * FROM `generoscat`");
                            while ($gen = $res->fetch_array(MYSQLI_ASSOC)) {
                                echo "<option value=\"" . $gen['name'] . "\">" . $gen['name'] . "</option>";
                            }
                            ?>
                        </select>
                        <br>
                    <?php
                        $precioDesc = precioDescuentoItem($idprod);
                        echo "Ingrese el precio del árticulo (Precio a mostrar \$$precioDesc): <input class='form-control' type=\"number\" id=\"precio\" required name=\"precio\" min=\"0\" value=\"$prices\" step=\"0.01\"><br>";
                        echo "Descripción del árticulo: <input class='form-control' type=\"text\" id=\"descripcion\" name = \"descripcion\" value=\"$description\"><br>";
                        $value = conseguirStock($idprod);
                        echo "Ingrese la cantidad de productos en stock: <input class='form-control' type=\"number\" id=\"stock\" name = \"stock\" value=\"$value\"><br>";
                        echo "  <input type=\"submit\" class=\"btn btn-primary\" value=\"Actualizar\">
                                <input type=\"reset\" class=\"btn btn-secondary\" value=\"Cancelar\"> <br>
                                </form> </div> </div>";
                        echo "<div class='col-md-2 align-self-center'>
                                <a href=\"seleccionarDescuento.php?id=$idprod&ubi=verProducto.php?id=$idprod\" class=\"btn btn-primary\">Aplicar descuento</a>
                                <br><br>
                                <a href=\"retirarDescuento.php?id=$idprod&ubi=verProducto.php?id=$idprod\" class=\"btn btn-danger\">Retirar descuento</a>
                            </div>";
                    } else {
                        $stock = conseguirStock($idprod);
                        if ($stock == 0) {
                            $stock = "AGOTADO";
                        }
                        $precioF = precioDescuentoItem($idprod);
                        echo "
                        <div class='col-md-6 align-self-center'>
                            <div class='card-body'>
                                <h4 class='card-title'>$albumname</h4>
                                <h5 class='card-subtitle'>$artistname - $format - $genre<h5>
                                <h6>\$$precioF</h6>
                                <p>Disponibles: $stock</p>
                                <br>
                                <a href=\"agregarCarrito.php?id=$idprod&ubi=verProducto.php?id=$idprod\" class=\"btn btn-primary\">Añadir al carrito</a>
                                <a href=\"comprarAhora.php?id=$idprod&ubi=verProducto.php?id=$idprod\" class=\"btn btn-secondary\">Comprar ahora</a>
                            </div>";
                        echo "</div>";
                    }
                } else{
                    $stock = conseguirStock($idprod);
                        if ($stock == 0) {
                            $stock = "AGOTADO";
                        }
                    $precioF = precioDescuentoItem($idprod);
                    echo "
                        <div class='col-md-6 align-self-center'>
                            <div class='card-body'>
                                <h4 class='card-title'>$albumname</h4>
                                <h5 class='card-subtitle'>$artistname - $format - $genre<h5>
                                <h6>\$$precioF</h6>
                                <p>Disponibles: $stock</p>
                                <br>
                                <a href=\"iniciarSesion.php\" class=\"btn btn-primary\">Inicia Sesión para comprar</a>
                            </div>";
                        echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>

    <div class="container-fluid" style="padding-bottom:70px; max-width: 1468px;">
        <h2>Reseñas</h2>
        <?php
        if(isset($_SESSION['username'])){
            $qry = $conexion->query("SELECT * FROM `reseña` WHERE `idprod` =$idprod AND `username`= '" . $_SESSION['username'] . "'");
            if (mysqli_num_rows($qry) == 0) {
            ?>
                <div style="padding: 20px 0px 20px">
                    <div class="card" style="width: 768">
                        <div class="card-body">
                            <h3 class="card-title">Deja un comentario</h3>
                            <form method="get" action="subirComentario.php">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="rec" name="rec">
                                    <label class="form-check-label" for="rec">
                                        Recomendado
                                    </label>
                                </div>
                                <div class="form-floating">
                                    <textarea class="form-control" name="comentario" id="floatingTextarea2" style="height: 150px"></textarea>
                                    <label for="floatingTextarea2">Comentar</label>
                                </div>
                                <br>
                                <input type="submit" class="btn btn-primary" value="Comentar">
                                <input type="reset" class="btn btn-secondary" value="Cancelar">
                                <?php
                                echo "<input type='hidden' name='id' value='$idprod'>";
                                echo "<input type='hidden' name='ubi' value='verProducto.php?id=$idprod'>";
                                ?>
                            </form>
                        </div>
                    </div>
                </div>

            <?php
            }
        }
        mostrarComentariosProducto($idprod, $conexion);
        ?>
    </div>
    </div>
    </div>
    <?php
    footer();
    ?>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>