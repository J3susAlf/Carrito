<?php

class Productos extends DB
{

    function obtenerProductos()
    {
        $query = $this->connect()->query('SELECT * FROM productos');
        return $query;
    }
    /*
    PARA GUARDAR LOS DATOS DEL PAGO, LO PONEMOS 
    COMO PARAMETROS PARA ALMACENARLO EN EL ARCHIVO PAGAR
    */
    function guardarventa($claveTransaccion, $paypalDatos, $correo, $total, $estatus, $Precio, $Cantidad, $Id_productos)
    {
        //PONEMOS LA FECHA ACTUAL 
        date_default_timezone_set("America/Mexico_City");
        $fecha = date("Y-m-d H:i:s");

        try {
            //PREPARA LA CONSULTA SQL PARA PREVENCION DE INYECCION
            //EL ERROR ERA QUE SE CREABA DOS INSTANCIAS DIFERENTES CON CONNECT POR LO QUE SIEMPRE ERA CERO
            $pdo = $this->connect();  // Almacena la instancia de la conexión en una variable
            $query = $pdo->prepare('INSERT INTO ventas (Id_ventas, ClaveTransaccion, PaypalDatos, Fecha, Correo, Total, Estatus) VALUES 
        (NULL,:claveTransaccion, :paypalDatos, :fecha, :correo, :total, :estatus)');

            // Asigna valores a los parámetros usando bindParam
            $query->bindParam(':claveTransaccion', $claveTransaccion);
            $query->bindParam(':paypalDatos', $paypalDatos);
            $query->bindParam(':fecha', $fecha);
            $query->bindParam(':correo', $correo);
            $query->bindParam(':total', $total);
            $query->bindParam(':estatus', $estatus);

            // Ejecuta la consulta de inserción
            $query->execute();

            // Obtiene el último ID insertado usando la misma instancia de PDO
            $ultimoId = $pdo->query("SELECT LAST_INSERT_ID()")->fetchColumn();
            echo "EL ULTIMO ID ES: ", $ultimoId;
        } catch (PDOException $e) {
            echo "Error en la inserción: " . $e->getMessage();
        }

        // var_dump($Id_productos);
        // Segunda consulta
        if ($Id_productos !== null) {
            $query2 = $this->connect()->prepare('INSERT INTO detalle_venta (Id_Detalle_De_Venta, Id_Ventas, Id_productos, Precio_Unitario, Cantidad, Descargado) VALUES 
        (NULL, :Id_Ventas, :Id_productos, :Precio_Unitario, :Cantidad, 0)');
            $query2->bindParam(':Id_Ventas', $ultimoId);
            $query2->bindParam(':Id_productos', $Id_productos);
            $query2->bindParam(':Precio_Unitario', $Precio);
            $query2->bindParam(':Cantidad', $Cantidad);

            // Ejecuta la segunda consulta
            $query2->execute();
        } else {
            // Manejo de error o mensaje informativo si 'Id_productos' es nulo
            echo "Error: 'Id_productos' es nulo.";
        }

        //return $ultimoId;
    }


    function DetalleVenta()
    {
    }
}
