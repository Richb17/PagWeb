<?php
session_start();
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
    <h1>Sistema de control de archivos</h1>

    <?php 
    //Autenticación
    if(isset($_SESSION['username'])){
        echo "<h2>Bienvenido ". $_SESSION['username']."</h2>";
        echo "<div> <a href=\"cambiarPwd.php\"> Cambiar contraseña </a> || <a href=\"logout.php\">Cerrar sesión</a> </div>";
        if($_SESSION['role'] == 2){
            echo "<a href=\"agregarProducto.php\"> Subir un nuevo articulo al sistema </a><br>";
            echo "<a href=\"subirImagen.php\"> Subir una nueva imagen al sistema </a><br>";
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
    ?>

</body>
</html>