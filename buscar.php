<?php
include("include/funciones.php");
include("include/partesPag.php");
//cadena de conexion
$conexion = conectarBD();
//DEBO PREPARAR LOS TEXTOS QUE VOY A BUSCAR si la cadena existe
if(!isset($_POST['busqueda'])){
    header($ruta."Portada.php");
}

extract($_POST);
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busqueda | SoundStream</title>

    <link href="styles/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">
    <link href="styles/main.css" rel="stylesheet">
</head>
<body>
<?php
navbar();
echo "<h2 style=\"padding-top:100px;\">Resultado Busqueda</h2>"; 
?>
<div class="container-fluid" style="padding:40px 100px 70px;">
        <div class="row justify-content-start">
            <div class="col-9">
                <div class="row row-cols-1 row-cols-md-3 g-4">
<?php
if ($busqueda!=''){
    //CUENTA EL NUMERO DE PALABRAS
    $trozos=explode(" ",$busqueda);
    $numero=count($trozos);
    if ($numero==1) {
        //SI SOLO HAY UNA PALABRA DE BUSQUEDA SE ESTABLECE UNA INSTRUCION CON LIKE
        $consulta="SELECT * FROM `productos` WHERE `albumname` LIKE '$busqueda' OR `artistname` LIKE '$busqueda' OR `genre` LIKE '$busqueda' OR `format` LIKE '$busqueda' LIMIT 50";
    } 
    elseif ($numero>1) {
        //SI HAY UNA FRASE SE UTILIZA EL ALGORTIMO DE BUSQUEDA AVANZADO DE MATCH AGAINST
        //busqueda de frases con mas de una palabra y un algoritmo especializado
        $consulta="SELECT * , MATCH ( `albumname`,`artistname`,`genre`,`format` ) AGAINST ( '$busqueda' ) AS `Score` FROM `productos` WHERE MATCH ( `albumname`,`artistname`,`genre`,`format` ) AGAINST ( '$busqueda' ) ORDER BY `Score` DESC LIMIT 50";
    }
    
    $res = $conexion->query($consulta);
    if(mysqli_num_rows($res)>0){
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            prodCard($row['idprod'],"allProductos");
        }
    }
    else{
        echo "<h3>No hubo resultados para su busqueda</h3>";
    }
    mysqli_close($conexion);
}
else{
    ?>
    <h3>Por favor introduzca una busqueda</h3>
    <?php
}
echo "
                </div>
            </div>
        </div>
    </div>
    ";
footer();
?>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>