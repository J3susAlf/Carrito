<?php
include "Models/Config.php";
include 'Controllers/Carrito.php';
include 'Template/Navbar.php';
?>
<link rel="stylesheet" href="css/MostrarCarrito.css">
<div class="container">
    <div class="container ">
        <h3 class="">Lista de productos</h3>
        <?php if (!empty($_SESSION['CARRITO'])) { ?>

            <table class="table table-dark table-bordered">
                <tbody>
                    <tr>
                        <th width="40%">Nombre</th>
                        <th class="text-center" width="15%">Precio</th>
                        <th class="text-center" width="20%">Cantidad</th>
                        <th class="text-center" width="20%">Total</th>
                        <th class="text-center" width="5%">--</th>
                    </tr>
                    <!--ALMACENA DE FORMA TEMPORAL DEL PRECIO DE LA COMPRA TOTAL-->
                    <?php $total = 0; ?>
                    <!--NOS PERMITE DESPLEGAR TODOS LOS PRODUCTOS QUE ESTAN EN EL CARRITO-->
                    <?php foreach ($_SESSION['CARRITO'] as $indice => $producto) { ?>

                        <tr>
                            <td class="text-center" width="40%"><?= $producto['Nombre'] ?></td>
                            <td class="text-center" width="15%"><?= $producto['Precio'] ?></td>
                            <td class="text-center" width="20%"><?= $producto['Cantidad'] ?></td>
                            <td class="text-center" width="20%"><?= number_format($producto['Precio'] * $producto['Cantidad'], 2); ?></td>
                            <td class="text-center" width="5%">
                                <!--ENVIAR EL ID_PRODUCTO QUE QUEREMOS ELIMINAR-->
                                <form action="" method="post">
                                    <!--ENCRIPTAMOS EL ID_PRODUCTO-->
                                    <input type="hidden" name="Id" id="Id" value="<?= openssl_encrypt($producto['Id_productos'], COD, KEY); ?>">
                                    <button name="btnAccion" value="Eliminar" class="btn btn-danger" type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        <?php $total = $total + ($producto['Precio'] * $producto['Cantidad']); ?>
                    <?php }
                    //echo $producto['Id_productos']; 
                    ?>
                    <tr>
                        <td colspan="3" align="right">
                            <h3>Total</h3>
                        </td>
                        <td align="right">
                            <h3>$<?php echo number_format($total, 2); ?></h3>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <form action="Views/pagar.php" method="post">
                                <div class="alert alert-success" role="alert">
                                    <div class="form-group">
                                        <label for="my-input">Correo:</label>
                                        <input id="email" name="email" class="form-control" type="email" placeholder="Ingresar Correo" required>
                                    </div>
                                    <small id="emailHelp" class="form-text text-muted">
                                        Te avisaremos cuando los productos se envien a este correo
                                    </small>

                                </div>
                                <button class="btn btn-primary btn-lg btn-block" type="submit" value="proceder" name="btnAccion">Proceder a pagar</button>

                            </form>
                        </td>
                    </tr>

                </tbody>
            </table>
        <?php } else { ?>
            <div class="alert alert-success">
                No hay productos agregados
            </div>
        <?php } ?>
    </div>



</div>