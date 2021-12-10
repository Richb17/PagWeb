<?php
include("include/funciones.php");
include("include/partesPag.php");
autenticado();
$msg = "";
if (isset($_GET['err']) && $_GET['err'] != "") {
    if ($_GET['err'] == "0") $msg = "Se registro correctamente";
    if ($_GET['err'] == "1") $msg = "Se debe utilizar el formulario de registro";
    if ($_GET['err'] == "2") $msg = "Se deben llenar todos los campos";
    if ($_GET['err'] == "3") $msg = "Ya existia el género que introdujo";
    if ($_GET['err'] == "4") $msg = "Se elimino con éxito";
}
?>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Género</title>

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
        echo "<h3>Géneros</h3></div>";
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
        $res = $conexion->query("SELECT * FROM `generoscat`");
        if ($res) {
            echo "<table class=\"table table-hover\">";
            echo "<tr class=\"table-primary\">";
            echo "<th>Nombre del género</th>";
            echo "<th>Creado</th>";
            echo "<th>Eliminar</th>";
            echo "</tr>";
            while ($val = $res->fetch_array(MYSQLI_ASSOC)) {
                echo "<tr class=\"table-dark\">";
                echo "<td>" . $val['name'] . "</td>";
                echo "<td>" . $val['created_at'] . "</td>";
                echo "<td><a class=\"btn btn-danger\" href=\"eliminarGenero.php?name=". $val['name'] ."\">Eliminar</a></td>";
                echo "</tr>";
            }
            echo "<tr class=\"table-info\">";
            echo "<td></td>";
            echo "<td></td>";
            echo "<td><button type=\"button\" class=\"btn btn-primary\" data-bs-toggle=\"modal\" data-bs-target=\"#registrarModal\">Agregar</button></td>";
            echo "</table>";
        }
        echo "</div>";
        mysqli_close($conexion);
        ?>
    </div>
    <div class="modal fade" id="registrarModal" tabindex="-1" aria-labelledby="regLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="get" action="registraGenero.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="regLabel">Agregar nuevo género</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating">
                            <input class="form-control" type="text" id="genero" name="genero" placeholder="Género">
                            <label for="genero">Género Ej. Pop-Rock</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <input type="submit" class="btn btn-primary" value="Registrar género">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>