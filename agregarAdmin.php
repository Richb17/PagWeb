<?php
    include("funciones.php");
    //Se verifica que los datos enviados sean correctos
    if( !isset($_GET['txtUsuario']) || !isset($_GET['txtPwd'])|| 
        !isset($_GET['txtConfirm']) || !isset($_GET['txtEmail'])||
        !isset($_GET['txtNombre']) || !isset($_GET['txtApellido'])||
        !isset($_GET['txtRol'])){
            header($ruta."registroAdmin.php?err=1");
    }
    else if( $_GET['txtUsuario'] == "" || $_GET['txtPwd'] == "" || 
        $_GET['txtConfirm'] == "" || $_GET['txtEmail'] == ""||
        $_GET['txtNombre'] == "" || $_GET['txtApellido'] == "" ||
        $_GET['txtRol'] == ""){
        header($ruta."registroAdmin.php?err=2");
    }
    else if($_GET['txtPwd'] != $_GET['txtConfirm']){
        header($ruta."registroAdmin.php?err=3");
    }
    else{
        extract($_GET);
        $conexion = conectarBD();
        //ejecución de la consulta en la BD
        $consulta = "INSERT INTO `usuario`(`idusuario`, `username`, `password`, `email`, `first_name`, `last_name`, `role`) VALUES 
                    ('NULL','$txtUsuario','$txtPwd','$txtEmail','$txtNombre','$txtApellido', '$txtRol');";
        $rs = mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
        
        header($ruta."registroAdmin.php?err=0");
        //recuperar la respuesta de la ejecución de la consulta
        //si hay error 

        //Si no hay error 
    }
?>