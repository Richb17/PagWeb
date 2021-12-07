<?php
include("funciones.php");
//cadena de conexion
$conexion = conectarBD();
//DEBO PREPARAR LOS TEXTOS QUE VOY A BUSCAR si la cadena existe
if(!isset($_POST['busqueda'])){
    header($ruta."Portada.php");
}

extract($_POST);
echo "<a href=\"portada.php\">Regresar a inicio</a><br>";
crearBarraBusqueda();
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
    
    $result = $conexion->query($consulta);

    if(mysqli_num_rows($result) > 0){
        echo "<table>";
        echo "<tr>";
        echo "<td>Id</td>";
        echo "<td>Nombre album</td>";
        echo "<td>Artista</td>";
        echo "<td>Precio</td>";
        echo "<td>Cantidad en stock</td>";
        echo "<td>Descripción</td>";
        echo "<td>Genero</td>";
        echo "<td>Formato</td>";
        echo "<td>Imagenes</td>";
        if(isset($_SESSION['role']) && $_SESSION['role'] > 1){
            echo "<td>Edición</td>";
        }
        echo "<td>Compra-Venta</td>";
        echo "</tr>";
        while($row = $result->fetch_array(MYSQLI_ASSOC)){
            echo "<td>".$row['idprod']."</td>";
            echo "<td>".$row['albumname']."</td>";
            echo "<td>".$row['artistname']."</td>";
            $precio = precioDescuentoItem($row['idprod']);
            echo "<td>$precio</td>";
            $value = conseguirStock($row['idprod']);
            echo "<td>".$value."</td>";
            echo "<td>".$row['description']."</td>";
            echo "<td>".$row['genre']."</td>";
            echo "<td>".$row['format']."</td>";
            echo "<td>";
            $imageQRY = $conexion->query("SELECT * FROM `imagenes` WHERE `idprod` = ".$row['idprod']);
            if($imageQRY){
                while($img = $imageQRY->fetch_array(MYSQLI_ASSOC)){
                    echo "<img src='mostrarImagen.php?id=".$img["id"]."' width='200' height='200'><br>";
                }
            }
            echo "</td>";
            if(isset($_SESSION['role']) && $_SESSION['role'] > 1){
                echo "<td><a href=\"editarArticulo.php?id=".$row['idprod']."\">Editar</a><br>
                            <a href=\"agregarImagenDirecto.php?id=".$row['idprod']."\">Agregar imagen</a><br>
                            <a href=\"eliminarArticulo.php?id=".$row['idprod']."\">Eliminar</a><br>
                            <a href=\"seleccionarDescuento.php?id=".$row['idprod']."\">Aplicar descuento</a><br>
                            <a href=\"retirarDescuento.php?id=".$row['idprod']."\">Retirar descuento</a></td>";
            }
            else if (isset($_SESSION['role']) && $_SESSION['role'] == 1){
                echo "<td><a href=\"comprar.php?id=".$row['idprod']."\">Comprar ahora</a><br>
                          <a href=\"agregarCarrito.php?id=".$row['idprod']."\"&ubi=\"Portada.php\">Agregar a mi carrito</a></td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }
    else{
        echo "<h3>No hubo resultados para su busqueda</h3>";
    }
    mysqli_close($conexion);
}
else{
    echo "<h3>Por favor introduzca una busqueda</h3>";
}
?>