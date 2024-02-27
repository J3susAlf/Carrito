<?php
include "../Models/Config.php";
include '../Models/Conexion.php';
include "../Models/Productos.php";
include '../Controllers/Carrito.php';

?>

<?php
//RECEPCIONAR LOS DATOS 
if ($_POST) {
    $total = 0;
    //RECUPERO LA CLAVE Y LO GUARDO EN SESION 
    $SID = session_id();
    $paypalDatos = '';
    $correo = $_POST['email'];
    $estatus = 'pendiente';

    foreach ($_SESSION['CARRITO'] as $indice => $producto) {
        $total = $total + ($producto['Precio'] * $producto['Cantidad']);
        //SE CONECTA AL METODO PRODUCTOS 
        $sentencia = new Productos();
        //LO INSERTA EN LA TABLA VENTAS 
        $result = $sentencia->guardarventa($SID, $paypalDatos, $correo, $total, $estatus, $producto['Precio'], $producto['Cantidad'],  $producto['Id_productos']);
        echo "<h3>" . $total . "</h3>";
    }
    //$Id_productos = $producto['Id_productos'];


}

?>
<?php
$db = new DB();
$db->connect();
?>

