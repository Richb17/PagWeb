<?php
include("include/funciones.php");
include("include/partesPag.php");
$msg = "";
if (isset($_GET['reg']) && $_GET['reg'] != "") {
    if ($_GET['reg'] == "0") $msg = "Se registro correctamente el usuario";
    if ($_GET['reg'] == "1") $msg = "Se debe utilizar el formulario de registro";
    if ($_GET['reg'] == "2") $msg = "Se deben llenar todos los campos";
    if ($_GET['reg'] == "3") $msg = "Las contraseñas no coinciden";
}
if (isset($_GET['log']) && $_GET['log'] != "") {
    if ($_GET['log'] == "1") $msg = "El usuario y/o la contraseña no son correctos";
    if ($_GET['log'] == "2") $msg = "Debe introducir ambos campos para iniciar sesión";
    if ($_GET['log'] == "3") $msg = "Debe iniciar sesión a través del formulario";
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | SoundStream</title>

    <link href="styles/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">
    <link href="styles/main.css" rel="stylesheet">

</head>

<body>

    <?php
    navbar();
    //Autenticación
    ?>
    <div class="container-fluid" style="padding:200px 0px; max-width: 1468px;">
        <div class="row justify-content-center">
            <div class="col-4 align-self-center">
                <div class="card text-center">
                    <div class="card-header">
                        <h3>Inicia Sesión</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        if ($msg != "" && isset($_GET['log'])) {
                            if ($_GET['log'] != "0") {
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
                        <form method="post" action="login.php">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="txtUsuario" name="txtUsuario" placeholder="usuario"><br>
                                <label for="txtUsuario">Usuario</label>
                            </div>
                            <div class="form-floating">
                                <input type="password" class="form-control" id="txtPwd" name="txtPwd" placeholder="Contraseña"><br>
                                <label for="txtPwd">Contraseña</label>
                            </div>
                            <input type="submit" class="btn btn-primary" value="Iniciar Sesión">
                            <input type="reset" class="btn btn-secondary" value="Cancelar"> <br>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-2"></div>
            <div class="col-5 align-self-center">
                <div class="card text-center">
                    <div class="card-header">
                        <h3>Registrate</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        if ($msg != "" && isset($_GET['reg'])) {
                            if ($_GET['reg'] != "0") {
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
                        <form method="get" action="registraUsuario.php" class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="txtUsuario" name="txtUsuario" placeholder="usuario"><br>
                                    <label for="txtUsuario">Nombre de usuario</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" type="email" id="txtEmail" name="txtEmail" placeholder="email"><br>
                                    <label for="txtEmail">E-Mail</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="input-group">
                                    <span class="input-group-text">Nombre y apellidos</span>
                                    <input type="text" type="text" id="txtNombre" name="txtNombre" aria-label="First name" class="form-control">
                                    <input type="text" type="text" id="txtApellido" name="txtApellido" aria-label="Last name" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" type="password" id="txtPwd" name="txtPwd" placeholder="Contraseña"><br>
                                    <label for="txtPwd">Contraseña</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" type="password" id="txtConfirm" name="txtConfirm" placeholder="Confirmar Contraseña"><br>
                                    <label for="txtConfirm">Confirmar contraseña</label>
                                </div>
                            </div>

                            <input type="submit" class="btn btn-primary" value="Regístrame">
                            <input type="reset" class="btn btn-secondary"value="Cancelar">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php
    footer();
    ?>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>