<?php
include("include/funciones.php");
//Validar si el usuario está autenticado
if (!isset($_SESSION['idusuario'])) {
    header($ruta . "login.php");
}
echo "ACA <br>";
//identificar si se pasaron los datos por formulario
if (isset($_POST['newname'])) {
    echo "ACA <br>";
    echo $ruta . "perfil.php <br>";
    if ($_POST['newname'] != "" && $_SESSION['username'] != $_POST['newname']) {
        echo "ACA <br>";
        //Podemos actualizar la contraseña
        //abrimos conexión BD
        $conexion = conectarBD();

        $qry =  "SELECT * FROM `usuario` WHERE `idusuario` != " . $_SESSION['idusuario'] . " AND `username` = '" . $_POST['newname'] . "';";
        $res = mysqli_query($conexion, $qry);
        if (mysqli_num_rows($res) == 0) {
            $rs = mysqli_fetch_array($res);
            echo $qry = "UPDATE `usuario` SET `username`='" . $_POST['newname'] . "' WHERE `idusuario` = " . $_SESSION['idusuario'] . ";";
            mysqli_query($conexion, $qry);
            $_SESSION['username'] = $_POST["newname"];
            header($ruta . "perfil.php?us_n=0");
            mysqli_close($conexion);
        } else {
            mysqli_close($conexion);
            header($ruta . "perfil.php?us_n=1");
        }
    } else {
        header($ruta . "perfil.php?us_n=2");
    }
}
