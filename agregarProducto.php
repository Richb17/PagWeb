<?php
include("include/funciones.php");
include("include/partesPag.php");
$msg = "";
autenticado();
if (isset($_GET['err']) && $_GET['err'] != "") {
    if ($_GET['err'] == "0") $msg = "Se subio correctamente el articulo";
    if ($_GET['err'] == "1") $msg = "Se debe utilizar el formulario de registro";
    if ($_GET['err'] == "2") $msg = "Se deben llenar todos los campos";
}
?>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto | SoundStream</title>

    <script type="text/javascript">
        function validaFRM() {
            if (document.getElementById("album").value == "" ||
                document.getElementById("artista").value == "" ||
                document.getElementById("precio").value == "" ||
                document.getElementById("formato").value == "" ||
                document.getElementById("stock").value == "" ||
                document.getElementById("titulo").value == "") {
                document.getElementById("msgAlerta").innerHTML = "Por favor llene todos los campos.";
                return false;
            } else {
                document.getElementById("nombreStock").value = document.getElementById("album").value + "-" + document.getElementById("artista").value + "-" + document.getElementById("formato").value;
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
    <div class="container-fluid" style="padding-top:100px; max-width: 1468px;">
        <?php
        echo "<h3>Productos</h3></div>";
        echo "<div class='container-fluid' style='max-width: 1468px;'>";
        if ($msg != "" && isset($_GET['err'])) {
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

        $conexion = conectarBD();
        $res = $conexion->query("SELECT p.idprod,p.albumname,p.artistname,p.prices,p.format,p.genre,s.quantity,p.iddiscount,p.modified_at FROM `productos` as p INNER JOIN `stock` as s ON s.id = p.idstock ORDER BY p.idprod;");
        if ($res) {
            echo "<table class=\"table table-hover\">";
            echo "<tr class=\"table-primary\">";
            echo "<th>ID</th>";
            echo "<th>Album</th>";
            echo "<th>Artista</th>";
            echo "<th>Precio</th>";
            echo "<th>Formato</th>";
            echo "<th>Género</th>";
            echo "<th>En Stock</th>";
            echo "<th>Descuento</th>";
            echo "<th>Ultima Modificación</th>";
            echo "<th>Editar</th>";
            echo "</tr>";
            while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
                extract($row);
                echo "<tr class=\"table-dark\">";
                echo "<td>$idprod</td>";
                echo "<td>$albumname</td>";
                echo "<td>$artistname</td>";
                echo "<td>$prices</td>";
                echo "<td>$format</td>";
                echo "<td>$genre</td>";
                echo "<td>$quantity</td>";
                echo "<td>";
                if ($iddiscount) {
                    echo "En Oferta";
                }
                echo "</td>";
                echo "<td>$modified_at</td>";
                echo "<td><a class=\"btn btn-primary\" href=\"verProducto.php?id=$idprod\">Editar</a></td>";
                echo "</tr>";
            }
            echo "<tr class=\"table-info\">";
            echo "<td></td>";
            echo "<td></td>";
            echo "<td></td>";
            echo "<td></td>";
            echo "<td></td>";
            echo "<td></td>";
            echo "<td></td>";
            echo "<td></td>";
            echo "<td></td>";
            echo "<td><button type=\"button\" class=\"btn btn-primary\" data-bs-toggle=\"modal\" data-bs-target=\"#registrarModal\">Agregar</button></td>";
            echo "</tr>";
            echo "</table>";
        }
        echo "</div>";
        mysqli_close($conexion);
        ?>
    </div>
    <div class="modal fade" id="registrarModal" tabindex="-1" aria-labelledby="regLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" enctype="multipart/form-data" action="registroProd.php" onsubmit="return validaFRM()">
                    <div class="modal-header">
                        <h5 class="modal-title" id="regLabel">Agregar nuevo producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="album" placeholder="album" name="album">
                                    <label for="album">Album</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="artista" placeholder="artista" name="artista">
                                    <label for="">Artista</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="precio" required name="precio" min="0" placeholder="0.00" step="0.01">
                                    <label for="precio">Precio</label>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-floating">
                                    <select class="form-select" name="genero" id="genero" aria-label="Floating label select example">
                                        <?php
                                        $conexion = conectarBD();
                                        $res = $conexion->query("SELECT * FROM `generoscat`");
                                        while ($gen = $res->fetch_array(MYSQLI_ASSOC)) {
                                            echo "<option value=\"" . $gen['name'] . "\">" . $gen['name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                    <label for="genero">Género</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="texy" class="form-control" id="descripcion" placeholder="descripcion" name="descripcion" style="height:150px;">
                                    <label for="">Descripción</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" name="formato" id="formato" aria-label="Floating label select example">
                                        <option value="CD">CD</option>
                                        <option value="Vinilo">Vinilo</option>
                                        <option value="Cassete">Cassete</option>
                                    </select>
                                    <label for="formato">Formato</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="stock" placeholder="stock" name="stock">
                                    <label for="stock">Stock</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div>
                                    <input type="hidden" id="titulo" name="titulo" value="Imagen Portada">
                                    <label for="imagen" class="form-label">Portada</label>
                                    <input class="form-control" type="file" id="imagen" name="imagen" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <input type="submit" class="btn btn-primary" value="Registrar producto">
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Ingrese el nombre del álbum: <input type="text" id="album" name="album"><br>
    Ingrese el nombre del artista: <input type="text" id="artista" name="artista"><br>
    Ingrese el precio del árticulo: <input type="number" id="precio" required name="precio" min="0" placeholder="0.00" step="0.01"><br>

    Descripción del árticulo: <input type="text" id="descripcion" name="descripcion" style="height:150px;"><br>
    Ingrese la cantidad de productos en stock: <input type="number" id="stock" name="stock"><br>
    
    Seleccione la imagen de portada del articulo: <input type="file" id="imagen" name="imagen" accept="image/*"><br>
    <input type="submit" value="Subir Producto">
    <input type="reset" value="Cancelar"> <br> -->

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>