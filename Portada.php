<?php
include("funciones.php");
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portada</title>
</head>
<body>
    <h1>Portada</h1>

    <?php 
    //Autenticación
    if(isset($_SESSION['username'])){
        echo "<h2>Bienvenido ". $_SESSION['username']."</h2>";
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
        }
    }
    else{
    ?>
        <h2>Inicia sesión:</h2>
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
    crearBarraBusqueda();
    $conexion = conectarBD();
    $res = $conexion->query("SELECT * FROM `productos`");
    if($res){
        echo "<table>";
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
                    echo "<img src='mostrarImagen.php?id=".$img["id"]."' width='200' height='200'><br>";
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
        echo "</table>";
    }
    mysqli_close($conexion);
    ?>

</body>
</html>