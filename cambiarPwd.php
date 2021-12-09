<?php
    include("include/funciones.php");
    $msg = "";
    //Validar si el usuario está autenticado
    if(!isset($_SESSION['idusuario'])){
        header($ruta."login.php");
    }
    //identificar si se pasaron los datos por formulario
    if(isset($_POST['txtPwdActual']) && isset($_POST['txtPwdNueva']) && isset($_POST['txtConfirma'])){
        if($_POST['txtPwdActual']!="" && $_POST['txtPwdNueva']!="" && $_POST['txtConfirma']!=""){
            //Podemos actualizar la contraseña
            //abrimos conexión BD
            $conexion = conectarBD();
            
            $qry =  "SELECT `password` FROM `usuario` WHERE `idusuario` = ". $_SESSION['idusuario'].";";
            $res = mysqli_query($conexion,$qry);
            
            $rs = mysqli_fetch_array($res);
            if($rs['password'] == $_POST['txtPwdActual']){
                $qry = "UPDATE `usuario` SET `password`='".$_POST['txtPwdNueva']."' WHERE idusuario = ". $_SESSION['idusuario']." and password = '". $_POST['txtPwdActual']."';";
                mysqli_query($conexion,$qry);
                $msg = "La contraseña se actualizo correctamente";
                mysqli_close($conexion);
            }
            else{
                $msg = "La contraseña introducida no era correcta";
                mysqli_close($conexion);
            }
        }
    }
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script type="text/javascript">
        function validaFRM(){
            if(document.getElementById("txtPwdActual").value=="" || 
                document.getElementById("txtPwdNueva").value=="" ||
                document.getElementById("txtConfirma").value==""){
                    document.getElementById("msgAlerta").innerHTML = "Por favor llene todos los campos.";
                    return false;
                }
            else if(document.getElementById("txtPwdNueva").value != document.getElementById("txtConfirma").value){
                document.getElementById("msgAlerta").innerHTML = "Las contraseñas no coinciden, debe introducir la misma contraseña en ambos campos";
                document.getElementById("txtPwdNueva").value="";
                document.getElementById("txtPwdActual").value="";
                document.getElementById("txtConfirma").value="";
                return false;
            }
            else if(document.getElementById("txtPwdNueva").value == document.getElementById("txtPwdActual").value){
                document.getElementById("msgAlerta").innerHTML = "Su nueva contraseña no puede ser la misma que la anterior";
                document.getElementById("txtPwdNueva").value="";
                document.getElementById("txtPwdActual").value="";
                document.getElementById("txtConfirma").value="";
                return false;
            }
            else{
                return true;
            }
        }
    </script>
</head>
<body>
    <h1>Sistema de control de archivos</h1>
    <form method="post" action="cambiarPwd.php" onsubmit="return validaFRM()">
        <h3>Formulario de cambio de contraseña</h3>

        <?php 
            if($msg != "" ){
                echo "<div id=\"msgAlerta\"> $msg </div>";
            }
            else{
                echo "<div id=\"msgAlerta\"></div>";
            }
        ?>
        
        Ingresa la contraseña actual: <input type="password" id="txtPwdActual" name="txtPwdActual"><br>
        Ingresa tu nueva contraseña: <input type="password" id="txtPwdNueva" name="txtPwdNueva"><br>
        Confirma tu contraseña: <input type="password" id="txtConfirma" name="txtConfirma"><br>
        <input type="submit" value="Actualizar contraseña">
        <input type="reset" value="Cancelar"> <br>
        <a href="portada.php">Regresar a inicio</a>
    </form>
</body>
</html>