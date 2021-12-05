<?php 
session_start();
include("funciones.php");
$msg = "";
if(isset($_POST['txtUsuario']) && isset($_POST['txtPwd'])){
    if($_POST['txtUsuario'] != "" && $_POST['txtPwd'] != ""){ 
        //Se genera la conexion a la BD
        $conexion = conectarBD(); 
        //Se genera la consulta a la BD
        $qry = "select * from usuario where username = '".$_POST['txtUsuario']."' and password = '".$_POST['txtPwd']."' ";
        $rs = mysqli_query($conexion, $qry);
        
        if(mysqli_num_rows($rs) > 0){ 
            $datosU = mysqli_fetch_array($rs);
            mysqli_close($conexion);

            //Establecer el arreglo session en el servidor
            $_SESSION['idusuario'] = $datosU["idusuario"];
            $_SESSION['username'] = $datosU["username"];
            $_SESSION['role'] = $datosU["role"];
            header("location:http://localhost/DesWeb%20PHP/Modulos/Portada.php");
        }
        else{
            $msg = "El usuario y/o la contraseña no son correctos";
        }
    }
    else{
        $msg = "Debe introducir ambos campos para iniciar sesión";
    }
}
else{
    $msg = "Debe iniciar sesión a través del formulario";
}
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        if($msg != '') echo $msg;
    ?>
</body>
</html>