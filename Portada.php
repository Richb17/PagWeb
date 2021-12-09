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
    if(isset($_SESSION['username'])){
        /*echo "<h2 style=\"padding-top:40px;\">Bienvenido ". $_SESSION['username']."</h2>"; 
        echo "<div> <a href=\"cambiarPwd.php\"> Cambiar contraseña </a> || <a href=\"logout.php\">Cerrar sesión</a> || <a href=\"verCarrito.php\">Ver Carrito</a></div> || <a href=\"mostrarPedidos.php\">Ver Pedidos</a></div>";
        echo "<div> </div>";
        if($_SESSION['role'] == 2){
            echo "<a href=\"agregarProducto.php\"> Subir un nuevo articulo al sistema </a><br>";
            echo "<a href=\"subirImagen.php\"> Subir una nueva imagen al sistema </a><br>";
            echo "<a href=\"agregarGenero.php\"> Agregar un nuevo género al cátalogo </a><br>";
            echo "<a href=\"registroDescuento.php\"> Agregar nuevo descuento </a><br>";
            echo "<a href=\"registroAdmin.php\"> Registrar a un nuevo administrador </a><br>";  
        }
        else if($_SESSION['role'] == 3){
            echo "<a href=\"agregarProducto.php\"> Subir un nuevo articulo al sistema </a><br>";
            echo "<a href=\"subirImagen.php\"> Subir una nueva imagen al sistema </a><br>";
        } */
    }
    else{
    ?>
        <h2 style="padding-top:40px;">Inicia sesión:</h2>
        <form method="post" action = "login.php">
            <h3>Para usar el sistema necesitas autenticarte</h3>
            Usuario: <input type="text" id="txtUsuario" name="txtUsuario"><br>
            Contraseña: <input type="password" id="txtPwd" name="txtPwd"><br><br>
            <input type="submit" value="Autentícame">
            <input type="reset" value="Cancelar"> <br>
            Si no te has registrado, da clic aquí <a href="registro.php">Registrate</a>
        </form>
    <?php
    }
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
            prodCard($row['idprod'],"Portada");
        }
        /* echo "<table>";
        echo "<tr>";
        echo "<td>Id</td>";
        echo "<td>Nombre album</td>";
        echo "<td>Artista</td>";
        echo "<td>Precio</td>";
        echo "<td>Cantidad en stock</td>";
        echo "<td>Descripción</td>";
        echo "<td>Genero</td>";
        echo "<td>Formato</td>";
        echo "<td>Imagenes</td>";
        if(isset($_SESSION['role']) && $_SESSION['role'] > 1){
            echo "<td>Edición</td>";
        }
        else if (isset($_SESSION['role']) && $_SESSION['role'] == 1){
            echo "<td>Compra-Venta</td>";
        }
        echo "</tr>";
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            echo "<td>".$row['idprod']."</td>";
            echo "<td>".$row['albumname']."</td>";
            echo "<td>".$row['artistname']."</td>";
            $precio = precioDescuentoItem($row['idprod']);
            echo "<td>$precio</td>";
            $value = conseguirStock($row['idprod']);
            if($value == 0) echo "<td>AGOTADO</td>";
            else echo "<td>".$value."</td>";
            echo "<td>".$row['description']."</td>";
            echo "<td>".$row['genre']."</td>";
            echo "<td>".$row['format']."</td>";
            echo "<td>";
            $imageQRY = $conexion->query("SELECT * FROM `imagenes` WHERE `idprod` = ".$row['idprod']);
            if($imageQRY){
                while($img = $imageQRY->fetch_array(MYSQLI_ASSOC)){
                    //echo "<img src='mostrarImagen.php?id=".$img["id"]."' width='200' height='200'><br>";
                    echo "<img src='mostrarImagen.php?id=".$img["id"]."' class='rounded mx-auto d-block img_prod_min'><br>";
                }
            }
            echo "</td>";
            if(isset($_SESSION['role']) && $_SESSION['role'] > 1){
                echo "<td><a href=\"editarArticulo.php?id=".$row['idprod']."\">Editar</a><br>
                            <a href=\"agregarImagenDirecto.php?id=".$row['idprod']."\">Agregar imagen</a><br>
                            <a href=\"eliminarArticulo.php?id=".$row['idprod']."\">Eliminar</a><br>
                            <a href=\"seleccionarDescuento.php?id=".$row['idprod']."\">Aplicar descuento</a><br>
                            <a href=\"retirarDescuento.php?id=".$row['idprod']."\">Retirar descuento</a></td>";
            }
            else if (isset($_SESSION['role']) && $_SESSION['role'] == 1){
                echo "<td><a href=\"comprarAhora.php?id=".$row['idprod']."&ubi=Portada\">Comprar ahora</a><br>
                          <a href=\"agregarCarrito.php?ubi=Portada&id=".$row['idprod']."\">Agregar a mi carrito</a></td>";
            }
            echo "</tr>";
        }
        echo "</table>"; */
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