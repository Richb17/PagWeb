<?php
include("include/funciones.php");
autenticado();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>
</head>
<body>
    <h2>Pedidos</h2>
    <a href="portada.php">Regresar a inicio </a>
    <?php
if($_SESSION['role']>1){
    $conexion = conectarBD();
    $res = $conexion->query("SELECT * FROM `detalles_pedido`");
    if($res){
        echo "<table>";
        echo "<tr>";
        echo "<td>ID pedido</td>";
        echo "<td>ID Usuario</td>";
        echo "<td>Total Pagado</td>";
        echo "<td>Fecha de pedido</td>";
        echo "<td>Dirección</td>";
        echo "<td>Descripción</td>";
        echo "<td>Status</td>";
        echo "</tr>";
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            echo "<tr>";
            echo "<td>".$row['id']."</td>";
            echo "<td>".$row['id_user']."</td>";
            echo "<td>".$row['total']."</td>";
            echo "<td>".$row['created_at']."</td>";
            $dir = $conexion->query("SELECT `address_line1` FROM `direccion_usuario` WHERE `id`=".$row['iddireccion']);
            $rs = $dir->fetch_array(MYSQLI_ASSOC);
            echo "<td>".$rs['address_line1']."</td>";
            echo "<td>".$row['descripcion']."</td>";
            echo "<td>".$row['status']."</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    else{
        echo "<h2>No hay pedidos para mostrar</h2>";
    }
}
else{
    $conexion = conectarBD();
    $res = $conexion->query("SELECT * FROM `detalles_pedido` WHERE `id_user`=".$_SESSION['idusuario']);
    if($res){
        echo "<table>";
        echo "<tr>";
        echo "<td>ID pedido</td>";
        echo "<td>Total Pagado</td>";
        echo "<td>Fecha de pedido</td>";
        echo "<td>Dirección</td>";
        echo "<td>Descripción</td>";
        echo "<td>Status</td>";
        echo "</tr>";
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
            echo "<tr>";
            echo "<td>".$row['id']."</td>";
            echo "<td>".$row['total']."</td>";
            echo "<td>".$row['created_at']."</td>";
            $dir = $conexion->query("SELECT `address_line1` FROM `direccion_usuario` WHERE `id`=".$row['iddireccion']);
            $rs = $dir->fetch_array(MYSQLI_ASSOC);
            echo "<td>".$rs['address_line1']."</td>";
            echo "<td>".$row['descripcion']."</td>";
            echo "<td>".$row['status']."</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    else{
        echo "<h2>No hay pedidos para mostrar</h2>";
    }
}
?>
</body>
</html>
