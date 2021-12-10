<?php
    include("include/funciones.php");
    //Validar si el usuario está autenticado
    if(!isset($_SESSION['idusuario'])){
        header($ruta."login.php");
    }
    echo "ACA <br>";
    //identificar si se pasaron los datos por formulario
    if(isset($_POST['txtPwdActual']) && isset($_POST['txtPwdNueva']) && isset($_POST['txtConfirma'])){
        echo "ACA <br>";
        echo $ruta."perfil.php <br>";
        if($_POST['txtPwdActual']!="" && $_POST['txtPwdNueva']!="" && $_POST['txtConfirma']!=""){
            echo "ACA <br>";
            //Podemos actualizar la contraseña
            //abrimos conexión BD
            $conexion = conectarBD();
            
            $qry =  "SELECT `password` FROM `usuario` WHERE `idusuario` = ". $_SESSION['idusuario'].";";
            $res = mysqli_query($conexion,$qry);
            
            $rs = mysqli_fetch_array($res);
            if($rs['password'] == $_POST['txtPwdActual']){
                $qry = "UPDATE `usuario` SET `password`='".$_POST['txtPwdNueva']."' WHERE idusuario = ". $_SESSION['idusuario']." and password = '". $_POST['txtPwdActual']."';";
                mysqli_query($conexion,$qry);
                header($ruta."perfil.php?pwd=0");
                
                mysqli_close($conexion);
            }
            else{
                header($ruta."perfil.php?pwd=1");
                
                mysqli_close($conexion);
            }
        }
        else{
            header($ruta."perfil.php?pwd=2");
        }
    }
?>