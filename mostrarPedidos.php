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
    <title>Pedidos</title>

    <link href="styles/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">
    <link href="styles/main.css" rel="stylesheet">
</head>

<body>
    <?php
    navbar();
    ?>

    <div class="container-fluid" style="padding-top:100px; max-width: 1468px;">
        <h2>Pedidos</h2>
        <?php
        if ($_SESSION['role'] > 1) {
            $conexion = conectarBD();
            $res = $conexion->query("SELECT * FROM `detalles_pedido`");
            if ($res) {
                echo "<table class=\"table table-hover\">";
                echo "<thead>";
                echo "<tr class=\"table-primary\">";
                echo "<th scope=\"col\">ID pedido</td>";
                echo "<th scope=\"col\">ID Usuario</td>";
                echo "<th scope=\"col\">Total Pagado</td>";
                echo "<th scope=\"col\">Fecha de pedido</td>";
                echo "<th scope=\"col\">Dirección</td>";
                echo "<th scope=\"col\">Descripción</td>";
                echo "<th scope=\"col\">Status</td>";
                echo "</tr>";
                echo "</thead>";
                while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['id_user'] . "</td>";
                    echo "<td>" . $row['total'] . "</td>";
                    echo "<td>" . $row['created_at'] . "</td>";
                    $dir = $conexion->query("SELECT `address_line1` FROM `direccion_usuario` WHERE `id`=" . $row['iddireccion']);
                    $rs = $dir->fetch_array(MYSQLI_ASSOC);
                    echo "<td>" . $rs['address_line1'] . "</td>";
                    echo "<td>" . $row['descripcion'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<h2>No hay pedidos para mostrar</h2>";
            }
        } else {
            $conexion = conectarBD();
            $res = $conexion->query("SELECT * FROM `detalles_pedido` WHERE `id_user`=" . $_SESSION['idusuario']);
            if ($res) {
                echo "<table class=\"table table-hover\">";
                echo "<thead>";
                echo "<tr class=\"table-primary\">";
                echo "<th scope=\"col\">ID pedido</td>";
                echo "<th scope=\"col\">Total Pagado</td>";
                echo "<th scope=\"col\">Fecha de pedido</td>";
                echo "<th scope=\"col\">Dirección</td>";
                echo "<th scope=\"col\">Descripción</td>";
                echo "<th scope=\"col\">Status</td>";
                echo "</tr>";
                echo "</thead>";
                while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['total'] . "</td>";
                    echo "<td>" . $row['created_at'] . "</td>";
                    $dir = $conexion->query("SELECT `address_line1` FROM `direccion_usuario` WHERE `id`=" . $row['iddireccion']);
                    $rs = $dir->fetch_array(MYSQLI_ASSOC);
                    echo "<td>" . $rs['address_line1'] . "</td>";
                    echo "<td>" . $row['descripcion'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<h2>No hay pedidos para mostrar</h2>";
            }
        }
        ?>
    </div>
    <div style="height: 500px;"></div>
    <?php
    footer();
    ?>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>