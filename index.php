<?php
include "Models/Config.php";
include 'Models/Conexion.php';
include 'Models/Productos.php';
include 'Controllers/Carrito.php';
include 'Template/Navbar.php';
?>

<div class="container mt-5 p-3">
    <br>
    <!--VERIFICA QUE SEA DIFERENTE DE VACÍO-->
    <?php if ($mensaje != "") { ?>
        <div class="alert alert-success">
            <?php echo $mensaje; ?>
            <a href="MostrarCarrito.php" class="badge text-bg-success">Ver carrito</a>
        </div>

    <?php } ?>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
        <?php
        $sentencia = new Productos();
        $listaProductos = $sentencia->obtenerProductos();
        $colores = ['bg-primary', 'bg-secondary', 'bg-success', 'bg-danger', 'bg-warning', 'bg-info'];
        foreach ($listaProductos as $key => $producto) {
            $colorIndex = $key % count($colores); ?>
            <div class="col" style="z-index: 997;">
                <div class="card <?= $colores[$colorIndex] ?>">
                    <div class="card-header" style="background: white; text-align:center; font-size:20px;">Titulo Del producto</div>
                    <img title="" class="card-img-top" src="" alt="" data-bs-trigger="hover focus" data-bs-toggle="popover" data-bs-content="<?= $resultado['Descripcion'] ?>" data-bs-placement="bottom" height="190x" style="z-index: 998;">

                    <div class="card-body">
                        <p><?= $producto['Nombre'] ?></p>
                        <h5 class="card-title">$ <?= $producto['Precio'] ?> pesos</h5>
                        <p class="card-text"></p>

                        <form action="" method="POST">
                            <input type="hidden" name="Id" id="Id" value="<?= openssl_encrypt($producto['Id_productos'], COD, KEY); ?>">
                            <input type="hidden" name="Nombre" id="Nombre" value="<?= openssl_encrypt($producto['Nombre'], COD, KEY); ?>">
                            <input type="hidden" name="Precio" id="Precio" value="<?= openssl_encrypt($producto['Precio'], COD, KEY); ?>">
                            <!--SOLO OBTIENE UN VALOR 1 PERO DEBE SER ITERATIVO-->
                            <input type="hidden" name="Cantidad" id="Cantidad" value="<?= openssl_encrypt(1, COD, KEY); ?>">
                            <button class="btn btn-primary" type="submit" name="btnAccion" value="Agregar">Agregar al carrito</button>
                        </form>

                    </div>
                </div>
            </div>
        <?php } ?>

    </div>
    <?php include "Models/Chat.php"; ?>

</div>


<?php
$db = new DB();
$db->connect();
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script>
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
</script>