<?php
include("include/funciones.php");
include("include/partesPag.php");
autenticado();
$msg = "";
$msgN = "";
if (isset($_GET['pwd']) && $_GET['pwd'] != "") {
    if ($_GET['pwd'] == "0") $msg = "La contraseña se actualizo correctamente";
    if ($_GET['pwd'] == "1") $msg = "La contraseña introducida no era correcta";
    if ($_GET['pwd'] == "2") $msg = "Algún campo estaba vacio";
}
if (isset($_GET['us_n']) && $_GET['us_n'] != "") {
    if ($_GET['us_n'] == "0") $msgN = "El nombre de usuario se actualizo correctamente";
    if ($_GET['us_n'] == "1") $msgN = "El nombre ya estaba ocupado";
    if ($_GET['us_n'] == "2") $msgN = "El nombre de usuario no se pudo actualizar (Formulario vacio o mismo nombre de usuario)";
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil | SoundStream</title>

    <link href="styles/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">
    <link href="styles/main.css" rel="stylesheet">


</head>

<body>

    <?php
    navbar();
    //Autenticación
    ?>
    <div class="container-fluid" style="padding:100px 0px; max-width: 1468px;">
        <?php echo "<h2 style=\"padding-top:100px;\">" . $_SESSION['username'] . "</h2>" ?>
        <div class="row">
            <div class="col-5 align-self-center">
                <div class="container" style="padding: 20px 5px 40px;">
                    <div class="card card-body" style="width: 500px;">
                        <h4 class="card-title">Cambiar contraseña</h4>
                        <?php
                        if ($msg != "") {
                            if ($_GET['pwd'] != "0") {
                                echo "
                            <div class=\"alert alert-dismissible alert-danger\" id=\"alertaPwd\">
                                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                                <strong>Oh no!</strong> $msg
                            </div>
                            ";
                            } else {
                                echo "
                            <div class=\"alert alert-dismissible alert-success\" id=\"alertaPwd\">
                                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                                <strong>Muy bien!</strong> $msg
                            </div>
                            ";
                            }
                        }
                        ?>
                        <form method="post" action="cambiarPwd.php" onsubmit="return validaFRM_P()">
                            <div class="form-floating">
                                <input type="password" class="form-control" id="txtPwdActual" name="txtPwdActual"> <label for="txtPwdActual">Contraseña Actual</label>
                            </div>
                            <br>
                            <div class="form-floating">
                                <input type="password" class="form-control" id="txtPwdNueva" name="txtPwdNueva"> <label for="txtPwdNueva">Nueva Contraseña</label>
                            </div>
                            <br>
                            <div class="form-floating">
                                <input type="password" class="form-control" id="txtConfirma" name="txtConfirma"> <label for="txtConfirma">Confirmar Contraseña</label>
                            </div>
                            <br>
                            <input type="submit" class="btn btn-primary form-control" value="Actualizar contraseña"><br><br>
                            <input type="reset" class="btn btn-danger form-control" value="Cancelar"> <br>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-5 align-self-center">
                <div class="container" style="padding: 20px 5px 40px;">
                    <div class="card card-body" style="width: 500px;">
                        <h4 class="card-title">Actualizar Username</h4>
                        <?php
                        if ($msgN != "") {
                            if ($_GET['us_n'] != "0") {
                                echo "
                                <div class=\"alert alert-dismissible alert-danger\" id=\"alertaPwd\">
                                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                                    <strong>Oh no!</strong> $msgN
                                </div>
                                ";
                            } else {
                                echo "
                                <div class=\"alert alert-dismissible alert-success\" id=\"alertaPwd\">
                                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                                    <strong>Muy bien!</strong> $msgN
                                </div>
                                ";
                            }
                        }
                        ?>

                        <form method="post" action="cambiarUserN.php" onsubmit="return validaFRM_Name()">
                            <div class="form-floating">
                                <input type="text" id="newname" class="form-control" name="newname"> <label for="newname">Nuevo Username</label>
                            </div><br>
                            <input type="button" class="btn btn-primary" value="Actualizar nombre de usuario" data-bs-toggle="modal" data-bs-target="#staticBackdropName">
                            <input type="reset" class="btn btn-danger" value="Cancelar"> <br>
                            <div class="modal fade" id="staticBackdropName" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropNameLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropNameLabel">Cambio de nombre de usuario</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Está seguro de querer cambiar su nombre de usuario?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <input type="submit" class="btn btn-primary"></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-2 align-self-center">
                <div class="container" style="padding: 20px 5px 40px;">
                    <div class="card card-body">
                        <form action="eliminarCuenta.php">
                            <input type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdropEliminar" value="Eliminar Cuenta">

                            <div class="modal fade" id="staticBackdropEliminar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropEliminarLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropEliminarLabel">Modal title</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Está seguro de querer eliminar su cuenta?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <input type="submit" class="btn btn-danger" value="Eliminar">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php
        if($_SESSION['role']==1){    
    ?>
        <div class="container-fluid" style="padding: 20px 0px; max-width: 1468px;">
            <h2>Mis Comentarios</h2>
            <?php
                $conexion = conectarBD();
                mostrarComentariosUsuario($_SESSION['username'],$conexion);
            ?>
        </div>
    <?php
        }
    footer();
    ?>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>