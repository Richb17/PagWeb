<?php
include("include/funciones.php");
include("include/partesPag.php");
$msg = "";
autenticado();
if (isset($_GET['err']) && $_GET['err'] != "") {
    if ($_GET['err'] == "0") $msg = "Se registro correctamente";
    if ($_GET['err'] == "1") $msg = "Se debe utilizar el formulario de registro";
    if ($_GET['err'] == "2") $msg = "Se deben llenar todos los campos";
}
if ($_SESSION['role'] == 1) header($ruta . "Portada.php");

?>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descuentos | SoundStream</title>

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
        echo "<h3>Seleccion de descuentos</h3></div>";
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
        echo "<div class='container-fluid' style='max-width: 1468px;'>";
        if ($msg != "") {
            echo "<div id=\"msgAlerta\"> $msg </div>";
        } else {
            echo "<div id=\"msgAlerta\"></div>";
        }

        $conexion = conectarBD();
        $res = $conexion->query("SELECT * FROM `descuentos`");
        if ($res) {
            echo "<table class=\"table table-hover\">";
            echo "<tr class=\"table-primary\">";
            echo "<th>ID</th>";
            echo "<th>Codigo descuento</th>";
            echo "<th>Descripción</th>";
            echo "<th>% Descuento</th>";
            echo "<th>Selección</th>";
            echo "</tr>";
            while ($val = $res->fetch_array(MYSQLI_ASSOC)) {
                echo "<tr class=\"table-dark\">";
                echo "<td>" . $val['id'] . "</td>";
                echo "<td>" . $val['code'] . "</td>";
                echo "<td>" . $val['description'] . "</td>";
                $descuento = $val['discount'] * 100;
                echo "<td>$descuento%</td>";
                if (isset($_GET['id'])) {
                    echo "<td><a class='btn btn-primary' href=\"aplicarDescuento.php?idprod=" . $_GET['id'] . "&iddesc=" . $val['id'] . "&ubi=" . $_GET['ubi'] . "\">Seleccionar</a></td>";
                } else {
                    echo "<td>No hay articulo seleccionado<td>";
                }
                echo "</tr>";
            }
            echo "<tr class=\"table-success\">";
            echo "<td></td>";
            echo "<td></td>";
            echo "<td></td>";
            echo "<td>Registrar Nuevo Descuento</td>";
            echo "<td> <button type=\"button\" class=\"btn btn-primary\" data-bs-toggle=\"modal\" data-bs-target=\"#registrarModal\">Agregar</button> </td>";
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
                <form method="get" action="agregarDescuento.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="regLabel">Agregar nuevo descuento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Ingresa código para el descuento: <input class="form-control" type="text" id="code" name="code"><br>
                        Escriba una descripción del descuento: <input class="form-control" type="text" id="descripcion" name="descripcion"><br>
                        Ingrese valor del descuento: <input class="form-control" type="number" id="descuento" required name="descuento" min="0" max="100" placeholder="50%"><br>
                        <?php
                        if(isset($_get['id'])&&isset($_get['ubi'])){
                            echo "
                            <input type='hidden' name='idprod' value=\"" . $_GET['id'] . "\">
                            <input type='hidden' name='ubi' value=\"" . $_GET['ubi'] . "\">
                            ";
                        }
                        ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <input type="submit" class="btn btn-primary" value="Registrar descuento">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>