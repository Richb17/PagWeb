<?php
    include("include/funciones.php");
    //Se verifica que los datos enviados sean correctos
    if( !isset($_GET['txtUsuario']) || !isset($_GET['txtPwd'])|| 
        !isset($_GET['txtConfirm']) || !isset($_GET['txtEmail'])||
        !isset($_GET['txtNombre']) || !isset($_GET['txtApellido'])){
            header($ruta."iniciarSesion.php?reg=1");
    }
    else if( $_GET['txtUsuario'] == "" || $_GET['txtPwd'] == "" || 
        $_GET['txtConfirm'] == "" || $_GET['txtEmail'] == ""||
        $_GET['txtNombre'] == "" || $_GET['txtApellido'] == "" ){
        header($ruta."iniciarSesion.php?reg=2");
    }
    else if($_GET['txtPwd'] != $_GET['txtConfirm']){
        header($ruta."iniciarSesion.php?reg=3");
    }
    else{
        extract($_GET);
        $conexion = conectarBD();
        //ejecución de la consulta en la BD
        $consulta = "INSERT INTO `usuario`(`idusuario`, `username`, `password`, `email`, `first_name`, `last_name`, `role`) VALUES 
                    ('NULL','$txtUsuario','$txtPwd','$txtEmail','$txtNombre','$txtApellido', '1');";
        $rs = mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
        
        header($ruta."iniciarSesion.php?reg=0");
    }
?>