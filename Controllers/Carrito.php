<?php
session_start();

$mensaje = "";

if (isset($_POST['btnAccion'])) {

    switch ($_POST['btnAccion']) {

        case 'Agregar':

            if (is_numeric(openssl_decrypt($_POST['Id'], COD, KEY))) {
                $ID = openssl_decrypt($_POST['Id'], COD, KEY);
                $mensaje .= "Correct ID " . $ID . "<br/>";
            } else {
                $mensaje .= "ERROR ID..." . $ID . "<br/>";
            }

            if (is_string(openssl_decrypt($_POST['Nombre'], COD, KEY))) {
                $Nombre = openssl_decrypt($_POST['Nombre'], COD, KEY);
                $mensaje .= "Correct Name " . $Nombre . "<br/>";
            } else {
                $mensaje .= "ERROR NAME..." . $Nombre . "<br/>";
            }

            if (is_numeric(openssl_decrypt($_POST['Precio'], COD, KEY))) {
                $Precio = openssl_decrypt($_POST['Precio'], COD, KEY);
                $mensaje .= "Correct Price " . $Precio . "<br/>";
            } else {
                $mensaje .= "ERROR PRICE..." . $Precio . "<br/>";
            }
            if (is_numeric(openssl_decrypt($_POST['Cantidad'], COD, KEY))) {
                $Cantidad = openssl_decrypt($_POST['Cantidad'], COD, KEY);
                $mensaje .= "Correct Quantity " . $Cantidad . "<br/>";
            } else {
                $mensaje .= "ERROR Quantity..." . $Cantidad . "<br/>";
            }

            //VALIDAR LA SESION QUE LE ASIGNAMOS COMO NOMBRE CARRITO
            if (!isset($_SESSION['CARRITO'])) {
                //ALMACENAR LA INFORMACIÓN DE LOS PRODUCTOS
                $producto = array(
                    'Id_productos' => $ID,
                    'Nombre' => $Nombre,
                    'Precio' => $Precio,
                    'Cantidad' => $Cantidad,
                );
                //GENERA UN ESPACIO Y ALMACENA EL PRODUCTOS EN PRODUCTOS
                $_SESSION['CARRITO'][0] = $producto;
                $mensaje = "Producto agregado al carrito";
            } else {

                $IdProductos = array_column($_SESSION['CARRITO'], "Id_productos");
                //VERIFICA QUE NO SELECCIONE DOS VECES EL MISMO PRODUCTO
                if (in_array($ID, $IdProductos)) {
                    echo "<script>alert('El producto ya ha sido agregado');</script>";
                    //PARA QUE SOLO SE MUESTRE UNA VEZ EL MENSAJE DE LOS PRODUCTOS AGREGADOS
                    $mensaje = "";
                } else {
                    //ALMACENA MÁS PRODUCTOS 
                    $numeroProductos = count($_SESSION['CARRITO']);
                    //RECUPERA LOS DATOS
                    $producto = array(
                        'Id_productos' => $ID,
                        'Nombre' => $Nombre,
                        'Precio' => $Precio,
                        'Cantidad' => $Cantidad,

                    );
                    //SE ALMACENA Y SE CONTABILIZA
                    $_SESSION['CARRITO'][$numeroProductos] = $producto;
                    //MUESTRA MENSAJE DE QUE SE AGREGO PRODUCTOS
                    $mensaje = "Producto agregado al carrito";
                }
            }
            // $mensaje = print_r($_SESSION, true);


            break;

        case "Eliminar":
            //RECIBIMOS EL ID_PRODUCTO ENCRIPTADO
            if (is_numeric(openssl_decrypt($_POST['Id'], COD, KEY))) {
                //LO DESENCRIPTAMOS
                $ID = openssl_decrypt($_POST['Id'], COD, KEY);
                //BUSCAMOS EN ID_PRODUCTO EN UN ARREGLO
                foreach ($_SESSION['CARRITO'] as $indice => $producto) {

                    if ($producto['Id_productos'] == $ID) {
                        //OBTENER EL VALOR DE LA SESION
                        //ELIMINA EL REGISTRO DE LA SESION 
                        unset($_SESSION['CARRITO'][$indice]);
                        //////-----MODIFICAR PARA MOSTRAR UN ALERT --------///////
                        echo "<script>alert('Producto Eliminado');</script>";
                    }
                }
            } else {
                $mensaje .= "ERROR ID..." . $ID . "<br/>";
            }


            break;
    }
}
