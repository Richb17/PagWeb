<?php
    $msg = "";
    if(isset($_GET['err']) && $_GET['err'] != ""){
        if($_GET['err'] == "0") $msg = "Se registro correctamente el usuario";
        if($_GET['err'] == "1") $msg = "Se debe utilizar el formulario de registro";
        if($_GET['err'] == "2") $msg = "Se deben llenar todos los campos";
        if($_GET['err'] == "3") $msg = "Las contraseñas no coinciden";
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
            if(document.getElementById("txtUsuario").value=="" || 
                document.getElementById("txtPwd").value=="" ||
                document.getElementById("txtEmail").value=="" ||
                document.getElementById("txtConfirm").value==""||
                document.getElementById("txtNombre").value=="" ||
                document.getElementById("txtApellido").value==""){
                    document.getElementById("msgAlerta").innerHTML = "Por favor llene todos los campos.";
                    return false;
                }
            else if(document.getElementById("txtPwd").value != document.getElementById("txtConfirm").value){
                document.getElementById("msgAlerta").innerHTML = "Las contraseñas no coinciden, debe introducir la misma contraseña en ambos campos";
                document.getElementById("txtPwd").value="";
                document.getElementById("txtConfirm").value="";
                return false;
            }
            else{
                return true;
            }
        }
    </script>
</head>
<body>
    <h1>Sistema de contorl de archivos</h1>
    <form method="get" action="registraUsuario.php" onsubmit="return validaFRM()">
        <h3>Formulario de registro de usuario</h3>

        <?php 
            if($msg != "" ){
                echo "<div id=\"msgAlerta\"> $msg </div>";
            }
            else{
                echo "<div id=\"msgAlerta\"></div>";
            }
        ?>
        
        Ingresa tu nombre de usuario: <input type="text" id="txtUsuario" name = "txtUsuario"><br>
        Escriba su nombre: <input type="text" id="txtNombre" name = "txtNombre"><br>
        Escriba sus apellidos: <input type="text" id="txtApellido" name = "txtApellido"><br>
        Escribe tu dirección de E-Mail: <input type="email" id="txtEmail" name = "txtEmail"><br>
        Escribe tu contraseña: <input type="password" id="txtPwd" name = "txtPwd"><br>
        Confirma tu contraseña: <input type="password" id="txtConfirm" name = "txtConfirm"><br>
        <input type="submit" value="Regístrame">
        <input type="reset" value="Cancelar"> <br>
        Regresar a inicio <a href="portada.php">Portada</a>
    </form>
</body>
</html>