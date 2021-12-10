<?php 
include("include/funciones.php");
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
            header($ruta."Portada.php");
        }
        else{
            header($ruta."iniciarSesion.php?log=1");
        }
    }
    else{
        header($ruta."iniciarSesion.php?log=2");
    }
}
else{
    header($ruta."iniciarSesion.php?log=3");
}
?>