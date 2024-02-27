<?php
include "../Models/Config.php";
include '../Models/Conexion.php';
include "../Models/Productos.php";
include '../Controllers/Carrito.php';
include '../Template/Navbar.php';
?>
<link rel="stylesheet" href="../css/Navbar.css">

<link rel="stylesheet" href="../css/Pago.css">
<?php
//RECEPCIONAR LOS DATOS 
if ($_POST) {
    $total = 0;
    //RECUPERO LA CLAVE Y LO GUARDO EN SESION 
    $SID = session_id();
    $paypalDatos = '';
    $correo = $_POST['email'];
    $estatus = 'pendiente';

    //RECOLECTA LA INFORMACIÓN PARA EL TOTAL 
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


<!-- Include the PayPal JavaScript SDK -->
<script src="https://www.paypal.com/sdk/js?client-id=test&currency=USD"></script>
<style>
    /* Media query for mobile viewport */
    @media screen and (max-width: 400px) {
        #paypal-button-container {
            width: 100%;
        }
    }

    /* Media query for desktop viewport */
    @media screen and (min-width: 400px) {
        #paypal-button-container {
            width: 250px;
        }
    }
</style>
<!-- Set up a container element for the button -->

<!--MENSAJE DEL PROCESO DEL PAGO-->
<div class="container-pago p-5">
    <div class="jumbotron text-center">
        <h1 class="display-4">¡ESTAS CERCA!</h1>
        <hr class="my-4">
        <p class="lead">Ultimo paso para realizar el pago en parpal por la cantidad de:</p>
        <h4>$ <?php echo number_format($total, 2); ?></h4>
        <div id="paypal-button-container"></div>

        <p>Después de procesar el pago se enviara un comprobante de la compra al correo electronico </p>

    </div>
</div>
<script>
    // Render the PayPal button into #paypal-button-container
    paypal.Buttons({
        // Call your server to set up the transaction
        createOrder: function(data, actions) {
            return fetch('/demo/checkout/api/paypal/order/create/', {
                method: 'post'
            }).then(function(res) {
                return res.json();
            }).then(function(orderData) {
                return orderData.id;
            });
        },

        // Call your server to finalize the transaction
        onApprove: function(data, actions) {
            return fetch('/demo/checkout/api/paypal/order/' + data.orderID + '/capture/', {
                method: 'post'
            }).then(function(res) {
                return res.json();
            }).then(function(orderData) {
                // Three cases to handle:
                //   (1) Recoverable INSTRUMENT_DECLINED -> call actions.restart()
                //   (2) Other non-recoverable errors -> Show a failure message
                //   (3) Successful transaction -> Show confirmation or thank you

                // This example reads a v2/checkout/orders capture response, propagated from the server
                // You could use a different API or structure for your 'orderData'
                var errorDetail = Array.isArray(orderData.details) && orderData.details[0];

                if (errorDetail && errorDetail.issue === 'INSTRUMENT_DECLINED') {
                    return actions.restart(); // Recoverable state, per:
                    // https://developer.paypal.com/docs/checkout/integration-features/funding-failure/
                }

                if (errorDetail) {
                    var msg = 'Sorry, your transaction could not be processed.';
                    if (errorDetail.description) msg += '\n\n' + errorDetail.description;
                    if (orderData.debug_id) msg += ' (' + orderData.debug_id + ')';
                    return alert(msg); // Show a failure message (try to avoid alerts in production environments)
                }

                // Successful capture! For demo purposes:
                console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                var transaction = orderData.purchase_units[0].payments.captures[0];
                alert('Transaction ' + transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');

                // Replace the above to show a success message within this page, e.g.
                // const element = document.getElementById('paypal-button-container');
                // element.innerHTML = '';
                // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                // Or go to another URL:  actions.redirect('thank_you.html');
            });
        }
    }).render('#paypal-button-container');
</script>
<?php
$db = new DB();
$db->connect();
?>