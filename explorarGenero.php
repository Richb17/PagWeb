<?php
include("include/funciones.php");
include("include/partesPag.php");
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos | SoundStream</title>
    <link href="styles/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">
    <link href="styles/main.css" rel="stylesheet">
</head>
<body>
    <?php
    navbar();
    echo "<div class=\"container\"><h2 style=\"padding-top:100px;\">".$_GET['name']."</h2></div>"; 
    $conexion = conectarBD();
    ?>
    <div class="container-fluid" style="padding:40px 100px 70px;">
        <div class="row justify-content-start">
            <div class="col-3">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Ordenar Por:
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <?php
                        echo "<li><a class=\"dropdown-item\" href=\"explorarGenero.php?ord=0&name=".$_GET['name']."\">Arista (A-Z)</a></li>
                        <li><a class=\"dropdown-item\" href=\"explorarGenero.php?ord=1&name=".$_GET['name']."\">Arista (Z-A)</a></li>
                        <li><a class=\"dropdown-item\" href=\"explorarGenero.php?ord=2&name=".$_GET['name']."\">Album (A-Z)</a></li>
                        <li><a class=\"dropdown-item\" href=\"explorarGenero.php?ord=3&name=".$_GET['name']."\">Album (Z-A)</a></li>
                        <li><a class=\"dropdown-item\" href=\"explorarGenero.php?ord=4&name=".$_GET['name']."\">Precio desc.</a></li>
                        <li><a class=\"dropdown-item\" href=\"explorarGenero.php?name=".$_GET['name']."\">Precio asc.</a></li>
                        <li><a class=\"dropdown-item\" href=\"explorarGenero.php?ord=5&name=".$_GET['name']."\">Solo CD's</a></li>
                        <li><a class=\"dropdown-item\" href=\"explorarGenero.php?ord=6&name=".$_GET['name']."\">Solo Vinilos</a></li>
                        <li><a class=\"dropdown-item\" href=\"explorarGenero.php?ord=7&name=".$_GET['name']."\">Solo Cassetes</a></li>"
                        ?>
                    </ul>
                </div>
            </div>
            <div class="col-9">
                <div class="row row-cols-1 row-cols-md-3 g-4">
    <?php
    $tP = $conexion->query("SELECT COUNT(*) FROM `productos`");
    $rs = $tP->fetch_array();
    $total = $rs[0];
    if(isset($_GET['ord'])){
        $res = ordenarArticulosGenero($_GET['ord'],$conexion,$total, $_GET['name']);
    }
    else{
        $res = $conexion->query("SELECT `idprod` FROM `productos` WHERE `genre`='".$_GET['name']."' ORDER BY `prices` LIMIT $total");
    }
    if(mysqli_num_rows($res)>0){
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            prodCard($row['idprod'],"explorarGenero");
        }
    }
    else{
        echo "<h4>No hay productos que coincidan sus especificaciones</h4";
    }
    mysqli_close($conexion);
    echo "
                    </div>
                </div>
            </div>
        </div>
    </div>
    ";
    footer();
    ?>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>