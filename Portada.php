<?php
include("include/funciones.php");
include("include/partesPag.php");
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | SoundStream</title>

    <link href="styles/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">
    <link href="styles/main.css" rel="stylesheet">
</head>
<body>
    <?php 
    navbar();
    //Autenticación
    echo "<div class=\"container\">";
    echo "<h2 style=\"padding-top:100px;\">Inicio</h2>"; 
    $conexion = conectarBD();
    ?>
    </div>
    <div class="container-fluid" style="background-color: #2b2b2b;">
        <div class="container-sm" style="max-width: 768px;">
            <div id="carouselExampleCaptions" class="carousel carousel-dark slide " data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                <?php
                    $carrusel = $conexion->query("SELECT `idprod`, `albumname`, `artistname` FROM `productos` ORDER BY `created_at` DESC LIMIT 3");
                    $n = 0;
                    while($row = $carrusel->fetch_array(MYSQLI_ASSOC)){
                        itemCarrusel($row, $conexion,$n);
                        $n+=1;
                    }
                ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
    <div class="container text-center" style="padding-top:40px; "><h3>Destacados</h3></div>
    <div class="container-fluid" style="padding:40px 100px 70px;">
        <div class="row justify-content-start">
            <div class="col-3">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Ordenar Por:
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="Portada.php?ord=0">Arista (A-Z)</a></li>
                        <li><a class="dropdown-item" href="Portada.php?ord=1">Arista (Z-A)</a></li>
                        <li><a class="dropdown-item" href="Portada.php?ord=2">Album (A-Z)</a></li>
                        <li><a class="dropdown-item" href="Portada.php?ord=3">Album (Z-A)</a></li>
                        <li><a class="dropdown-item" href="Portada.php?ord=4">Precio desc.</a></li>
                        <li><a class="dropdown-item" href="Portada.php">Precio asc.</a></li>
                        <li><a class="dropdown-item" href="Portada.php?ord=5">Solo CD's</a></li>
                        <li><a class="dropdown-item" href="Portada.php?ord=6">Solo Vinilos</a></li>
                        <li><a class="dropdown-item" href="Portada.php?ord=7">Solo Cassetes</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-9">
                <div class="row row-cols-1 row-cols-md-3 g-4">
    <?php
    
    if(isset($_GET['ord'])){
        $res = ordenarArticulos($_GET['ord'],$conexion,6);
    }
    else{
        $res = $conexion->query("SELECT `idprod` FROM `productos` ORDER BY `prices` LIMIT 6");
    }
    if($res){
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            prodCard($row['idprod'],"Portada.php");
        }
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