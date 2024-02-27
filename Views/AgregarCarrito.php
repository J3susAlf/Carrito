<div class="container">
    <div class="row justify-content-between">

        <div class="col-sm- col-md-7" style="background-color: red;">
            <div class="card mb-3">
                <div class="row ">
                    <div class="card-header text-center">
                        Lista de productos
                    </div>
                    <div class="col-md-3 ">
                        <img src="img/jocho.png" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-sm-5 col-md-7">
                        <?php foreach ($_SESSION['CARRITO'] as $indice => $producto) { ?>

                            <div class="card-body">

                                <div class="row ">
                                    <div class="col col-lg-3">
                                        <h6 class="mb-2"><?= $producto['Nombre']; ?></h6> <!-- Reemplaza 'Nombre' con la clave real de tu array que contiene el nombre del producto -->
                                    </div>
                                    <div class="col-md-4">
                                        <small>Cantidad: <?= $producto['Cantidad']; ?></small>
                                        <div class="input-group ">
                                            <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon1"><i class="fa-solid fa-plus"></i></button>
                                            <input type="text" class="form-control" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1" oninput="validarCantidad()">
                                            <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon1"><i class="fa-solid fa-minus"></i></button>

                                        </div>
                                    </div>
                                    <div class="col col-lg-5 d-flex justify-content-end  ">
                                        <?= $producto['Precio'] ?>
                                    </div>
                                </div>


                                <form action="" method="post">
                                    <input type="hidden" name="Id" id="Id" value="<?= openssl_encrypt($producto['ID'], COD, KEY); ?>">
                                    <button name="btnAccion" value="Eliminar" class="btn btn-danger" type="submit">Eliminar</button>
                                </form>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-5 offset-sm-2 col-md-5 offset-md-0" style="background-color: blue;">
            <div class="card">
                <div class="card-header">
                    Resumen de compra
                </div>

                <div class="card-body">
                    <?php foreach ($_SESSION['CARRITO'] as $indice => $producto) { ?>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div></div>
                            <h5 class="card-title float-end mb-0"><?= number_format($producto['Precio'] * $producto['Cantidad'], 2); ?></h5>
                        </div>
                    <?php } ?>
                    <h3 class="text-end">$<?php echo number_format($total, 2); ?></h3>
                    <button class="btn btn-primary btn-lg btn-block" type="submit" value="proceder" name="btnAccion">Proceder a pagar</button>
                </div>



            </div>
        </div>
    </div>
</div>